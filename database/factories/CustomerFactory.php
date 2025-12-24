<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Customer::class;
    public function definition(): array
    {
        return [
            "customer_name" => fake()->name(),
            "customer_email" => fake()->unique()->safeEmail(),
            "customer_password" => fake()->password(),
            "customer_address" => fake()->address(),
            "customer_number" => fake()->phoneNumber(),
            "customer_dateborn" => fake()->date(),
            "customer_img" => fake()->image(),
        ];
    }
}
