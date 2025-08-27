<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['Abstract', 'Nature', 'City', 'Typography', 'Minimal'];
        foreach ($names as $n) {
            Category::factory()->create(['name' => $n, 'slug' => Str::slug($n)]);
        }
    }
}
