<x-header title=".poster" />
<x-layout>

    <div class="grid md:grid-cols-2 gap-12">
        <!-- Product Images -->
        <div class="space-y-4">
            <div class="relative overflow-hidden rounded-2xl bg-gray-800 border border-gray-700">
                @php
                    $mainImage = $product->image ? asset('storage/' . $product->image) : 
                                ($product->images->first() ? $product->images->first()->image_url : 
                                asset('images/placeholder.svg'));
                @endphp
                <img id="main-product-image" src="{{ $mainImage }}" 
                     class="w-full h-96 object-cover" 
                     alt="{{ $product->name }}">
            </div>
            @if($product->images->count() > 1)
                <div class="flex gap-3 overflow-x-auto">
                    @foreach ($product->images as $img)
                        <img src="{{ $img->image_url }}" 
                             class="w-16 h-16 object-cover rounded-xl border-2 border-gray-700 hover:border-emerald-500 cursor-pointer transition-colors flex-shrink-0"
                             onclick="document.getElementById('main-product-image').src = '{{ $img->image_url }}'">
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="space-y-6">
            <div>
                <h1 class="text-4xl font-bold text-white mb-3">{{ $product->name }}</h1>
                <p class="text-gray-300 text-lg leading-relaxed">{{ $product->description }}</p>
            </div>

            <div class="flex items-center justify-between">
                <div class="text-3xl font-bold text-emerald-400">${{ number_format($product->price, 2) }}</div>
                <div class="text-right">
                    <div class="text-sm text-gray-400">Stock Available</div>
                    <div class="text-lg font-semibold {{ $product->stock <= 5 ? 'text-red-400' : 'text-white' }}">
                        {{ $product->stock }} units
                    </div>
                </div>
            </div>

            @if($product->stock <= 5 && $product->stock > 0)
                <div class="bg-yellow-900/30 border border-yellow-600 rounded-lg p-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-yellow-300 text-sm">Only {{ $product->stock }} left in stock!</span>
                    </div>
                </div>
            @endif

            @auth
                @if($product->stock > 0)
                    <form method="POST" action="{{ route('cart.store') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="bg-gray-800 border border-gray-700 rounded-xl p-4">
                            <label class="block text-sm font-medium text-gray-300 mb-3">Quantity</label>
                            <div class="flex items-center space-x-4">
                                <select name="quantity" class="bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                                    @for ($i = 1; $i <= min(10, $product->stock); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                
                                <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                                    </svg>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="bg-red-900/30 border border-red-600 rounded-xl p-4 text-center">
                        <svg class="w-12 h-12 text-red-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <div class="text-red-300 font-semibold">Out of Stock</div>
                        <div class="text-red-400 text-sm">This item is currently unavailable</div>
                    </div>
                @endif
            @else
                <div class="text-center">
                    <a href="{{ route('login') }}" class="inline-block bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-semibold py-3 px-8 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                        Login to Purchase
                    </a>
                </div>
            @endauth

            <!-- Product Category -->
            @if($product->category)
                <div class="flex items-center space-x-2 text-sm">
                    <span class="text-gray-400">Category:</span>
                    <span class="bg-emerald-900/30 text-emerald-300 px-3 py-1 rounded-full border border-emerald-600">
                        {{ $product->category->name }}
                    </span>
                </div>
            @endif
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mt-16">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-white">Customer Reviews</h2>
                <div class="flex items-center space-x-2">
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= ($product->reviews->avg('rating') ?? 0) ? 'fill-current' : 'text-gray-600' }}" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-gray-400">({{ $product->reviews->count() }} reviews)</span>
                </div>
            </div>

            @if($product->reviews->count() > 0)
                <div class="space-y-4 mb-8">
                    @foreach($product->reviews->take(3) as $review)
                        <div class="bg-gray-700 rounded-xl p-4 border border-gray-600">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ asset('storage/' . $review->user->avatar ?? 'images/placeholder.svg') }}" alt="User Avatar" class="w-8 h-8 rounded-full">
                                    <span class="text-white font-medium">{{ $review->user->name }}</span>
                                </div>
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-600' }}" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-300">{{ $review->comment }}</p>
                            <div class="text-xs text-gray-500 mt-2">{{ $review->created_at->diffForHumans() }}</div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.013 8.013 0 01-7-4c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                    </svg>
                    <p class="text-gray-400">No reviews yet. Be the first to review this product!</p>
                </div>
            @endif

            @auth
                <div class="border-t border-gray-600 pt-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Write a Review</h3>
                    <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Rating</label>
                            <div class="flex space-x-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" class="sr-only">
                                    <label for="star{{ $i }}" class="cursor-pointer">
                                        <svg class="w-8 h-8 text-gray-600 hover:text-yellow-400 transition-colors star-rating" data-rating="{{ $i }}" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Your Review</label>
                            <textarea name="comment" rows="4" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors" placeholder="Share your thoughts about this product..."></textarea>
                        </div>
                        <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-semibold py-2 px-6 rounded-lg transition-all duration-200">
                            Submit Review
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>

    <!-- Related Products -->
    @if($product->category && $product->category->products->where('id', '!=', $product->id)->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-white mb-8">You Might Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($product->category->products->where('id', '!=', $product->id)->take(4) as $relatedProduct)
                    <div class="bg-gray-800 border border-gray-700 rounded-2xl p-4 hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <a href="{{ route('products.show', $relatedProduct->id) }}" class="block">
                            @php
                                $relatedImage = $relatedProduct->image ? asset('storage/' . $relatedProduct->image) : 
                                              ($relatedProduct->images->first() ? $relatedProduct->images->first()->image_url : 
                                              asset('images/placeholder.svg'));
                            @endphp
                            <img src="{{ $relatedImage }}" 
                                 class="w-full h-48 object-cover rounded-xl mb-3"
                                 alt="{{ $relatedProduct->name }}">
                            <h3 class="text-white font-medium mb-2">{{ $relatedProduct->name }}</h3>
                            <div class="text-emerald-400 font-bold">${{ number_format($relatedProduct->price, 2) }}</div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <script>
        // Interactive star rating
        document.querySelectorAll('.star-rating').forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.dataset.rating;
                document.querySelector(`#star${rating}`).checked = true;
                
                // Update visual feedback
                document.querySelectorAll('.star-rating').forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('text-yellow-400', 'fill-current');
                        s.classList.remove('text-gray-600');
                    } else {
                        s.classList.remove('text-yellow-400', 'fill-current');
                        s.classList.add('text-gray-600');
                    }
                });
            });
        });
    </script>
</x-layout>
<x-footer />
