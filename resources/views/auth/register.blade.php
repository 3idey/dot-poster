<x-header title="Register" />
<x-layout>

    <div class=" mr-10 container mx-auto mt-10 p-6 mb-15 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl font-bold mb-4 text-center">Register</h1>
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('name') }}">
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('email') }}">
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="tel" name="phone" id="phone_number" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('phone_number') }}">
                @error('phone_number')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                <input type="text" name="city" id="city" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('city') }}">
                @error('city')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" id="address" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    value="{{ old('address') }}">
                @error('address')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label class="block text-sm">Profile Picture</label>
                <input type="file" name="avatar" accept="image/*"
                    class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white">
                @error('avatar')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                    Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('password_confirmation')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <x-button name="Register" type="submit" />
        </form>
    </div>

</x-layout>
<x-footer />
