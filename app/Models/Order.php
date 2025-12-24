<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Order extends Model {
    use HasFactory;
    protected $fillable = ["sales_id","product_id", "price", "order_quantity"];
    protected $table = "order";
    protected $primaryKey = "order_id";

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class, "product","product_id");
    }

    public function sales(): BelongsToMany {
        return $this->belongsToMany(Sales::class, "sales","sales_id" );
    }
}