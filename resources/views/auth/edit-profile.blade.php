<x-header title="Edit Profile" />
<x-layout>
    <div
        class="max-w-xl mx-auto bg-white dark:bg-gray-900 p-6 rounded-xl shadow-lg dark:shadow-emerald-900 border border-gray-200 dark:border-gray-800">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Edit Profile</h1>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-150"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-150"
                    required>
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-150">
                @error('phone')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Address</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}"
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500">
                @error('address')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Profile Picture</label>
                <input type="file" name="avatar" accept="image/*"
                    class="w-full px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-700">
                @error('avatar')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>


            <!-- Current Password (only for non-OAuth users) -->
            @if (!$user->google_id)
                <div class="pt-4 border-t border-gray-300 dark:border-gray-700">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Current Password <span
                            class="text-red-500">*</span></label>
                    <input type="password" name="current_password" required
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-150">
                    @error('current_password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            @else
                <div class="pt-4 border-t border-gray-300 dark:border-gray-700">
                    <p class="text-sm text-gray-600 dark:text-gray-300 bg-blue-50 dark:bg-blue-900 p-3 rounded-lg">
                        <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" />
                        </svg>
                        You signed in with Google. Password changes are managed through your Google account.
                    </p>
                </div>
            @endif

            <!-- New Password (only for non-OAuth users) -->
            @if (!$user->google_id)
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">New Password</label>
                    <input type="password" name="password"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-150">
                    @error('password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Confirm New
                        Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-150">
                </div>
                <!-- Submit -->
                <div class="flex justify-end pt-4 space-x-3">
                    <a href="{{ route('profile.show') }}"
                        class="px-4 py-2 rounded-lg border border-gray-400 dark:border-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-150">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-gradient-to-r from-emerald-600 to-emerald-700 dark:from-emerald-500 dark:to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 dark:hover:from-emerald-700 dark:hover:to-emerald-900 px-4 py-2 rounded-xl text-white shadow-lg dark:shadow-emerald-900 hover:shadow-xl transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        Save Changes
                    </button>
                </div>
            @endif
        </form>
    </div>
</x-layout>
<x-footer />
