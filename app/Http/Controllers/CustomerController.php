<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customers() {
        $customers = Customer::all();
        return view("customers", compact("customers"));
    }

    public function customers_search(Request $request) {
        $customers = Customer::when($request->search, function ($query) use ($request) {
            return $query
            ->whereAny([
                'customer_name',
            ], 'LIKE', '%' . $request->search . '%');
        })->get();
        return view('customers', compact('customers'));
    }

    public function customer($customer_id) {
        $customer = Customer::with(['sales.products'])->findOrFail($customer_id);

        $totalPurchase = $customer->sales->count();

        $totalExpenses = $customer->sales->reduce(function ($carry, $sales) {
            return $carry + $sales->products->sum(function ($product) {
                return $product->product_price * $product->pivot->order_quantity;
            });
        }, 0);

        return view('customer', compact('customer', 'totalPurchase', 'totalExpenses'));
        }
}
