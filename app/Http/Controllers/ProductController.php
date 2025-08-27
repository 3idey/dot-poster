<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['images' => fn ($q) => $q->orderByDesc('is_main')])
            ->where('status', true)
            ->latest()
            ->paginate(12);

        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with(['images', 'category'])->findOrFail($id);

        return view('products.show', compact('product'));
    }
}
