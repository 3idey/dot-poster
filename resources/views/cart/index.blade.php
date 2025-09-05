<x-header title="Cart" />
<x-layout>
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Your Cart</h1>
            @if (!$items->isEmpty())
                <div class="text-sm text-gray-600">
                    {{ $items->count() }} {{ Str::plural('item', $items->count()) }}
                </div>
            @endif
        </div>

        @if ($items->isEmpty())
            <!-- Empty Cart State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-600 mb-8">Looks like you haven't added any posters to your cart yet.</p>
                <a href="{{ route('products.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Start Shopping
                </a>
            </div>
        @else
            <!-- Cart Items -->
            <div class="space-y-4 mb-8">
                @foreach ($items as $item)
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-6">
                            <!-- Product Image -->
                            <a href="{{ route('products.show', $item->product->id) }}" class="flex-shrink-0">
                                <div class="relative overflow-hidden rounded-lg w-24 h-24 bg-gray-100">
                                    @php
                                        $img = $item->product->image
                                            ? asset('storage/' . $item->product->image)
                                            : ($item->product->images->first()
                                                ? $item->product->images->first()->image_url
                                                : asset('images/placeholder.svg'));
                                    @endphp
                                    <img src="{{ $img }}" alt="{{ $item->product->name }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                        loading="lazy">
                                </div>
                            </a>
                            
                            <!-- Product Details -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 text-lg mb-1">
                                    <a href="{{ route('products.show', $item->product->id) }}" class="hover:text-emerald-600 transition-colors">
                                        {{ $item->product->name }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-2">${{ number_format($item->product->price, 2) }} each</p>
                                <p class="text-sm text-gray-500">
                                    Subtotal: ${{ number_format($item->product->price * $item->quantity, 2) }}
                                </p>
                            </div>
                            
                            <!-- Quantity Controls -->
                            <div class="flex items-center gap-4">
                                <form method="POST" action="{{ route('cart.update', $item->id) }}" class="flex items-center gap-2">
                                    @csrf @method('PATCH')
                                    <label for="quantity-{{ $item->id }}" class="text-sm font-medium text-gray-700">Qty:</label>
                                    <input type="number" 
                                           id="quantity-{{ $item->id }}"
                                           name="quantity" 
                                           value="{{ $item->quantity }}" 
                                           min="1" 
                                           max="99"
                                           class="w-16 rounded-md border border-gray-300 px-3 py-2 text-center text-gray-900 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                                    <button type="submit" 
                                            class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm rounded-md transition-colors">
                                        Update
                                    </button>
                                </form>
                                
                                <!-- Remove Button -->
                                <form method="POST" action="{{ route('cart.destroy', $item->id) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-md transition-colors"
                                            onclick="return confirm('Remove this item from your cart?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Cart Summary -->
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">Order Summary</h3>
                        <p class="text-gray-600">{{ $items->sum('quantity') }} {{ Str::plural('item', $items->sum('quantity')) }} in your cart</p>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-gray-900">
                            ${{ number_format($total, 2) }}
                        </div>
                        <p class="text-sm text-gray-600">Total</p>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('products.index') }}" 
                       class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors text-center">
                        Continue Shopping
                    </a>
                    <a href="{{ route('checkout.index') }}"
                       class="flex-1 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors text-center">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layout>
<x-footer />
