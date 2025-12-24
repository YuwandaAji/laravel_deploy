<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Sales;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Order::class;
    public function definition(): array
    {
        
        return [
            "sales_id"=> Sales::inRandomOrder()->value("sales_id"),
            "product_id"=> Product::inRandomOrder()->value("product_id"),
            "price"=> Product::inRandomOrder()->value("product_price"),
            "order_quantity"=>fake()->numberBetween(1,5)
        ];
    }
}
