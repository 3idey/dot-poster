<x-header title="Profile" />

<x-layout>
    <div class="max-w-5xl mx-auto bg-white text-gray-900 rounded-xl shadow-sm border border-gray-200 p-8 space-y-8">

        {{-- User Info + Edit --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <img src="{{ $user->avatar_url }}"
                    class="w-20 h-20 rounded-full border-2 border-emerald-500 shadow-lg" alt="avatar">


                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-gray-600">{{ $user->email }}</p>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}"
                class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                Edit Profile
            </a>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('wishlist.index') }}" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white p-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold">My Wishlist</h4>
                        <p class="text-sm opacity-80">{{ auth()->user()->wishlists()->count() }} items</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('cart.index') }}" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white p-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0h15M17 21a2 2 0 100-4 2 2 0 000 4zM9 21a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold">Shopping Cart</h4>
                        <p class="text-sm opacity-80">{{ auth()->user()->cartItems()->count() }} items</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('profile.saved-payment-methods.index') }}" class="bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white p-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold">Payment Methods</h4>
                        <p class="text-sm opacity-80">{{ auth()->user()->savedPaymentMethods()->active()->count() }} saved</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('products.index') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white p-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center space-x-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold">Browse Products</h4>
                        <p class="text-sm opacity-80">Discover new posters</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Orders --}}
        <div>
            <h3 class="text-xl font-semibold mb-4 text-gray-900">Your Orders</h3>
            @forelse ($orders as $order)
                <a href="{{ route('orders.show', $order) }}">
                    <div class="border border-gray-200 p-4 rounded-lg mb-3 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-semibold text-gray-900">Order #{{ $order->id }}</span>
                                <p class="text-gray-600 text-sm">{{ $order->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $order->orderItems->count() }} items
                                — <span
                                    class="font-semibold text-gray-900">${{ number_format($order->orderItems->sum('price'), 2) }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-gray-600">No orders yet.</p>
            @endforelse
        </div>
    </div>
</x-layout>

<x-footer />
