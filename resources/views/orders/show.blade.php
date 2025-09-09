<x-header title="Your Order" />

<x-layout>
    <h1 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Order #{{ $order->id }}</h1>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 rounded-xl">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Details</h2>
            
            <div class="space-y-4">
                <div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Order Date</div>
                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $order->created_at->format('M d, Y \a\t H:i') }}</div>
                </div>

                <div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</div>
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300">
                            {{ $order->status }}
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">({{ $order->payment_status }})</span>
                    </div>
                </div>

                <div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Shipping Address</div>
                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $order->shipping_address ?? ($order->user->address ?? '—') }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 rounded-xl">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Items</h2>
            <div class="space-y-3">
                @foreach ($order->orderItems as $it)
                    <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                        <div>
                            <div class="font-medium text-gray-900 dark:text-gray-100">{{ $it->product->name }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                Qty: {{ $it->quantity }} × ${{ number_format($it->price, 2) }}
                            </div>
                        </div>
                        <div class="font-semibold text-gray-900 dark:text-gray-100">
                            ${{ number_format($it->quantity * $it->price, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-gray-200 dark:border-gray-700 mt-4 pt-4 flex items-center justify-between">
                <div class="text-lg font-medium text-gray-900 dark:text-gray-100">Total</div>
                <div class="text-xl font-bold text-emerald-600 dark:text-emerald-400">${{ number_format($order->total_amount, 2) }}</div>
            </div>
        </div>
    </div>
</x-layout>
<x-footer />
