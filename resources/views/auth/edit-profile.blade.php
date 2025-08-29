<x-header title="Edit Profile" />
<x-layout>
    <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Profile</h1>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-gray-100 focus:ring-2 focus:ring-blue-500"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-gray-100 focus:ring-2 focus:ring-blue-500"
                    required>
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('phone')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('address')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
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


            <!-- Current Password -->
            <div class="pt-4 border-t border-gray-300">
                <label class="block text-sm font-medium text-gray-700">Current Password <span
                        class="text-red-500">*</span></label>
                <input type="password" name="current_password" required
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('current_password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700">New Password</label>
                <input type="password" name="password"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-gray-100 focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm New Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 bg-gray-100 focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Submit -->
            <div class="flex justify-end pt-4 space-x-3">
                <a href="{{ route('profile.show') }}"
                    class="px-4 py-2 rounded-lg border border-gray-400 text-gray-700 hover:bg-gray-200">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white shadow">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-layout>
<x-footer />
