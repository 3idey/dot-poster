<x-header title="Register" />
<x-layout>

    <div class="max-w-2xl mx-auto mt-10">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl shadow-2xl p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Create Account</h1>
                <p class="text-gray-400">Join our poster community</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                        <input type="text" name="name" id="name" required
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                            placeholder="Enter your full name"
                            value="{{ old('name') }}">
                        @error('name')
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" required
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                            placeholder="Enter your email"
                            value="{{ old('email') }}">
                        @error('email')
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Phone Number</label>
                        <input type="tel" name="phone" id="phone_number" required
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                            placeholder="Enter your phone number"
                            value="{{ old('phone_number') }}">
                        @error('phone_number')
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-300 mb-2">City</label>
                        <input type="text" name="city" id="city" required
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                            placeholder="Enter your city"
                            value="{{ old('city') }}">
                        @error('city')
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-300 mb-2">Full Address</label>
                    <input type="text" name="address" id="address" required
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                        placeholder="Enter your complete address"
                        value="{{ old('address') }}">
                    @error('address')
                        <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Profile Picture (Optional)</label>
                    <div class="relative">
                        <input type="file" name="avatar" accept="image/*"
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 transition-colors">
                    </div>
                    @error('avatar')
                        <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                            placeholder="Create a strong password">
                        @error('password')
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                            placeholder="Confirm your password">
                        @error('password_confirmation')
                            <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                    Create Account
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-400">Already have an account? 
                    <a href="{{ route('login') }}" class="text-emerald-400 hover:text-emerald-300 font-medium">Sign in</a>
                </p>
            </div>
        </div>
    </div>

</x-layout>
<x-footer />
