<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdate;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'payment_status' => 'nullable|in:unpaid,paid,refunded',
        ]);

        $oldStatus = $order->status;
        $order->update($validated);

        // Send email notification if status changed
        if ($oldStatus !== $validated['status']) {
            Mail::to($order->user->email)->send(new OrderStatusUpdate($order, $oldStatus));
        }

        return back()->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        // Restore stock for cancelled orders
        foreach ($order->orderItems as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        $order->delete();

        return back()->with('success', 'Order deleted and stock restored.');
    }
}
