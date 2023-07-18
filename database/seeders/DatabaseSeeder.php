<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Product::factory(100)->create();
        \App\Models\Order::factory(40)->create();

        // For Query to Retrieve Users Who Have Purchased All Products:
        for ($i=0; $i<3; $i++) {
            $user = User::inRandomOrder()->first();
            $products = Product::get();
            foreach ($products as $product) {
                $quantity = rand(1, 10);
                Order::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'total_amount' => $quantity * $product->price,
                ]);
            }
        }
    }
}
