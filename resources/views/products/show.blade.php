<x-header title="Product" />
<x-layout>

    <div class="grid md:grid-cols-2 gap-12">
        <!-- Product Images -->
        <div class="space-y-4">
            <div class="relative overflow-hidden rounded-2xl bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                @php
                    // Consistent image selection: prefer stored main image path if set, else first relation image (already ordered by is_main desc), else placeholder
                    $mainImage = $product->image
                        ? asset('storage/' . $product->image)
                        : ($product->images->first()
                            ? $product->images->first()->image_url
                            : asset('images/placeholder.svg'));
                @endphp
                <img id="main-product-image" 
                     src="{{ $mainImage }}" 
                     class="w-full h-96 md:h-[500px] object-cover transition-transform duration-300 hover:scale-105 cursor-zoom-in" 
                     alt="{{ $product->name }}" 
                     loading="eager"
                     data-modal-image="{{ $mainImage }}">
                
                <!-- Zoom indicator -->
                <div class="absolute top-4 right-4 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 hover:opacity-100 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                    </svg>
                </div>
            </div>
            
            @if ($product->images->count() > 1)
                <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                    @foreach ($product->images as $index => $img)
                        <img src="{{ $img->image_url }}"
                            class="product-thumbnail w-20 h-20 object-cover rounded-xl border-2 {{ ($product->image ? asset('storage/' . $product->image) : ($product->images->first()?->image_url)) === $img->image_url ? 'border-emerald-500 dark:border-emerald-400' : 'border-gray-300 dark:border-gray-600' }} hover:border-emerald-500 dark:hover:border-emerald-400 cursor-pointer transition-all duration-200 flex-shrink-0 hover:scale-105"
                            data-full-image="{{ $img->image_url }}" 
                            alt="{{ $product->name }} - Image {{ $index + 1 }}" 
                            loading="lazy"
                            data-change-main>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="space-y-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">{{ $product->name }}</h1>
                @if($product->reviews_avg_rating || $product->reviews_count > 0)
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex items-center text-yellow-400">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $product->reviews_avg_rating && $i <= round($product->reviews_avg_rating) ? 'fill-current' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            @if($product->reviews_avg_rating)
                                {{ number_format($product->reviews_avg_rating, 1) }}
                            @endif
                            ({{ $product->reviews_count }} {{ Str::plural('review', $product->reviews_count) }})
                        </span>
                    </div>
                @endif
                <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed">{{ $product->description }}</p>
            </div>

            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="text-3xl md:text-4xl font-bold text-emerald-600 dark:text-emerald-400">
                    ${{ number_format($product->price, 2) }}
                </div>
                <div class="text-right">
                    <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Stock Available</div>
                    <div class="flex items-center gap-2">
                        <div class="text-lg font-semibold {{ $product->stock <= 5 ? 'text-red-500 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                            {{ $product->stock }} units
                        </div>
                        @if($product->stock > 0)
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        @endif
                    </div>
                </div>
            </div>

            @if ($product->stock <= 5 && $product->stock > 0)
                <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-amber-800 dark:text-amber-200">
                                Hurry up! Only {{ $product->stock }} {{ Str::plural('item', $product->stock) }} left in stock
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @auth
                <!-- Wishlist Button -->
                <div class="mb-4">
                    <button data-wishlist-button data-product-id="{{ $product->id }}"
                        data-wishlist-url="{{ route('wishlist.toggle') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg border transition-all duration-200 {{ auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? 'text-red-500 border-red-500 hover:bg-red-500/10 dark:hover:bg-red-500/20 dark:border-red-400' : 'text-gray-600 dark:text-gray-300 border-gray-300 dark:border-gray-700 hover:border-red-500 hover:text-red-500 dark:hover:border-red-400 dark:hover:text-red-400' }}"
                        aria-label="{{ auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? 'Remove from wishlist' : 'Add to wishlist' }}"
                        title="{{ auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? 'Remove from wishlist' : 'Add to wishlist' }}">
                        <svg class="w-5 h-5"
                            fill="{{ auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? 'currentColor' : 'none' }}"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span>{{ auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? 'Remove from Wishlist' : 'Add to Wishlist' }}</span>
                    </button>
                </div>

                @if ($product->stock > 0)
                    <form method="POST" action="{{ route('cart.store') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl p-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Quantity</label>
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <select name="quantity" 
                                        class="appearance-none bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 pr-10 text-gray-900 dark:text-gray-100 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-20 transition-all min-w-[80px]">
                                        @for ($i = 1; $i <= min(10, $product->stock); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 dark:from-emerald-500 dark:to-emerald-600 dark:hover:from-emerald-600 dark:hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50">
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                                        </svg>
                                        <span>Add to Cart</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6 text-center">
                        <div class="w-16 h-16 bg-red-100 dark:bg-red-900/40 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2">Out of Stock</h3>
                        <p class="text-red-600 dark:text-red-300 text-sm mb-4">This item is currently unavailable</p>
                        <button class="bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 px-6 py-2 rounded-lg font-medium cursor-not-allowed" disabled>
                            Notify When Available
                        </button>
                    </div>
                @endif
            @else
                <div class="text-center">
                    <a href="{{ route('login') }}"
                        class="inline-block bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 dark:from-emerald-700 dark:to-emerald-900 dark:hover:from-emerald-800 dark:hover:to-emerald-950 text-white font-semibold py-3 px-8 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg dark:shadow-emerald-900">
                        Login to Purchase
                    </a>
                </div>
            @endauth

            <!-- Product Category and Meta -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                @if ($product->category)
                    <div class="flex items-center gap-4 mb-4">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Category:</span>
                        <a href="{{ route('products.index', ['category' => $product->category->id]) }}"
                           class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-200 border border-emerald-200 dark:border-emerald-800 hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition-colors">
                            {{ $product->category->name }}
                        </a>
                    </div>
                @endif
                
                <!-- Additional product info -->
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">SKU:</span>
                        <span class="text-gray-900 dark:text-gray-100 font-medium">#{{ $product->id }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">Availability:</span>
                        <span class="{{ $product->stock > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                            {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-16">
        <div class="bg-gray-800 dark:bg-gray-900 border border-gray-700 dark:border-gray-800 rounded-2xl p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white">Customer Reviews</h2>
                <div class="flex items-center space-x-2">
                    <div class="flex text-yellow-400">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $product->reviews_avg_rating && $i <= round($product->reviews_avg_rating) ? 'fill-current' : 'text-gray-600 dark:text-gray-500' }}"
                                viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="text-gray-300">
                        @if($product->reviews_avg_rating)
                            {{ number_format($product->reviews_avg_rating, 1) }}
                        @else
                            No rating yet
                        @endif
                        ({{ $product->reviews_count }} {{ Str::plural('review', $product->reviews_count) }})
                    </span>
                </div>
            </div>

            @if ($product->reviews->count() > 0)
                <div class="space-y-4 mb-8">
                    @foreach ($product->reviews->take(3) as $review)
                        <div
                            class="bg-gray-700 dark:bg-gray-800 rounded-xl p-4 border border-gray-600 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $review->user->avatar_url }}" alt="User Avatar"
                                        class="w-8 h-8 rounded-full">
                                    <span class="text-white font-medium">{{ $review->user->name }}</span>
                                </div>
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-600 dark:text-gray-500' }}"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-300 dark:text-gray-200">{{ $review->comment }}</p>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                {{ $review->created_at->diffForHumans() }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-600 dark:text-gray-500 mx-auto mb-4" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.013 8.013 0 01-7-4c0-4.418 3.582-8 8-8s8 3.582 8 8z">
                        </path>
                    </svg>
                    <p class="text-gray-400 dark:text-gray-300">No reviews yet. Be the first to review this product!
                    </p>
                </div>
            @endif

            @auth
                @php
                    $userReview = $product
                        ->reviews()
                        ->where('user_id', auth()->id())
                        ->first();
                @endphp

                @if (!$userReview)
                    <div class="border-t border-gray-600 pt-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Write a Review</h3>
                        <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Rating</label>
                                <div class="flex space-x-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" value="{{ $i }}"
                                            id="star{{ $i }}" class="sr-only">
                                        <label for="star{{ $i }}" class="cursor-pointer">
                                            <svg class="w-8 h-8 text-gray-600 dark:text-gray-500 hover:text-yellow-400 transition-colors star-rating"
                                                data-rating="{{ $i }}" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Your Review</label>
                                <textarea name="comment" rows="4"
                                    class="w-full bg-gray-700 dark:bg-gray-800 border border-gray-600 dark:border-gray-700 rounded-lg px-4 py-3 text-white placeholder-gray-400 dark:placeholder-gray-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                                    placeholder="Share your thoughts about this product..."></textarea>
                            </div>
                            <button type="submit"
                                class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 dark:from-emerald-700 dark:to-emerald-900 dark:hover:from-emerald-800 dark:hover:to-emerald-950 text-white font-semibold py-2 px-6 rounded-lg transition-all duration-200">
                                Submit Review
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border-t border-gray-600 pt-6">
                        <div
                            class="bg-gray-700 dark:bg-gray-800 rounded-lg p-4 border border-gray-600 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-white mb-2">Your Review</h3>
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $userReview->rating ? 'fill-current' : 'text-gray-600' }}"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-gray-300 dark:text-gray-200">{{ $userReview->rating }}/5</span>
                            </div>
                            @if ($userReview->comment)
                                <p class="text-gray-300 dark:text-gray-200">{{ $userReview->comment }}</p>
                            @endif
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">You have already reviewed this
                                product.</p>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <!-- Related Products -->
    @if ($relatedProducts && $relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-white mb-8">You Might Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($relatedProducts as $relatedProduct)
                    <div
                        class="bg-gray-800 dark:bg-gray-900 border border-gray-700 dark:border-gray-800 rounded-2xl p-4 hover:shadow-xl dark:hover:shadow-emerald-800 transition-all duration-300 transform hover:scale-105">
                        <a href="{{ route('products.show', $relatedProduct->id) }}" class="block">
                            @php
                                $relatedImage = $relatedProduct->image
                                    ? asset('storage/' . $relatedProduct->image)
                                    : ($relatedProduct->images->first()
                                        ? $relatedProduct->images->first()->image_url
                                        : asset('images/placeholder.svg'));
                            @endphp
                            <img src="{{ $relatedImage }}"
                                class="w-full h-48 object-cover rounded-xl mb-3 dark:brightness-90"
                                alt="{{ $relatedProduct->name }}" loading="lazy">
                            <h3 class="text-white dark:text-gray-100 font-medium mb-2 line-clamp-2">{{ $relatedProduct->name }}</h3>
                            <div class="flex items-center justify-between">
                                <div class="text-emerald-400 dark:text-emerald-300 font-bold">
                                    ${{ number_format($relatedProduct->price, 2) }}
                                </div>
                                @if($relatedProduct->reviews_avg_rating)
                                    <div class="flex items-center text-yellow-400">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-xs text-gray-300 ml-1">{{ number_format($relatedProduct->reviews_avg_rating, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</x-layout>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" src="" alt="Product Image" class="max-w-full max-h-full object-contain rounded-lg">
        <button data-close-image-modal class="absolute top-4 right-4 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-opacity">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

@vite(['resources/css/product-show.css', 'resources/js/product-show.js'])

<x-footer />
