<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Employee extends Authenticatable {

    use HasFactory;

    protected $fillable = ["password","employee_name", "employee_address", "employee_number", "employee_gender", "employee_email", "employee_date_born", "employee_role", "employee_salary", "employee_date_join", "employee_img"];

    protected $table = "employee";
    protected $primaryKey = "employee_id";

    public function schedules(): BelongsToMany {
        return $this->belongsToMany(Schedule::class, "employee_schedule", "employee_id", "schedule_id");
    }

    public function presences(): HasMany {
        return $this->hasMany(Presence::class, "employee_id", "employee_id");
    }

    protected function shiftSiang(): Attribute
    {

        return Attribute::make(
            get: fn () => $this->schedules 
                            ->where('shift', 1) 
                            ->pluck('schedule_day') 
                            ->implode(', '), 
        );
    }

    
    protected function shiftMalam(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->schedules
                            ->where('shift', 0) 
                            ->pluck('schedule_da')
                            ->implode(', '),
        );
    }

    protected function genderText(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['employee_gender'] == 1 ? 'Male' : 'Female',
        );
    }

    public function getAuthPassword(){
        return $this->password;
    }
}