<body class="bg-gray-900 text-white font-sans antialiased">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <nav
            class="w-64 bg-gray-900 text-white flex flex-col items-center py-8 space-y-6 fixed left-0 top-0 h-full shadow-lg">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-3 px-4 mb-6 ">
                <img src="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/whitelogo.png') }}" alt="logo"
                    class="w-[55px] h-[55px] object-cover hover:scale-110 transition-transform duration-300 ease-in-out">
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
                                <span class="ml-2 bg-blue-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
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
                @endauth

                @guest
                    <li>
                        <x-sidelink link="{{ route('login') }}">Cart</x-sidelink>
                    </li>
                @endguest
                <li><x-sidelink link="#">Contact</x-sidelink></li>
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

        <!-- Main content wrapper ensures content isn't hidden behind fixed sidebar -->
        <main class="flex-1 ml-64 p-10 overflow-y-auto w-full">
            {{ $slot ?? '' }}
        </main>

    </div>
</body>
