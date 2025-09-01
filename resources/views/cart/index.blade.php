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
                            class="w-20 rounded-lg text-black px-2 py-1">
                        <button class="px-3 py-2  text-white rounded-xl bg-blue-600 hover:bg-blue-700">Update</button>
                    </form>
                    <form method="POST" action="{{ route('cart.destroy', $item->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-2 text-white rounded-xl bg-red-600 hover:bg-red-700">Remove</button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex items-center justify-between">
            <div class="text-2xl font-semibold">Total: ${{ number_format($total, 2) }}</div>
            <a href="{{ route('checkout.index') }}" class="px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 inline-block text-center">
                Proceed to Checkout
            </a>
        </div>
    @endif

</x-layout>
<x-footer />
