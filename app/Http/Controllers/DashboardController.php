<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Feedback;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard() {
        $totalsales = Sales::count();

        $totalrevenue = DB::table('order')
            ->join('sales', 'order.sales_id', '=', 'sales.sales_id')
            ->join('product', 'order.product_id', '=', 'product.product_id') 
            ->where('sales.pay_status', 1)
            ->sum(DB::raw('product.product_price * order.order_quantity')); 
        
        $totalfeedback = Feedback::count();
        $totalcustomer = Customer::count();
        
        $topProducts = DB::table('order')
            ->join('product', 'order.product_id', '=', 'product.product_id')
            ->select('product.product_name', DB::raw('SUM(order.order_quantity) as total_qty'))
            ->groupBy('order.product_id', 'product.product_name')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        $nameProducts = $topProducts->pluck('product_name');
        $totalProduct = $topProducts->pluck('total_qty');

        $salesData = DB::table('order')
            ->join('sales', 'order.sales_id', '=', 'sales.sales_id')
            ->join('product', 'order.product_id', '=', 'product.product_id')
            ->where('sales.pay_status', 1)
            ->select(
                DB::raw('DATE(sales.created_at) as date'), 
                DB::raw('SUM(product.product_price * order.order_quantity) as total_revenue') 
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $totalLineChart = $salesData->pluck('total_revenue');
        $labelsales = $salesData->pluck('date');

        return view('dashboard', compact(
            'totalsales', 
            'totalrevenue', 
            'totalfeedback', 
            'totalcustomer', 
            'nameProducts', 
            'totalProduct', 
            'totalLineChart', 
            'labelsales'
        ));
    }

}
