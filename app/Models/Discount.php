<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Discount extends Model {
    use HasFactory;
    protected $fillable = ["discount_name", "percent", "discount_start", "discount_end"];
    protected $table = "discount";
    protected $primaryKey = "discount_id";

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class, "product_id");
    }
}