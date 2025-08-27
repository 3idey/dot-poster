<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = auth()->user()
            ->cartItems()
            ->with(['product.images' => fn($q) => $q->orderByDesc('is_main')])
            ->get();

        $total = $items->sum(fn($i) => $i->quantity * $i->product->price);

        return view('cart.index', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);
        $qty = $data['quantity'] ?? 1;

        $product = Product::findOrFail($data['product_id']);
        abort_if(! $product->status || $product->stock < 1, 400, 'Unavailable');

        $item = CartItem::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $product->id],
            ['quantity' => 0]
        );

        $item->increment('quantity', $qty);

        return back()->with('success', 'Added to cart');
    }

    public function update(Request $request, CartItem $item)
    {
        $this->authorize('update', $item); // optional policy
        $data = $request->validate(['quantity' => ['required', 'integer', 'min:1']]);
        $item->update(['quantity' => $data['quantity']]);

        return back()->with('success', 'Quantity updated');
    }

    public function destroy(CartItem $item)
    {
        $this->authorize('delete', $item); // optional policy
        $item->delete();

        return back()->with('success', 'Removed from cart');
    }
}
