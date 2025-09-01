<x-header title=".poster" />
<x-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <!-- Hero Section -->
        <div class="text-center py-20">
            <h1 class="text-5xl font-bold mb-6 text-white bg-gradient-to-r from-emerald-400 to-blue-500 bg-clip-text text-transparent">
                Welcome to Dot-Poster
            </h1>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Discover amazing posters that transform your space. From vintage classics to modern art, find the perfect piece for your walls.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" 
                   class="px-8 py-4 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-semibold rounded-xl hover:from-emerald-700 hover:to-emerald-800 transform hover:scale-105 transition-all duration-200 shadow-lg">
                    Browse Posters
                </a>
                @guest
                <a href="{{ route('register') }}" 
                   class="px-8 py-4 bg-transparent border-2 border-emerald-500 text-emerald-400 font-semibold rounded-xl hover:bg-emerald-500 hover:text-white transition-all duration-200">
                    Join Now
                </a>
                @endguest
            </div>
        </div>

        <!-- Features Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-8 pb-20">
            <div class="bg-gray-800 rounded-xl p-6 text-center border border-gray-700">
                <div class="w-16 h-16 bg-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Curated Collection</h3>
                <p class="text-gray-400">Hand-picked posters from talented artists worldwide</p>
            </div>

            <div class="bg-gray-800 rounded-xl p-6 text-center border border-gray-700">
                <div class="w-16 h-16 bg-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Secure Payment</h3>
                <p class="text-gray-400">Safe and secure checkout with multiple payment options</p>
            </div>

            <div class="bg-gray-800 rounded-xl p-6 text-center border border-gray-700">
                <div class="w-16 h-16 bg-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">Fast Delivery</h3>
                <p class="text-gray-400">Quick and reliable shipping to your doorstep</p>
            </div>
        </div>
    </div>
</x-layout>
<x-footer />
