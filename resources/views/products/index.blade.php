<x-header title="Products" />
<x-layout>

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100">Discover Posters</h1>
        <div class="text-gray-600 dark:text-gray-300">{{ $products->total() }} posters available</div>
    </div>

    {{-- Search and Filter Form --}}
    <div
        class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl shadow-lg dark:shadow-emerald-900 p-6 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Search --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Search</label>
                <input type="text" name="search" placeholder="Search posters..." value="{{ request('search') }}"
                    class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-3 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
            </div>

            {{-- Category Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Category</label>
                <select name="category"
                    class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-3 text-gray-900 dark:text-gray-100 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Price Range --}}
            <div>
                <label class="block text-sm font-medium  text-gray-700 dark:text-gray-200 mb-2">Price Range</label>
                <div class="flex space-x-2">
                    <input type="number" name="min_price" placeholder="Min $" value="{{ request('min_price') }}"
                        class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-3 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                    <input type="number" name="max_price" placeholder="Max $" value="{{ request('max_price') }}"
                        class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-3 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                </div>
            </div>

            {{-- Sort --}}
            <div>
                <label class="block text-sm font-medium dark:text-gray-200 text-gray-700 mb-2">Sort By</label>
                <div class="flex space-x-2">
                    <select name="sort"
                        class="flex-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-3 text-gray-900 dark:text-gray-100  focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to
                            High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High
                            to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                    </select>
                    <button type="submit"
                        class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 transform hover:scale-105">
                        Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($products as $p)
            @php $img = $p->image ? asset('storage/' . $p->image) : ($p->images->first() ? $p->images->first()->image_url : asset('images/placeholder.svg')); @endphp
            <div
                class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl p-6 shadow-lg dark:shadow-emerald-900 hover:shadow-xl dark:hover:shadow-emerald-800 transition-all duration-300 transform hover:scale-105 group">
                <a href="{{ route('products.show', $p->id) }}" class="block">
                    <div class="relative overflow-hidden rounded-xl mb-4">
                        <img src="{{ $img }}" alt="{{ $p->name }}"
                            class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110 dark:brightness-90"
                            loading="lazy">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent dark:from-black/70 dark:to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>
                    <h3
                        class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                        {{ $p->name }}</h3>
                </a>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span
                            class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">${{ number_format($p->price, 2) }}</span>
                        <div class="text-sm text-gray-600 dark:text-gray-300">
                            Stock: {{ $p->stock }} available
                        </div>
                    </div>

                    <!-- Product Rating -->
                    @if ($p->reviews_avg_rating || $p->reviews_count > 0)
                        <div class="flex items-center space-x-1 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $p->reviews_avg_rating && $i <= round($p->reviews_avg_rating) ? 'fill-current' : 'text-gray-600 dark:text-gray-500' }}"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <span>
                                @if($p->reviews_avg_rating)
                                    {{ number_format($p->reviews_avg_rating, 1) }}
                                @endif
                                ({{ $p->reviews_count ?? 0 }})
                            </span>
                        </div>
                    @endif

                    @auth
                        <!-- Wishlist and Cart Actions -->
                        <div class="flex items-center space-x-2 mb-3">
                            <button data-wishlist-button data-product-id="{{ $p->id }}"
                                data-wishlist-url="{{ route('wishlist.toggle') }}"
                                class="p-2 rounded-lg border transition-all duration-200 {{ auth()->user()->wishlists()->where('product_id', $p->id)->exists() ? 'text-red-500 border-red-500 hover:bg-red-500/10 dark:hover:bg-red-500/20 dark:border-red-400' : 'text-gray-400 border-gray-300 dark:border-gray-700 hover:border-red-500 hover:text-red-500 dark:hover:border-red-400 dark:hover:text-red-400' }}"
                                aria-label="{{ auth()->user()->wishlists()->where('product_id', $p->id)->exists() ? 'Remove from wishlist' : 'Add to wishlist' }}"
                                title="{{ auth()->user()->wishlists()->where('product_id', $p->id)->exists() ? 'Remove from wishlist' : 'Add to wishlist' }}">
                                <svg class="w-5 h-5 wishlist-heart"
                                    fill="{{ auth()->user()->wishlists()->where('product_id', $p->id)->exists() ? 'currentColor' : 'none' }}"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </button>

                            <form method="POST" action="{{ route('cart.store') }}" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                    class="w-full px-4 py-2 rounded-xl text-white bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 dark:from-emerald-700 dark:to-emerald-900 dark:hover:from-emerald-800 dark:hover:to-emerald-950 transition-all duration-200 transform hover:scale-105 shadow-lg dark:shadow-emerald-900 {{ $p->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                    {{ $p->stock <= 0 ? 'disabled' : '' }}>
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z">
                                        </path>
                                    </svg>
                                    {{ $p->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="block text-center px-4 py-2 rounded-xl text-emerald-400 dark:text-emerald-300 border border-emerald-500 dark:border-emerald-700 hover:bg-emerald-500 dark:hover:bg-emerald-700 hover:text-white dark:hover:text-white transition-all duration-200">
                            Login to Buy
                        </a>
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
