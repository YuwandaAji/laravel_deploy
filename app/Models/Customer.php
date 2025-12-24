<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable {
    use HasFactory;
    protected $fillable = ["customer_name", "customer_address", "customer_number", "customer_email", "customer_password", "customer_dateborn", "customer_img"];
    protected $table = "customer";
    protected $primaryKey = "customer_id";

    public function sales(): HasMany {
        return $this->hasMany(Sales::class, "customer_id", "customer_id");
    }
}