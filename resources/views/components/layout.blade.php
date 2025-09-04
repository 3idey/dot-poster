@extends('components.app-layout')

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Desktop Sidebar -->
    <nav class="hidden lg:flex lg:flex-col lg:w-64 bg-slate-800 text-white items-center py-8 space-y-6 fixed left-0 top-0 h-full shadow-xl z-40 border-r border-slate-700">
        <!-- Logo -->
        <a href="/" class="flex items-center space-x-3 px-4 mb-6">
            <img src="{{ Vite::asset('resources/images/whitelogo.png') }}" alt="Dot Poster Logo"
                class="w-[55px] h-[55px] object-contain hover:scale-110 transition-transform duration-300 ease-in-out"
                loading="eager">
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

                    {{-- Normal user links --}}
                    <li><x-sidelink link="{{ route('profile.show') }}">Profile</x-sidelink></li>

                    {{-- Only show if admin --}}
                    @if (auth()->user()->isAdmin())
                        <li><x-sidelink link="{{ route('admin.dashboard') }}">Admin Dashboard</x-sidelink></li>
                    @endif

                    {{-- Only show if vendor --}}
                    @if (auth()->user()->isVendor())
                        <li><x-sidelink link="{{ route('vendor.dashboard') }}">Vendor Dashboard</x-sidelink></li>
                    @endif
                @endauth

                @guest
                    <li>
                        <x-sidelink link="{{ route('login') }}">Cart</x-sidelink>
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
                    <div class="ml-4 flex justify-between space-x-6">
                        <x-button name="Login" href="/login" />
                        <x-button name="Register" href="/register" />
                    </div>
                @endauth
            </div>
        </nav>

        <!-- Main content -->
        <main class="flex-1 lg:ml-64 p-4 md:p-6 lg:p-8 overflow-y-auto w-full bg-gray-50 min-h-screen">
            {{ $slot ?? '' }}
        </main>
    </div>
        <!-- Mobile menu button -->
        <div class="lg:hidden fixed bottom-4 right-4 z-50">
            <button id="mobile-sidebar-toggle"
                class="p-3 bg-slate-700 text-white rounded-full shadow-lg hover:bg-slate-800 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>
    
    <!-- Mobile sidebar overlay -->
    <div id="mobile-sidebar-overlay"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden transition-opacity duration-300 ease-in-out">
    </div>
    
    <!-- Mobile sidebar -->
    <div id="mobile-sidebar" class="lg:hidden fixed inset-y-0 left-0 transform -translate-x-full w-64 bg-slate-800 text-white z-50 transition-transform duration-300 ease-in-out overflow-y-auto border-r border-slate-700">
        <div class="p-4">
            <!-- Logo -->
            <div class="flex items-center justify-between p-4 border-b border-slate-700">
                <a href="/" class="flex items-center space-x-2">
                    <img src="{{ Vite::asset('resources/images/whitelogo.png') }}" alt="Dot Poster Logo" class="h-10 w-auto object-contain"
                         loading="eager">
                    <span class="text-xl font-bold">Dot Poster</span>
                </a>
                <button id="close-mobile-sidebar" class="text-gray-400 hover:text-white focus:outline-none">
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
                        <li><x-sidelink link="{{ route('profile.show') }}">Profile</x-sidelink></li>
                        @if (auth()->user()->isAdmin())
                            <li><x-sidelink link="{{ route('admin.dashboard') }}">Admin Dashboard</x-sidelink></li>
                        @endif
                        @if (auth()->user()->isVendor())
                            <li><x-sidelink link="{{ route('vendor.dashboard') }}">Vendor Dashboard</x-sidelink></li>
                        @endif
                    @else
                        <li><x-sidelink link="{{ route('login') }}">Cart</x-sidelink></li>
                    @endauth
                    <li><x-sidelink link="/contact">Contact</x-sidelink></li>
                    <li><x-sidelink link="/about">About</x-sidelink></li>
                </ul>
                
                @auth
                    <div class="mt-6 pt-6 border-t border-slate-700">
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
                    <div class="mt-6 pt-6 border-t border-slate-700 space-y-3">
                        <x-button name="Login" href="{{ route('login') }}" class="w-full text-center justify-center" />
                        <x-button name="Register" href="{{ route('register') }}" variant="outline" class="w-full text-center justify-center" />
                    </div>
                @endauth
            </nav>
        </div>
    </div>
