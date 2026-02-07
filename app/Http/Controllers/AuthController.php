<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Order;
use App\Models\Sales;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registration() {
        $data['meta_title'] = 'Registration';
        return view('login', $data);
    }

    public function register_post(Request $request) {
        $customer = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:customer,customer_email',
            'password' => 'required|min:5|max:50',
        ]);
        $customer = new Customer;
        $customer -> customer_name = trim( $request->name );
        $customer -> customer_email = trim( $request->email );
        $customer -> password = Hash::make( $request->password );
        $customer -> customer_img = 'customer_img/default_profile.png';
        $customer -> save();

        Auth::login($customer);
        return redirect('home')->with('success','Register Succesfully');
    }

    public function login() {
        $data['meta_title'] = 'Login';
        return view('login', $data);
    }

    public function login_post(Request $request) {
        $credential = request()->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:50',
        ]);

        $check = $request->all();
        $data = [
            'customer_email'=> $check['email'],
            'password'=> $check['password'],
        ];

        if (Auth::attempt($data)) {
            $request->session()->regenerate();
            return redirect('home')->with('success','Login Succesfully');
        }

        return back()->with('errorLogin','Login Failed');
    }

    public function login_post_admin(Request $request) {
        $request->validate([
            'email' => 'required|email|unique:customer,customer_email',
            'password' => 'required|min:5|max:50',
        ]);

        $check = $request->all();
        $data = [
            'email'=> $check['email'],
            'password'=> $check['password'],
        ];

        if(Auth::guard('employees')->attempt($data)) {
            return redirect(url('admin/dashboard'))->with('success','Login Succesfully');
        }else {
            return back()->with('errorLogin','Login Failed');
        } 
    
    }

    public function home() {
        return view('home');
    }

    public function products() {
        $products = Product::all();
        return view('home', compact('products'));
    }

    public function order() {
        $products = Product::all();
        return view('order', compact('products'));
    }

    public function order_post(Request $request) {
        $request->validate([
            'order_type' => 'required',
            'payment_type' => 'required',
            'total_price' => 'required|numeric',
            'items' => 'required|array'
        ]);

        if (!Auth::check()) {
            return response()->json(['message' => 'Sesi login habis, silakan login ulang'], 401);
        }

        try {
            // Gunakan Transaction agar jika salah satu stok gagal dikurangi, 
            // data Sales tidak akan tersimpan (mencegah data error)
            \DB::transaction(function () use ($request) {

                $sales = new Sales();
                $sales->customer_id = Auth::guard('web')->id();
                $sales->order_method = $request->order_type; 
                $sales->payment_id = $request->payment_type; 
                $sales->sales_status = 'New'; 
                $sales->pay_status = '1'; 
                $sales->save();

                foreach ($request->items as $item) {
                    // 1. Simpan ke tabel Order (Pivot)
                    $order = new Order();
                    $order->sales_id = $sales->sales_id;
                    $order->product_id = $item['id'];
                    $order->order_quantity = $item['qty'];
                    $order->save();

                    // 2. LOGIKA PENGURANGAN STOK
                    // Ambil data produk berdasarkan ID dari item yang dibeli
                    $product = Product::find($item['id']);
                    
                    if ($product) {
                        // Cek stok cukup atau tidak (Opsional tapi sangat disarankan)
                        if ($product->product_stock < $item['qty']) {
                            throw new \Exception("Stok produk {$product->product_name} tidak mencukupi.");
                        }
                        
                        // Kurangi stoknya
                        $product->decrement('product_stock', $item['qty']);
                    }
                }
            });

            return response()->json(['status' => 'success','message' => 'Pesanan berhasil disimpan dan stok berkurang!'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
        }
    }

    public function profile() {
        $customer = Auth::user();
        return view('profile', compact('customer'));
    }

    public function edit() {
        $customer = Auth::guard('web')->user();
        return view('edit', compact('customer'));
    }
    

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function update(Request $request) {
        $customer_id = Auth::guard('web')->id();
        $customer = Customer::find($customer_id);

        $request->validate([
            'customer_name' => 'required|max:255',
            'customer_address' => 'nullable',
            'customer_img' => 'image|mimes:jpeg,png,jpg|max:2048' // max 2MB
        ]);

        $customer->customer_name = $request->customer_name;
        $customer->customer_address = $request->customer_address;

        $imageName = 'default_profile.png';
        if ($request->hasFile('customer_img')) {
            $imageName = $request->file('customer_img')->store('customer_img', 'public');
        }
        $customer->customer_img = $imageName;

        $customer->save();

        return redirect('profile')->with('success', 'Profil berhasil diperbarui!');
    }
    
    public function front() {
        $products = Product::all();
        return view('front', compact('products'));
    }

    private function attachTotalNominal($sales) {
        foreach ($sales as $sale) {
            foreach ($sale->products as $product) {
                $product->subtotal_item = $product->product_price * $product->pivot->order_quantity;
            }
            $sale->total_nominal = $sale->products->sum('subtotal_item');
        }
        return $sales;
    }

    public function your_order() {
        $sales = Sales::with(['products'])
                    ->where('customer_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();
        $sales = $this->attachTotalNominal($sales);
        return view('your_order', compact( 'sales'));
    }

    public function your_order_search(Request $request) {
        $sales = Sales::with(['products'])
            ->where('customer_id', Auth::id()) 
            ->when($request->search, function ($query) use ($request) {
                return $query->where(function($q) use ($request) {
                    $q->where('sales_id', 'LIKE', '%' . $request->search . '%')
                    ->orWhereHas('products', function($pq) use ($request) {
                        $pq->where('product_name', 'LIKE', '%' . $request->search . '%');
                    });
                });
            })
            ->when($request->status, function ($query) use ($request) {
                return $query->where('sales_status', $request->status);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        $sales = $this->attachTotalNominal($sales);

        return view('your_order', compact('sales'));
    }

};
