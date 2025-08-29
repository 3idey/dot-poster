<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // User: own orders; Admin: all orders
    public function index(Request $request)
    {
        $user = $request->user();

        $orders = $user->role === 'admin'
            ? Order::with('orderItems.product', 'user')->latest()->paginate(15)
            : $user->orders()->with('orderItems.product')->latest()->paginate(15);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load('orderItems.product', 'user');

        return view('orders.show', compact('order'));
    }
}
