<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $items = $user->cartItems()->with('product')->get();
        $total = $items->sum(fn ($i) => $i->quantity * $i->product->price);

        return view('checkout.index', compact('items', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,stripe',
            'payment_method_id' => 'nullable|string', // Stripe payment method ID
        ]);

        $user = auth()->user();
        $items = $user->cartItems()->with('product')->get();
        abort_if($items->isEmpty(), 400, 'Cart is empty');

        $total = $items->sum(fn ($i) => $i->quantity * $i->product->price);

        DB::transaction(function () use ($user, $items, $validated, $total) {
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_address' => $user->shipping_address ?? request()->shipping_address,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] === 'cash' ? 'pending' : 'unpaid',
            ]);

            // Handle Stripe payment
            if ($validated['payment_method'] === 'stripe') {
                $this->processStripePayment($order, $validated['payment_method_id']);
            }

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

            // Send order confirmation email
            Mail::to($user->email)->send(new OrderConfirmation($order));
        });

        return redirect()->route('orders.index')->with('success', 'Order placed!');
    }

    private function processStripePayment(Order $order, $paymentMethodId)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $order->total_amount * 100, // Convert to cents
                'currency' => 'usd',
                'payment_method' => $paymentMethodId,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('orders.show', $order),
            ]);

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'stripe',
                'transaction_id' => $paymentIntent->id,
                'amount' => $order->total_amount,
                'status' => $paymentIntent->status === 'succeeded' ? 'completed' : 'pending',
            ]);

            if ($paymentIntent->status === 'succeeded') {
                $order->update(['payment_status' => 'paid']);
            }
        } catch (\Exception $e) {
            throw new \Exception('Payment failed: '.$e->getMessage());
        }
    }
}
