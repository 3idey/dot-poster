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
        $savedPaymentMethods = $user->savedPaymentMethods()->active()->get();

        return view('checkout.index', compact('items', 'total', 'user', 'savedPaymentMethods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,stripe,saved',
            'payment_method_id' => 'nullable|string', // Stripe payment method ID or saved payment method ID
            'save_payment_method' => 'nullable|boolean',
            'payment_nickname' => 'nullable|string|max:255',
            'shipping_address' => 'required|string|max:500',
        ]);

        $user = auth()->user();
        $items = $user->cartItems()->with('product')->get();
        abort_if($items->isEmpty(), 400, 'Cart is empty');

        $total = $items->sum(fn ($i) => $i->quantity * $i->product->price);

        DB::transaction(function () use ($user, $items, $validated, $total, $request) {
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'pending',
                'shipping_address' => $validated['shipping_address'],
                'payment_method' => $validated['payment_method'] === 'saved' ? 'stripe' : $validated['payment_method'],
                'payment_status' => $validated['payment_method'] === 'cash' ? 'pending' : 'unpaid',
            ]);

            // Handle Stripe payment (new or saved)
            if ($validated['payment_method'] === 'stripe' || $validated['payment_method'] === 'saved') {
                if ($validated['payment_method'] === 'saved') {
                    $savedPaymentMethod = $user->savedPaymentMethods()->findOrFail($validated['payment_method_id']);
                    $this->processStripePayment($order, $savedPaymentMethod->provider_payment_method_id);
                } else {
                    $this->processStripePayment($order, $validated['payment_method_id']);
                    
                    // Save payment method if requested
                    if ($validated['save_payment_method'] ?? false) {
                        $this->savePaymentMethod($user, $validated['payment_method_id'], $validated['payment_nickname'] ?? null);
                    }
                }
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

    private function savePaymentMethod($user, $stripePaymentMethodId, $nickname = null)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Retrieve payment method details from Stripe
            $paymentMethod = \Stripe\PaymentMethod::retrieve($stripePaymentMethodId);
            
            if ($paymentMethod->type === 'card') {
                $card = $paymentMethod->card;
                
                // Check if this payment method already exists
                $existing = $user->savedPaymentMethods()
                    ->where('provider_payment_method_id', $stripePaymentMethodId)
                    ->first();
                
                if (!$existing) {
                    // Set other payment methods as non-default if this is the first one
                    $isFirstPaymentMethod = $user->savedPaymentMethods()->count() === 0;
                    
                    if ($isFirstPaymentMethod) {
                        // This will be the default
                    } else {
                        // If user wants this as default, unset others
                        $user->savedPaymentMethods()->update(['is_default' => false]);
                    }
                    
                    $user->savedPaymentMethods()->create([
                        'type' => 'stripe',
                        'provider_payment_method_id' => $stripePaymentMethodId,
                        'last_four' => $card->last4,
                        'brand' => $card->brand,
                        'exp_month' => $card->exp_month,
                        'exp_year' => $card->exp_year,
                        'nickname' => $nickname,
                        'is_default' => $isFirstPaymentMethod,
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Log error but don't fail the order
            \Log::error('Failed to save payment method: ' . $e->getMessage());
        }
    }
}
