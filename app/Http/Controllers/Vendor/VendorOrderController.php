<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdate;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VendorOrderController extends Controller
{
    public function index()
    {
        // Only show orders that contain products from this vendor
        $vendorId = auth()->user()->id;
        $orders = Order::with(['user', 'orderItems.product'])
            ->whereHas('orderItems.product', function ($query) use ($vendorId) {
                $query->where('vendor_id', $vendorId);
            })
            ->latest()
            ->paginate(10);

        return view('vendor.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        // Ensure vendor can only update orders containing their products
        $vendorId = auth()->user()->id;
        $hasVendorProducts = $order->orderItems()->whereHas('product', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })->exists();

        if (! $hasVendorProducts) {
            abort(403, 'Unauthorized to update this order.');
        }

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

    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);

        // Ensure vendor can only view orders containing their products
        $vendorId = auth()->user()->id;
        $hasVendorProducts = $order->orderItems()->whereHas('product', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })->exists();

        if (! $hasVendorProducts) {
            abort(403, 'Unauthorized to view this order.');
        }

        return view('vendor.orders.show', compact('order'));
    }
}
