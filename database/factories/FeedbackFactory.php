<?php

namespace Database\Factories;

use App\Models\Sales;
use App\Models\Customer;
use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Feedback::class;
    public function definition(): array
    {
        return [
            "sales_id"=> Sales::inRandomOrder()->value("sales_id"),
            "rating"=> fake()->numberBetween(1,5),
            "comment"=> fake()->sentence,
        ];
    }
}
