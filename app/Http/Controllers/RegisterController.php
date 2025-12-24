<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('login');
    }

    // Memproses data register
    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 2. Membuat User Baru
        $customer = Customer::create([
            'customer_name' => $request->name,
            'customer_email' => $request->email,
            'customer_password' => Hash::make($request->password), // WAJIB DI-HASH
        ]);

        // 3. Login Otomatis (Opsional)
        Auth::guard('customer')->login($customer);

        // 4. Redirect ke Dashboard/Halaman Utama
        return redirect('/'); // Ganti dengan route yang Anda inginkan
    }
}
