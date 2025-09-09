<x-header title="My Wishlist" />
<x-layout>
    <div data-wishlist-container class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 drop-shadow-lg">My Wishlist</h1>
            <div class="text-gray-400 dark:text-gray-300 text-lg">{{ $wishlistItems->total() }} items saved</div>
        </div>

        @if ($wishlistItems->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($wishlistItems as $product)
                    <div data-wishlist-item
                        class="bg-gray-800 dark:bg-gray-900 border border-gray-700 dark:border-gray-800 rounded-2xl p-6 shadow-lg dark:shadow-emerald-900 hover:shadow-xl transition-all duration-300 transform hover:scale-105 group relative">
                        <!-- Remove from wishlist button -->
                        <button data-wishlist-button data-product-id="{{ $product->id }}"
                            data-wishlist-url="{{ route('wishlist.toggle') }}"
                            class="absolute top-4 right-4 z-10 p-2 rounded-full bg-red-600 hover:bg-red-700 text-white transition-colors"
                            aria-label="Remove from wishlist">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>

                        <a href="{{ route('products.show', $product->id) }}" class="block">
                            <div class="relative overflow-hidden rounded-xl mb-4">
                                @php
                                    $img = $product->image
                                        ? asset('storage/' . $product->image)
                                        : ($product->images->first()
                                            ? $product->images->first()->image_url
                                            : asset('images/placeholder.svg'));
                                @endphp
                                <img src="{{ $img }}" alt="{{ $product->name }}"
                                    class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-110"
                                    loading="lazy">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                            </div>
                            <h3
                                class="text-lg font-semibold text-white dark:text-gray-100 mb-2 group-hover:text-emerald-400 transition-colors">
                                {{ $product->name }}</h3>
                        </a>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-2xl font-bold text-emerald-400 dark:text-emerald-300">${{ number_format($product->price, 2) }}</span>
                                <div class="text-sm text-gray-400 dark:text-gray-300">
                                    Stock: {{ $product->stock }} available
                                </div>
                            </div>

                            @if ($product->reviews_avg_rating || $product->reviews_count > 0)
                                <div class="flex items-center space-x-2">
                                    <div class="flex text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $product->reviews_avg_rating && $i <= round($product->reviews_avg_rating) ? 'fill-current' : 'text-gray-600' }}"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-400 dark:text-gray-300">
                                        @if($product->reviews_avg_rating)
                                            {{ number_format($product->reviews_avg_rating, 1) }}
                                        @endif
                                        ({{ $product->reviews_count ?? 0 }})
                                    </span>
                                </div>
                            @endif

                            <div class="flex space-x-2">
                                <form method="POST" action="{{ route('cart.store') }}" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit"
                                        class="w-full px-4 py-2 rounded-xl text-white bg-gradient-to-r from-emerald-600 to-emerald-700 dark:from-emerald-500 dark:to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 dark:hover:from-emerald-700 dark:hover:to-emerald-900 transition-all duration-200 transform hover:scale-105 shadow-lg dark:shadow-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 {{ $product->stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z">
                                            </path>
                                        </svg>
                                        {{ $product->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $wishlistItems->links() }}
            </div>
        @else
            <div data-wishlist-empty class="text-center py-16">
                <svg class="w-24 h-24 text-gray-600 dark:text-gray-500 mx-auto mb-6" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                    </path>
                </svg>
                <h2 class="text-2xl font-semibold text-gray-300 dark:text-gray-500 mb-2">Your wishlist is empty</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Save your favorite items here for later</p>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-emerald-600 dark:bg-emerald-700 hover:bg-emerald-700 dark:hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Browse Products
                </a>
            </div>
        @endif
    </div>
</x-layout>
<x-footer />
