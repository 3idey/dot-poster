@extends('components.app-layout')

@section('content')
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Desktop Sidebar -->
        <nav
            class="hidden lg:flex lg:flex-col lg:w-64 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 items-center py-8 space-y-6 fixed left-0 top-0 h-full shadow-xl dark:shadow-emerald-900 z-40 border-r border-gray-200 dark:border-gray-700">
            <!-- Logo -->
            <a href="/" class="flex items-center justify-center px-4 mb-6">
                <x-text-logo size="lg" />
            </a>

            <!-- Navigation Links -->
            <ul class="w-full px-6 space-y-4 mb-6">
                <li><x-sidelink link="/">Home</x-sidelink></li>
                <li><x-sidelink link="{{ route('products.index') }}">Posters</x-sidelink></li>
                @auth
                    <li class="relative">
                        <x-sidelink link="{{ route('cart.index') }}">
                            Cart
                            @if (auth()->user()->cartItems()->count() > 0)
                                <span class="ml-2 bg-emerald-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                    {{ auth()->user()->cartItems()->count() }}
                                </span>
                            @endif
                        </x-sidelink>
                    </li>
                    <li class="relative">
                        <x-sidelink link="{{ route('wishlist.index') }}">
                            Wishlist
                            @if (auth()->user()->wishlists()->count() > 0)
                                <span class="ml-2 bg-purple-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                    {{ auth()->user()->wishlists()->count() }}
                                </span>
                            @endif
                        </x-sidelink>
                    </li>
                    <li><x-sidelink link="{{ route('products.recently-viewed') }}">Recently Viewed</x-sidelink></li>
                    {{-- Normal user links --}}
                    <li><x-sidelink link="{{ route('profile.show') }}">Profile</x-sidelink></li>
                    <li><x-sidelink link="{{ route('profile.saved-payment-methods.index') }}">Payment Methods</x-sidelink></li>
                    <li><x-sidelink link="{{ route('orders.index') }}">My Orders</x-sidelink></li>

                    {{-- Only show if admin --}}
                    @if (auth()->user()->isAdmin())
                        <li><x-sidelink link="{{ route('admin.dashboard') }}">Admin Dashboard</x-sidelink></li>
                    @endif

                    {{-- Dark Mode Toggle --}}
                    <li class="mt-8 pt-4 border-t border-gray-200">
                        <button id="dark-mode-toggle"
                            class="w-full flex items-center space-x-3 px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors dark:text-gray-200 dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 dark-mode-icon" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 light-mode-icon hidden" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="dark-mode-text">Dark Mode</span>
                        </button>
                    </li>

                    {{-- Only show if vendor --}}
                    @if (auth()->user()->isVendor())
                        <li><x-sidelink link="{{ route('vendor.dashboard') }}">Vendor Dashboard</x-sidelink></li>
                    @endif
                @endauth

                @guest
                    <li>
                        <x-sidelink link="{{ route('login') }}">Cart</x-sidelink>
                    </li>
                    <li>
                        <x-sidelink link="{{ route('login') }}">Wishlist</x-sidelink>
                    </li>
                @endguest
                <li><x-sidelink link="/contact">Contact</x-sidelink></li>
                <li><x-sidelink link="/about">About</x-sidelink></li>

            </ul>
            <!-- Bottom user section -->
            <div class="mt-auto w-full px-4 pb-6">
                @auth
                    <form method="POST" action="/logout">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors duration-300 ease-in-out">
                            Logout
                        </button>
                    </form>
                @else
                    <div class="flex flex-col space-y-3">
                        <x-button name="Login" href="{{ route('login') }}" class="w-full text-center justify-center" />
                        <x-button name="Register" href="{{ route('register') }}" variant="outline"
                            class="w-full text-center justify-center" />
                    </div>
                @endauth
            </div>
        </nav>

        <!-- Main content -->
        <main class="flex-1 lg:ml-64 p-4 md:p-6 lg:p-8 overflow-y-auto w-full bg-gray-50 dark:bg-gray-900 min-h-screen">
            {{ $slot ?? '' }}

            <!-- Newsletter Subscription Section -->
            @if (auth()->guest() || !auth()->user()->isSubscribed())
                <div
                    class="bg-gradient-to-r from-emerald-600 to-emerald-700 dark:from-emerald-800 dark:to-emerald-900 py-12 mt-16 -mx-4 md:-mx-6 lg:-mx-8">
                    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <h2 class="text-3xl font-bold text-white mb-4">Stay Updated with New Posters</h2>
                        <p class="text-emerald-100 dark:text-emerald-200 text-lg mb-8">Subscribe to our newsletter and be
                            the first to know about
                            new arrivals, exclusive offers, and special collections.</p>

                        <form id="newsletter-form" class="max-w-md mx-auto">
                            @csrf
                            <div class="flex flex-col sm:flex-row gap-4">
                                <input type="email" id="newsletter-email" name="email"
                                    placeholder="Enter your email address" required
                                    class="flex-1 px-4 py-3 rounded-lg border border-emerald-300 dark:border-emerald-700 focus:ring-2 focus:ring-white focus:border-transparent text-gray-900 dark:text-gray-100 dark:bg-gray-900 placeholder-gray-500 dark:placeholder-gray-400">
                                <button type="submit" id="newsletter-submit"
                                    class="px-8 py-3 bg-white dark:bg-gray-800 text-emerald-600 dark:text-emerald-300 font-semibold rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-emerald-600">
                                    Subscribe
                                </button>
                            </div>
                        </form>

                        <div id="newsletter-message" class="mt-4 hidden">
                            <div id="newsletter-success"
                                class="text-white bg-emerald-800 bg-opacity-50 px-4 py-2 rounded-lg hidden">
                                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span id="newsletter-success-text"></span>
                            </div>
                            <div id="newsletter-error"
                                class="text-white bg-red-600 bg-opacity-50 px-4 py-2 rounded-lg hidden">
                                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span id="newsletter-error-text"></span>
                            </div>
                        </div>

                        <p class="text-emerald-200 dark:text-emerald-300 text-sm mt-4">We respect your privacy. Unsubscribe
                            at any time.</p>
                    </div>
                </div>
        </main>
        @endif
    </div>
    <!-- Mobile menu button -->
    <div class="lg:hidden fixed bottom-4 right-4 z-50">
        <button id="mobile-sidebar-toggle"
            class="p-3 bg-slate-700 dark:bg-gray-800 text-white rounded-full shadow-lg hover:bg-slate-800 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 dark:focus:ring-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>

    <!-- Mobile sidebar overlay -->
    <div id="mobile-sidebar-overlay"
        class="fixed inset-0 bg-black bg-opacity-50 dark:bg-opacity-70 z-40 lg:hidden hidden transition-opacity duration-300 ease-in-out">
    </div>

    <!-- Mobile sidebar -->
    <div id="mobile-sidebar"
        class="lg:hidden fixed inset-y-0 left-0 transform -translate-x-full w-64 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 z-50 transition-transform duration-300 ease-in-out overflow-y-auto border-r border-gray-200 dark:border-gray-700">
        <div class="p-4">
            <!-- Logo -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <a href="/" class="flex items-center">
                    <x-text-logo size="base" />
                </a>
                <button id="close-mobile-sidebar"
                    class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="mt-6">
                <ul class="space-y-2">
                    <li><x-sidelink link="/">Home</x-sidelink></li>
                    <li><x-sidelink link="{{ route('products.index') }}">Posters</x-sidelink></li>
                    @auth
                        <li class="relative">
                            <x-sidelink link="{{ route('cart.index') }}">
                                Cart
                                @if (auth()->user()->cartItems()->count() > 0)
                                    <span class="ml-2 bg-emerald-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                        {{ auth()->user()->cartItems()->count() }}
                                    </span>
                                @endif
                            </x-sidelink>
                        </li>
                        <li class="relative">
                            <x-sidelink link="{{ route('wishlist.index') }}">
                                Wishlist
                                @if (auth()->user()->wishlists()->count() > 0)
                                    <span class="ml-2 bg-purple-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                        {{ auth()->user()->wishlists()->count() }}
                                    </span>
                                @endif
                            </x-sidelink>
                        </li>
                        <li>
                            <x-sidelink link="{{ route('products.recently-viewed') }}">Recently Viewed</x-sidelink>
                        </li>
                        <li><x-sidelink link="{{ route('profile.show') }}">Profile</x-sidelink></li>
                        <li><x-sidelink link="{{ route('profile.saved-payment-methods.index') }}">Payment Methods</x-sidelink>
                        </li>
                        <li><x-sidelink link="{{ route('orders.index') }}">My Orders</x-sidelink></li>
                        @if (auth()->user()->isAdmin())
                            <li><x-sidelink link="{{ route('admin.dashboard') }}">Admin Dashboard</x-sidelink></li>
                        @endif
                        @if (auth()->user()->isVendor())
                            <li><x-sidelink link="{{ route('vendor.dashboard') }}">Vendor Dashboard</x-sidelink></li>
                        @endif
                    @else
                        <li><x-sidelink link="{{ route('login') }}">Cart</x-sidelink></li>
                        <li><x-sidelink link="{{ route('login') }}">Wishlist</x-sidelink></li>
                    @endauth
                    <li><x-sidelink link="/contact">Contact</x-sidelink></li>
                    <li><x-sidelink link="/about">About</x-sidelink></li>
                </ul>

                @auth
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <form method="POST" action="/logout">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors duration-300 ease-in-out">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 space-y-3">
                        <x-button name="Login" href="{{ route('login') }}" class="w-full text-center justify-center" />
                        <x-button name="Register" href="{{ route('register') }}" variant="outline"
                            class="w-full text-center justify-center" />
                    </div>
                @endauth
            </nav>
        </div>
    </div>
@endsection
