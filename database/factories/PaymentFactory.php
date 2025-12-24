<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * 
     */
    protected $model = Payment::class;
    protected $category = ["E-Wallet", "E-Bank", "COC", "COD"];
    public function definition(): array
    {
        return [
            "payment_name"=>fake()->name,
            "payment_category"=>fake()->randomElement($this->category),
            "payment_status"=>fake()->boolean()
        ];
    }
}
