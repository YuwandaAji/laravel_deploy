<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Employee::class;
    protected $role = ["Waiter", "Barista", "Manager", "Courier", "Cashier"];
    public function definition(): array
    {

        return [
            "employee_name" => fake()->name(),
            "employee_email" => fake()->unique()->safeEmail(),
            "password" => fake()->password(),
            "employee_address" => fake()->address(),
            "employee_number" => fake()->phoneNumber(),
            "employee_date_born" => fake()->date(),
            "employee_salary" => fake()->numberBetween(2000000, 5000000),
            "employee_role" => fake()->randomElement($this->role),
            "employee_img" => fake()->image(category:"people"),
            "employee_date_join" => fake()->date(),
            "employee_gender"=>fake()->boolean()
        ];
    }
}
