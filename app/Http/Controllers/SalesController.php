<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function sales() {
        $sales = Sales::with(['products', 'customers'])->get();
        return view("sales", compact("sales"));
    }

    public function sales_search(Request $request) {
        $sales = Sales::when($request->search, function ($query) use ($request) {
            return $query
            ->whereAny([
                'sales_id',
                'sales_status'
            ], 'LIKE', '%' . $request->search . '%');
        })
            ->when($request->status, function ($query) use ($request) {
            return $query->where('sales_status', $request->status);
        })->get();
        return view('sales', compact('sales'));
    }

    public function sale($sales_id) {
        $sale = Sales::with(['products', 'customers'])->where('sales_id', $sales_id)->firstOrFail();

        foreach ($sale->products as $product) {
  
            $qty = $product->pivot->order_quantity ?? 0;

            $price = $product->product_price ?? 0;

            $product->subtotal_item = $price * $qty;
        }

        $total_akhir = $sale->products->sum('subtotal_item');

        return view("sale", compact('sale', 'total_akhir'));
    }
}
