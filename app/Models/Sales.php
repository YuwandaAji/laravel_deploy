<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sales extends Model {
    use HasFactory;
    protected $fillable = ["sales_id", "customer_id", "payment_id", "sales_status", "pay_status", "order_method"];
    protected $table = "sales";
    protected $primaryKey = "sales_id";

    public function customers(): BelongsTo {
        return $this->belongsTo(Customer::class, "customer_id", "customer_id");
    }

    public function feedbacks(): HasOne {
        return $this->hasOne(Feedback::class, "feedback_id");
    }

    public function payments(): BelongsTo {
        return $this->belongsTo(Payment::class, "payment_id", "payment_id");
    }

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class, "order", "sales_id", "product_id")->withPivot("order_quantity");
    }

    public function getTotalHargaProdukAttribute()
    {
        return $this->products->sum(function($product) {
            return $product->product_price * $product->pivot->order_quantity;
        });
    }

    public function getTotalBelanjaAttribute()
    {
        $ongkir = 0;
        $diskon = 0;
        return ($this->total_harga_produk - $diskon) + $ongkir;
    }
}