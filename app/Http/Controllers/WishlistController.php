<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wishlistItems = auth()->user()->wishlistProducts()->with('category', 'images')->paginate(12);

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = auth()->user();
        $productId = $request->product_id;

        // Check if already in wishlist
        if ($user->wishlists()->where('product_id', $productId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist',
            ], 409);
        }

        $user->wishlists()->create([
            'product_id' => $productId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist',
            'wishlist_count' => $user->wishlists()->count(),
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = auth()->user();
        $user->wishlists()->where('product_id', $request->product_id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist',
            'wishlist_count' => $user->wishlists()->count(),
        ]);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = auth()->user();
        $productId = $request->product_id;

        $wishlistItem = $user->wishlists()->where('product_id', $productId)->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $inWishlist = false;
            $message = 'Removed from wishlist';
        } else {
            $user->wishlists()->create(['product_id' => $productId]);
            $inWishlist = true;
            $message = 'Added to wishlist';
        }

        return response()->json([
            'success' => true,
            'in_wishlist' => $inWishlist,
            'message' => $message,
            'wishlist_count' => $user->wishlists()->count(),
        ]);
    }
}
