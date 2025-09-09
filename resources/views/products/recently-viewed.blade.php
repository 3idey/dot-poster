<x-header title="Recently Viewed Products" />
<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Recently Viewed Products</h1>

        @if ($products->isEmpty())
            <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No recently viewed products</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">Products you view will appear here</p>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:outline-none focus:border-emerald-700 focus:ring focus:ring-emerald-200 active:bg-emerald-800 transition">
                    Browse Products
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                        <a href="{{ route('products.show', $product->id) }}" class="block">
                            <div class="relative overflow-hidden aspect-square bg-gray-100 dark:bg-gray-700">
                                @php
                                    $img = $product->image
                                        ? asset('storage/' . $product->image)
                                        : ($product->images->first()
                                            ? $product->images->first()->image_url
                                            : asset('images/placeholder.svg'));
                                @endphp
                                <img src="{{ $img }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                    loading="lazy">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1 line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-emerald-600 dark:text-emerald-400 text-lg font-bold">
                                    ${{ number_format($product->price, 2) }}
                                </p>
                                @if ($product->reviews_avg_rating)
                                    <div class="mt-2 flex items-center">
                                        <div class="flex items-center text-amber-400">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($product->reviews_avg_rating))
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @elseif($i - 0.5 <= $product->reviews_avg_rating && $product->reviews_avg_rating < $i)
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <defs>
                                                            <linearGradient
                                                                id="half-{{ $product->id }}-{{ $i }}"
                                                                x1="0" x2="100%" y1="0"
                                                                y2="0">
                                                                <stop offset="50%" stop-color="currentColor" />
                                                                <stop offset="50%" stop-color="#d1d5db" />
                                                            </linearGradient>
                                                        </defs>
                                                        <path fill="url(#half-{{ $product->id }}-{{ $i }})"
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">
                                            ({{ number_format($product->reviews_avg_rating, 1) }})
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layout>
<x-footer />
