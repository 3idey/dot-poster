<x-header title="Cart" />
<x-layout>
    <h1 class="text-3xl font-semibold mb-6">Your Cart</h1>

    @if ($items->isEmpty())
        <p>No items yet.</p>
    @else
        <div class="space-y-4">
            @foreach ($items as $item)
                <div class="flex items-center gap-4 bg-gray-900 p-4 rounded-2xl">
                    <img src="{{ $item->product->images->first()->image_url ?? '' }}"
                        class="w-20 h-24 object-cover rounded-xl">
                    <div class="flex-1">
                        <div class="font-medium">{{ $item->product->name }}</div>
                        <div class="text-gray-400">${{ number_format($item->product->price, 2) }}</div>
                    </div>
                    <form method="POST" action="{{ route('cart.update', $item->id) }}" class="flex items-center gap-2">
                        @csrf @method('PATCH')
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                            class="w-20 rounded-lg bg-gray-700 border border-gray-600 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200">
                        <button class="px-3 py-2 text-white rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">Update</button>
                    </form>
                    <form method="POST" action="{{ route('cart.destroy', $item->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-2 text-white rounded-xl bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">Remove</button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex items-center justify-between">
            <div class="text-2xl font-semibold">Total: ${{ number_format($total, 2) }}</div>
            <a href="{{ route('checkout.index') }}"
                class="px-5 py-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 inline-block text-center shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                Proceed to Checkout
            </a>
        </div>
    @endif

</x-layout>
<x-footer />
