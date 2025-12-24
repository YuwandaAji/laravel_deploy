<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function products() {
        $products = Product::all();
        return view("products", compact("products"));
    }

    public function products_add(Request $request) {
        $request->validate([
            'name' => 'required',
            'product_img' => 'image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'required',
            'size'=> 'required',
            'stock' => 'required',
            'category' => 'required|in:Coffe,Signature,Snack',
            'description'=> 'required',
        ]);

        $imageName = 'default_profile.png';
        if ($request->hasFile('product_img')) {
            $imageName = $request->file('product_img')->store('product_img', 'public');
        }

        $product = new Product();
        $product->product_name = trim($request->name);
        $product->product_img = $imageName; // Menyimpan path gambar
        $product->product_size = $request->size;
        $product->product_stock = $request->stock;
        $product->product_category = $request->category;
        $product->product_description = trim($request->description);
        $product->product_price = str_replace('.', '', $request->price);
        
        // Simpan ke database
        $product->save();

        return redirect('admin/products')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function products_search(Request $request) {
        $products = Product::when($request->search, function ($query) use ($request) {
            return $query
            ->whereAny([
                'product_name',
                'product_category'
            ], 'LIKE', '%' . $request->search . '%');
        })
            ->when($request->category, function ($query) use ($request) {
            return $query->where('product_category', $request->category);
        })->get();
        return view('products', compact('products'));
    }

    public function product($product_id) {

    $product = Product::find($product_id);
    
    if (!$product) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan');
    }


    $todaySales = DB::table('order')
        ->where('product_id', $product_id)
        ->whereDate('created_at', Carbon::today())
        ->sum('order_quantity'); 

    $totalRevenue = DB::table('order')
        ->join('sales', 'order.sales_id', '=', 'sales.sales_id')
        ->join('product', 'order.product_id', '=', 'product.product_id')
        ->where('sales.pay_status', 1)
        ->where('order.product_id', $product_id)
        ->sum(DB::raw('product.product_price * order.order_quantity')); 

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
    
    $chartMonths = $salesData->pluck('month')->toArray();
    $chartTotals = $salesData->pluck('total')->toArray();

    return view('product', compact('product', 'todaySales', 'totalRevenue', 'chartMonths', 'chartTotals'));
    }

    public function edit(Request $request, $product_id) {
        $product = Product::find($product_id);
    
        $request->validate([
            'name' => 'required',
            'product_img' => 'image|mimes:jpeg,png,jpg|max:2048',
            'price' => 'required',
            'size'=> 'required',
            'stock' => 'required',
            'category' => 'required|in:Coffe,Signature,Snack',
            'description'=> 'required',
        ]);


        $product->product_name = trim($request->name);
        $product->product_size = $request->size;
        $product->product_stock = $request->stock;
        $product->product_category = $request->category;
        $product->product_description = trim($request->description);
        $product->product_price = str_replace('.', '', $request->price);

        if ($request->hasFile('product_img')) {

            if ($product->product_img && $product->product_img != 'default_profile.png') {
                Storage::disk('public')->delete($product->product_img);
            }

            $imageName = $request->file('product_img')->store('product_img', 'public');
            $product->product_img = $imageName;
        }

        $product->save();

        return redirect('admin/products/' . $product_id)->with('success', 'Produk berhasil diperbarui!');
        
    }

    public function delete($product_id) {
        $product = Product::findOrFail($product_id);

        $product->sales()->detach();

        if ($product->product_img && $product->product_img != 'default_profile.png') {
            Storage::disk('public')->delete($product->product_img);
        }

        $product->delete();

        return redirect('admin/products')->with('success', 'Karyawan dan seluruh data terkait berhasil dihapus!');
    }
    
}
