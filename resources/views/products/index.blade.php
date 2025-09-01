<x-header title="Products" />
<x-layout>

    <h1 class="text-3xl font-semibold mb-6">Posters</h1>

    {{-- Search and Filter Form --}}
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Search --}}
            <div>
                <input type="text" name="search" placeholder="Search posters..." 
                    value="{{ request('search') }}" class="w-full border rounded p-2">
            </div>
            
            {{-- Category Filter --}}
            <div>
                <select name="category" class="w-full border rounded p-2">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            {{-- Price Range --}}
            <div class="flex space-x-2">
                <input type="number" name="min_price" placeholder="Min $" 
                    value="{{ request('min_price') }}" class="w-full border rounded p-2">
                <input type="number" name="max_price" placeholder="Max $" 
                    value="{{ request('max_price') }}" class="w-full border rounded p-2">
            </div>
            
            {{-- Sort --}}
            <div class="flex space-x-2">
                <select name="sort" class="flex-1 border rounded p-2">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
            </div>
        </form>
    </div>

    <div class=" grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($products as $p)
            @php $img = $p->image ? asset('storage/' . $p->image) : ($p->images->first()?->image_url ?? asset('images/placeholder.jpg')); @endphp
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
