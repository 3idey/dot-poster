<x-header title="checkout" />

<x-layout>

    <h1 class="text-2xl font-semibold mb-4">Checkout</h1>

    @if ($errors->any())
        <div class="mb-4 text-red-400">{{ implode(', ', $errors->all()) }}</div>
    @endif

    @if ($items->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <div class="space-y-3 mb-6">
            @foreach ($items as $i)
                <div class="flex items-center justify-between bg-gray-900 p-3 rounded-xl">
                    <div>
                        <div class="font-medium">{{ $i->product->name }}</div>
                        <div class="text-sm text-gray-400">
                            {{ $i->quantity }} × ${{ number_format($i->product->price, 2) }}
                        </div>
                    </div>
                    <div class="font-semibold">
                        ${{ number_format($i->quantity * $i->product->price, 2) }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mb-4 text-xl">Total: <strong>${{ number_format($total, 2) }}</strong></div>

        <form method="POST" action="{{ route('checkout.store') }}" class="space-y-3">
            @csrf

            @if (!$user->address)
                <label class="block">
                    <span class="text-sm text-gray-300">Shipping Address</span>
                    <input type="text" name="shipping_address" class="mt-1 w-full rounded-lg px-3 py-2 text-black"
                        placeholder="Enter shipping address" required>
                </label>
            @else
                <div class="text-sm text-gray-300">
                    Shipping to: <span class="font-medium text-gray-100">{{ $user->address }}</span>
                </div>
            @endif

            <button class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700">Place Order (COD)</button>
        </form>
    @endif
</x-layout>
<x-footer />
