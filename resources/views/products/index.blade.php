<x-header title="Products" />
<x-layout>

    <h1 class="text-3xl font-semibold mb-6">Posters</h1>

    <div class=" grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($products as $p)
            @php $img = $p->images->first()?->image_url; @endphp
            <div class="bg-gray-900 rounded-2xl p-4 shadow">
                <a href="{{ route('products.show', $p->id) }}">
                    <img src="{{ $img }}" alt="{{ $p->name }}"
                        class="w-full h-64 object-cover rounded-xl mb-3">
                    <h3 class="text-lg font-medium text-white">{{ $p->name }}</h3>
                </a>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-xl font-semibold text-white">${{ number_format($p->price, 2) }}</span>
                    @auth
                        <form method="POST" action="{{ route('cart.store') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $p->id }}">
                            <button class="px-3 py-2 rounded-xl text-white bg-emerald-600 hover:bg-emerald-700">Add to
                                cart</button>
                        </form>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>

</x-layout>
<x-footer />
