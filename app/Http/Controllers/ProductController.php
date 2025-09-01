<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::with(['images' => fn ($q) => $q->orderByDesc('is_main')])
            ->where('status', true);

        // Search functionality
        if (request('search')) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%'.request('search').'%')
                    ->orWhere('description', 'like', '%'.request('search').'%');
            });
        }

        // Category filter
        if (request('category')) {
            $query->where('category_id', request('category'));
        }

        // Price filter
        if (request('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }
        if (request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        // Sort options
        $sort = request('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = \App\Models\Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with(['images', 'category'])->findOrFail($id);

        return view('products.show', compact('product'));
    }
}
