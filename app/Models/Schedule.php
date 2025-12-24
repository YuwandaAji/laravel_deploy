<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model {
    use HasFactory;
    protected $fillable = ["shift", "schedule_day"];
    protected $table = "schedule";
    protected $primaryKey = "schedule_id";

    public function employees(): BelongsToMany {
        return $this->belongsToMany(Employee::class, "employee_schedule", "schedule_id", "employee_id");
    }

}