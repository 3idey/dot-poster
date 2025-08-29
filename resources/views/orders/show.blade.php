<x-header title="Your Order" />

<x-layout>
    <h1 class="text-2xl font-semibold mb-4">Order #{{ $order->id }}</h1>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-gray-900 p-4 rounded-xl">
            <div class="text-sm text-gray-400">Placed</div>
            <div class="font-medium text-white mb-3">{{ $order->created_at->format('Y-m-d H:i') }}</div>

            <div class="text-sm text-gray-400">Status</div>
            <div class="font-medium text-white mb-3">{{ $order->status }} ({{ $order->payment_status }})</div>

            <div class="text-sm text-gray-400">Ship to</div>
            <div class="font-medium text-white">{{ $order->shipping_address ?? ($order->user->address ?? '—') }}</div>
        </div>

        <div class="bg-gray-900 p-4 rounded-xl">
            <h2 class="text-lg font-semibold mb-3">Items</h2>
            <div class="space-y-2">
                @foreach ($order->orderItems as $it)
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-medium text-white">{{ $it->product->name }}</div>
                            <div class="text-sm text-gray-400">
                                {{ $it->quantity }} × ${{ number_format($it->price, 2) }}
                            </div>
                        </div>
                        <div class="font-semibold text-white">
                            ${{ number_format($it->quantity * $it->price, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-gray-700 mt-3 pt-3 flex items-center justify-between">
                <div class="text-sm text-gray-400">Total</div>
                <div class="text-xl font-bold text-white">${{ number_format($order->total_amount, 2) }}</div>
            </div>
        </div>
    </div>
</x-layout>
<x-footer />
