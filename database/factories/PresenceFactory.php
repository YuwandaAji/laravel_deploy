<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Presence;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Presence>
 */
class PresenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Presence::class;
    protected $status = ["Present", "Absent", "Sick", "Permission"];
    public function definition(): array
    {
        return [
            "employee_id"=> Employee::inRandomOrder()->value("employee_id"),
            "status_presence"=> fake()->randomElement($this->status),
            "presence_date"=> fake()->date(min(2025, now())),
            "checkin"=> fake()->dateTime(),
            "checkout"=> fake()->dateTime()
        ];
    }
}
