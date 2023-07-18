<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;

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
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $product = Product::inRandomOrder()->first();
        $quantity = rand(1, 10);
        return [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'total_amount' => $quantity * $product->price,
        ];
    }
}
