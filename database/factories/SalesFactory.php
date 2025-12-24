<?php

namespace Database\Factories;

use App\Models\Sales;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sales>
 */


class SalesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Sales::class;
    protected $status = ["New", "Prepared", "Delelivery", "Done"];
    public function definition(): array
    {
        return [
            "customer_id"=> Customer::inRandomOrder()->value("customer_id"),
            "payment_id"=> Payment::inRandomOrder()->value("payment_id"),
            "sales_status"=> fake()->randomElement($this->status),
            "pay_status"=>fake()->boolean(50)
        ];
    }
}
