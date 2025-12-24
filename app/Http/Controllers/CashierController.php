<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Product;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function cashier() {
        return view("cashier");
    }

    public function sales() {
        $sales = Sales::with(['products', 'customers'])->get();

        foreach ($sales as $sale) {
        $sale->total_belanja = $sale->products->sum('price');
        }

        $newSales = $sales->where('sales_status', 'New');
        $preparedSales = $sales->where('sales_status', 'Prepared');
        $deliverySales = $sales->where('sales_status', 'Delivery');
        $doneSales = $sales->where('sales_status', 'Done');


        $totalNew = $newSales->sum('total_belanja');
        $totalPrepared = $preparedSales->sum('total_belanja');
        $totalDelivery = $deliverySales->sum('total_belanja');
        $totalDone = $doneSales->sum('total_belanja');

        return view("cashier", compact(
            'newSales', 'preparedSales', 'deliverySales', 'doneSales',
            'totalNew', 'totalPrepared', 'totalDelivery', 'totalDone'
        ));
    }

    public function cashier_search(Request $request) {
        $search = $request->search;

        $sales = Sales::with(['products', 'customers']) 
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('sales_id', 'LIKE', '%' . $search . '%')
                    ->orWhere('sales_status', 'LIKE', '%' . $search . '%')
 
                    ->orWhereHas('customers', function ($q_cust) use ($search) {
                        $q_cust->where('customer_name', 'LIKE', '%' . $search . '%');
                    })
                    
                    ->orWhereHas('products', function ($q_prod) use ($search) {
                        $q_prod->where('product_name', 'LIKE', '%' . $search . '%');
                    });
                });
            })
            ->get();

        $newSales = $sales->where('sales_status', 'New');
        $preparedSales = $sales->where('sales_status', 'Prepared');
        $deliverySales = $sales->where('sales_status', 'Delivery');
        $doneSales = $sales->where('sales_status', 'Done');


        $totalNew = $newSales->sum('total_belanja');
        $totalPrepared = $preparedSales->sum('total_belanja');
        $totalDelivery = $deliverySales->sum('total_belanja');
        $totalDone = $doneSales->sum('total_belanja');
        return view('cashier', compact('sales', 'totalNew', 'totalPrepared', 'totalDelivery', 'totalDone', 'newSales', 'preparedSales', 'deliverySales', 'doneSales',));
    }

    public function detail($sales_id) {
        $sale = Sales::with(['products', 'customers'])->where('sales_id', $sales_id)->firstOrFail();

        foreach ($sale->products as $product) {
        $qty = $product->pivot->order_quantity ?? 1;
        $product->subtotal_item = $product->product_price * $qty;
        }


        $total_akhir = $sale->products->sum('subtotal_item');

        return view("cash_detail", compact('sale', 'total_akhir'));
    }

    public function update_status(Request $request, $id) {
        $sale = Sales::findOrFail($id);
        $sale->sales_status = $request->status;
        $sale->save();

        return response()->json(['success' => true]);
    }

    public function cashier_new() {
        $sale = Sales::all();
        $products = Product::all(); 
    
        $coffee = $products->where('product_category', 'Coffee');
        $snack = $products->where('product_category', 'Snack');
        $signature = $products->where('product_category', 'Signature');

        return view("new_cash", compact('coffee', 'snack', 'signature', 'sale'));
    }
}
