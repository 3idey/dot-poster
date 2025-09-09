<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::take(10)->get();

        if ($users->count() > 0 && $products->count() > 0) {
            foreach ($products as $product) {
                // Create 2-4 reviews per product
                for ($i = 0; $i < rand(2, 4); $i++) {
                    $user = $users->random();
                    
                    // Avoid duplicate reviews from same user
                    if (!$product->reviews()->where('user_id', $user->id)->exists()) {
                        Review::create([
                            'product_id' => $product->id,
                            'user_id' => $user->id,
                            'rating' => rand(3, 5),
                            'comment' => $this->getRandomComment($product->name)
                        ]);
                    }
                }
            }
        }
    }

    private function getRandomComment($productName)
    {
        $comments = [
            "Great quality poster! Very happy with my purchase.",
            "Beautiful design and excellent printing quality.",
            "Fast shipping and the poster looks amazing on my wall.",
            "Exactly what I was looking for. Highly recommended!",
            "The colors are vibrant and the paper quality is good.",
            "Perfect for my room decoration. Love it!",
            "Good value for money. Will order more.",
            "Nice poster, arrived in perfect condition.",
            "Really happy with this purchase. Great product!",
            "Beautiful artwork and good quality printing."
        ];

        return $comments[array_rand($comments)] . " Perfect for decorating my space.";
    }
}
