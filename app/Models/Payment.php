<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Payment extends Model {
    use HasFactory;
    protected $fillable = ["payment_name","payment_category", "payment_status", "payment_img"];
    protected $table = "payment";
    protected $primaryKey = "payment_id";

    public function sales(): HasMany {
        return $this->hasMany(Sales::class, "payment_id", "payment_id");
    }
}