<x-header title="Orders" />

<x-layout>
    <h1 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-gray-100">My Orders</h1>

    @if (session('success'))
        <div class="mb-4 rounded bg-green-50 dark:bg-green-900/40 border border-green-200 dark:border-green-600 text-green-800 dark:text-green-200 px-4 py-2">
            {{ session('success') }}
        </div>
    @endif

    @if ($orders->isEmpty())
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">No orders yet</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-6">Start shopping to see your orders here</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-700 dark:hover:bg-emerald-800 text-white rounded-lg transition-colors">
                Browse Products
            </a>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($orders as $o)
                <a href="{{ route('orders.show', $o) }}" class="block bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-medium text-gray-900 dark:text-gray-100 text-xl">Order #{{ $o->id }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-300">{{ $o->created_at->format('M d, Y \a\t H:i') }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm uppercase text-emerald-600 dark:text-emerald-400 tracking-wide font-medium">{{ $o->status }}</div>
                            <div class="font-semibold text-emerald-600 dark:text-emerald-400">${{ number_format($o->total_amount, 2) }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</x-layout>
<x-footer />
