<x-header title=".poster" />
<x-layout>

    <div class="grid md:grid-cols-2 gap-8">
        <div>
            <img src="{{ $product->images->first()->image_url ?? '' }}" class="w-full  rounded-2xl">
            <div class="flex gap-3 mt-3">
                @foreach ($product->images as $img)
                    <img src="{{ $img->image_url }}" class="w-10 h-10 object-cover rounded-xl">
                @endforeach
            </div>
        </div>
        <div>
            <h1 class="text-3xl font-semibold mb-2">{{ $product->name }}</h1>
            <p class="text-gray-300 mb-4">{{ $product->description }}</p>
            <div class="text-2xl font-bold mb-6">${{ number_format($product->price, 2) }}</div>
            @auth
                <form method="POST" action="{{ route('cart.store') }}" class="flex gap-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="number" name="quantity" value="1" min="1"
                        class="w-20 rounded-lg text-black px-2 py-1">
                    <button class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700">Add to cart</button>
                </form>
            @endauth
        </div>
    </div>
</x-layout>
<x-footer />
