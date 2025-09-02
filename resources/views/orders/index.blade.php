<x-header title="Orders" />

<x-layout>
    <h1 class="text-2xl font-semibold mb-6">My Orders</h1>

    @if (session('success'))
        <div class="mb-4 rounded bg-green-900/40 border border-green-600 px-4 py-2">
            {{ session('success') }}
        </div>
    @endif

    @if ($orders->isEmpty())
        <p>No orders yet.</p>
    @else
        <div class="space-y-3">
            @foreach ($orders as $o)
                <a href="{{ route('orders.show', $o) }}" class="block bg-gray-900 p-4 rounded-xl hover:bg-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-medium text-white text-xl">Order #{{ $o->id }}</div>
                            <div class="text-sm text-white">{{ $o->created_at->format('Y-m-d H:i') }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm uppercase text-emerald-300 tracking-wide">{{ $o->status }}</div>
                            <div class="font-semibold text-emerald-500 ">${{ number_format($o->total_amount, 2) }}</div>
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
