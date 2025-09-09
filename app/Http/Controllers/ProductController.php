<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::with(['images' => fn($q) => $q->orderByDesc('is_main')])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('status', true);

        // Search functionality
        if (request('search')) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('description', 'like', '%' . request('search') . '%');
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
        // Ensure ID is numeric to prevent route parameter injection
        if (!is_numeric($id)) {
            abort(404);
        }
        
        $id = (int) $id;
        
        // Get product with all needed relationships
        $product = Product::with([
            'images' => fn($q) => $q->orderByDesc('is_main'),
            'category',
            'reviews' => fn($q) => $q->with('user')->latest()->take(10)
        ])
        ->withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->where('status', true) // Only show active products
        ->findOrFail($id);

        // Update session recently viewed list: keep unique, most-recent-first, max 5
        $recentlyViewed = session()->get('recently_viewed', []);

        if (!is_array($recentlyViewed)) {
            $recentlyViewed = [];
        }

        // Build a clean list: remove this id if present, prepend it, enforce uniqueness and limit
        $recentlyViewed = collect($recentlyViewed)
            ->map(fn ($v) => (int) $v)
            ->reject(fn ($v) => $v === $id)
            ->prepend($id)
            ->unique()
            ->take(5)
            ->values()
            ->all();

        session()->put('recently_viewed', $recentlyViewed);

        // Get related products from the same category
        $relatedProducts = Product::with(['images' => fn($q) => $q->orderByDesc('is_main')])
            ->withAvg('reviews', 'rating')
            ->where('status', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
    /**
     * Display a listing of the recently viewed products.
     */
    public function recentlyViewed()
    {
        $recentlyViewedIds = session()->get('recently_viewed', []);
        
        if (empty($recentlyViewedIds) || !is_array($recentlyViewedIds)) {
            $products = collect();
        } else {
            // Normalize IDs to integers and filter out invalid ones
            $recentlyViewedIds = collect($recentlyViewedIds)
                ->map(fn ($v) => (int) $v)
                ->filter(fn ($v) => $v > 0)
                ->unique()
                ->values()
                ->all();
            
            if (empty($recentlyViewedIds)) {
                $products = collect();
            } else {
                // Get products with images and ratings, only active products
                $products = Product::with(['images' => fn($q) => $q->orderByDesc('is_main')])
                    ->withAvg('reviews', 'rating')
                    ->where('status', true)
                    ->whereIn('id', $recentlyViewedIds)
                    ->get();
                
                // Sort products to match the session order (most recent first)
                $products = $products->sortBy(function ($product) use ($recentlyViewedIds) {
                    return array_search($product->id, $recentlyViewedIds);
                })->values();
            }
        }
        
        return view('products.recently-viewed', compact('products'));
    }
}
