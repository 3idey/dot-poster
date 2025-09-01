<x-header title="Login" />
<x-layout>

    <div class="max-w-md mx-auto mt-20">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Welcome Back</h1>
                <p class="text-gray-400">Sign in to your account</p>
            </div>
            
            <form method="POST" action="/login" class="space-y-6">
                @csrf
                <div>
                    <label for="login" class="block text-sm font-medium text-gray-300 mb-2">Email or Phone Number</label>
                    <input type="text" name="login" id="login" required
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                        placeholder="Enter your email or phone"
                        value="{{ old('login') }}">
                    @error('login')
                        <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                        placeholder="Enter your password">
                    @error('password')
                        <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                    Sign In
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-400">Don't have an account? 
                    <a href="{{ route('register') }}" class="text-emerald-400 hover:text-emerald-300 font-medium">Sign up</a>
                </p>
            </div>
        </div>
    </div>

</x-layout>
<x-footer />
