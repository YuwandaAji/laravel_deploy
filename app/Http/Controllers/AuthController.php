<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Order;
use App\Models\Sales;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function registration() {
        $data['meta_title'] = 'Registration';
        return view('login', $data);
    }

    private function uploadToCloudinary($file)
    {
        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey = env('CLOUDINARY_API_KEY');
        $apiSecret = env('CLOUDINARY_API_SECRET');

        $timestamp = time();
        $signature = sha1("timestamp={$timestamp}{$apiSecret}");

        $client = new \GuzzleHttp\Client();
        $response = $client->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
            'multipart' => [
                ['name' => 'file', 'contents' => fopen($file->getRealPath(), 'r'), 'filename' => $file->getClientOriginalName()],
                ['name' => 'api_key', 'contents' => $apiKey],
                ['name' => 'timestamp', 'contents' => $timestamp],
                ['name' => 'signature', 'contents' => $signature],
            ]
        ]);

        $result = json_decode($response->getBody(), true);
        return $result['secure_url'];
    }

    public function register_post(Request $request) {
        $customer = request()->validate([
            'name' => 'required|max:255',
            'register_email' => 'required|email:dns|unique:customer,customer_email',
            'password' => 'required|min:5|max:50',
        ]);
        $customer = new Customer;
        $customer -> customer_name = trim( $request->name );
        $customer -> customer_email = trim( $request->register_email );
        $customer -> password = Hash::make( $request->password );
        $customer -> customer_img = null;
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

        return back()->with('errorLogin', 'Email atau Password yang Anda masukkan salah.');
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
  
            \DB::transaction(function () use ($request) {

                $sales = new Sales();
                $sales->customer_id = Auth::guard('web')->id();
                $sales->order_method = $request->order_type; 
                $sales->payment_id = $request->payment_type; 
                $sales->sales_status = 'New'; 
                $sales->pay_status = '1'; 
                $sales->save();

                foreach ($request->items as $item) {

                    $order = new Order();
                    $order->sales_id = $sales->sales_id;
                    $order->product_id = $item['id'];
                    $order->order_quantity = $item['qty'];
                    $order->save();

                    $product = Product::find($item['id']);
                    
                    if ($product) {

                        if ($product->product_stock < $item['qty']) {
                            throw new \Exception("Stok produk {$product->product_name} tidak mencukupi.");
                        }
                        

                        $product->decrement('product_stock', $item['qty']);
                    }
                }
            });

            return response()->json(['status' => 'success','message' => 'Pesanan berhasil disimpan dan stok berkurang!'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan: ' . $e->getMessage()], 500);
        }
    }

    public function show(Request $request)
    {
        $customer = Auth::guard('web')->user();

        if (!$customer) {
            return redirect('login')->with('error', 'Please login first.');
        }

        $history = Sales::with('products')
                    ->where('customer_id', $customer->customer_id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('profile', [
            'customer' => $customer,
            'history' => $history,
        ]);
    }

   
    public function edit(Request $request): View
    {

        if (Auth::guard('web')->check()) {
            return view('edit', [
                'customer' => Auth::guard('web')->user(),
            ]);
        }


        return view('edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse {
        $customer = Auth::guard('web')->user();

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'nullable|string',
            'customer_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $customer->customer_name = $request->customer_name;
        $customer->customer_address = $request->customer_address;

        if ($request->hasFile('customer_img')) {
            $customer->customer_img = $this->uploadToCloudinary($request->file('customer_img'));
        }

        $customer->save(); 

        return Redirect::route('profile')->with('status', 'profile-updated');
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
