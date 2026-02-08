<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
        return view('login', ['meta_title' => 'Registration']);
    }

    public function register_post(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:customer,customer_email',
            'password' => 'required|min:5|max:50',
        ]);

        $customer = new Customer;
        $customer->customer_name = trim($request->name);
        $customer->customer_email = trim($request->email);
        $customer->password = Hash::make($request->password);
        $customer->customer_img = 'customer_img/default_profile.png';
        $customer->save();

        // Login menggunakan guard customer
        Auth::guard('customer')->login($customer);
        return redirect('home')->with('success','Register Successfully');
    }

    public function login() {
        return view('login', ['meta_title' => 'Login']);
    }

    public function login_post(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5|max:50',
        ]);

        $credentials = [
            'customer_email' => $request->email,
            'password' => $request->password,
        ];

        // WAJIB: Gunakan guard('customer') agar sinkron dengan route profile
        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('home')->with('success','Login Successfully');
        }

        return back()->with('errorLogin','Login Failed');
    }

    // Memperbaiki Error Undefined Variable $products
    public function home() {
        $products = Product::all(); 
        return view('home', compact('products'));
    }

    public function products() {
        $products = Product::all();
        return view('home', compact('products'));
    }

    public function order() {
        $products = Product::all();
        return view('order', compact('products'));
    }

    // Menyesuaikan ID Customer saat pesan
    public function order_post(Request $request) {
        $request->validate([
            'order_type' => 'required',
            'payment_type' => 'required',
            'total_price' => 'required|numeric',
            'items' => 'required|array'
        ]);

        if (!Auth::guard('customer')->check()) {
            return response()->json(['message' => 'Sesi login habis'], 401);
        }

        try {
            DB::transaction(function () use ($request) {
                $sales = new Sales();
                $sales->customer_id = Auth::guard('customer')->id(); // Pakai guard customer
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
                    if ($product && $product->product_stock >= $item['qty']) {
                        $product->decrement('product_stock', $item['qty']);
                    }
                }
            });
            return response()->json(['status' => 'success','message' => 'Berhasil!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }
}