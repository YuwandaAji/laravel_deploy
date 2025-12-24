<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sales;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payments() {
        $payments = Payment::all();
        return view("payments", compact("payments"));
    }

    public function payments_search(Request $request) {
        $payments = Payment::when($request->search, function ($query) use ($request) {
            return $query
            ->whereAny([
                'payment_name',
                'payment_category'
            ], 'LIKE', '%' . $request->search . '%');
        })
            ->when($request->category, function ($query) use ($request) {
            return $query->where('payment_category', $request->category);
        })->get();
        return view('payments', compact('payments'));
    }

    public function payment($payment_id) {
        $payment = Payment::findOrFail($payment_id);

        $usedToday = Sales::where('payment_id', $payment_id)
            ->whereDate('created_at', Carbon::today())
            ->where('pay_status', 1) 
            ->count();

        $sales = Sales::with('products')
            ->where('payment_id', $payment_id)
            ->where('pay_status', 1)
            ->get();

        $revenue = $sales->sum(function ($sale) {
            return $sale->products->sum(function ($product) {

                return $product->product_price * $product->pivot->order_quantity;
            });
        });

        $monthlyData = Sales::where('payment_id', $payment_id)
            ->where('pay_status', 1)
            ->selectRaw('COUNT(*) as count, MONTH(created_at) as month')
            ->where('created_at', '>=', now()->subYear())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $chartData = array_fill(0, 12, 0);
        foreach ($monthlyData as $data) {
            $chartData[$data->month - 1] = $data->count;
        }

        return view("payment", compact("payment", "usedToday", "revenue", "chartData"));

    }

    public function active($payment_id){
        $payment = Payment::findOrFail($payment_id);
        
        $payment->update([
            'payment_status' => 1
        ]);

        return redirect('admin/payments/'. $payment_id)->with('success', 'Metode pembayaran berhasil diaktifkan.');
    }

    public function nonactive($payment_id){
        $payment = Payment::findOrFail($payment_id);
        
        $payment->update([
            'payment_status' => 0
        ]);

        return redirect('admin/payments/'. $payment_id)->with('success', 'Metode pembayaran berhasil dinonaktifkan.');
    }
}
