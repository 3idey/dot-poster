<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        Product::factory()
            ->count(40)
            ->create()
            ->each(function ($product) {
                // 1–3 images per product (use placeholders)
                $count = rand(1, 3);
                for ($i = 0; $i < $count; $i++) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => "https://picsum.photos/seed/{$product->id}-{$i}/800/1000",
                        'is_main' => $i === 0,
                    ]);
                }
            });
    }
}
