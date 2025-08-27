<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store()
    {
        $user = auth()->user();
        $items = $user->cartItems()->with('product')->get();
        abort_if($items->isEmpty(), 400, 'Cart is empty');

        DB::transaction(function () use ($user, $items) {
            $total = $items->sum(fn ($i) => $i->quantity * $i->product->price);

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_address' => $user->address,
                'payment_method' => 'cash',
            ]);

            foreach ($items as $i) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $i->product_id,
                    'quantity' => $i->quantity,
                    'price' => $i->product->price,
                ]);

                // reduce stock
                $i->product->decrement('stock', $i->quantity);
            }

            // clear cart
            $user->cartItems()->delete();
        });

        return redirect()->route('cart.index')->with('success', 'Order placed!');
    }
}
