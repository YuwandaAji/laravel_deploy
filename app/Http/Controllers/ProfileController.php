<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Sales;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil customer dan riwayat order.
     */
    public function show(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // Jika tidak ada session customer, arahkan ke login
        if (!$customer) {
            return redirect('login')->with('error', 'Please login first.');
        }

        // Ambil riwayat order
        $history = Sales::with('products')
                    ->where('customer_id', $customer->customer_id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('customer.profile', [
            'customer' => $customer,
            'history' => $history,
        ]);
    }

    /**
     * Menampilkan form edit profil.
     */
    public function edit(Request $request): View
    {
        return view('customer.edit', [
            'customer' => Auth::guard('customer')->user(),
        ]);
    }

    /**
     * Update data profil customer (termasuk foto).
     */
    public function update(Request $request): RedirectResponse
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'nullable|string',
            'customer_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $customer->customer_name = $request->customer_name;
        $customer->customer_address = $request->customer_address;

        if ($request->hasFile('customer_img')) {
            $file = $request->file('customer_img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/customer_img'), $filename);
            $customer->customer_img = 'customer_img/' . $filename;
        }

        $customer->customer_save(); // Pastikan method save() benar, biasanya cuma $customer->save();

        return Redirect::route('customer.profile')->with('status', 'profile-updated');
    }

    /**
     * Hapus akun.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $customer = Auth::guard('customer')->user();
        
        if ($customer) {
            Auth::guard('customer')->logout();
            $customer->delete();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}