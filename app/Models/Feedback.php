<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Feedback extends Model {
    use HasFactory;
    protected $fillable = ["rating", "comment"];
    protected $table = "feedback";
    protected $primaryKey = "feedback_id";

    public function sales(): BelongsTo {
        return $this->belongsTo(Sales::class, "sales_id");
    }
}