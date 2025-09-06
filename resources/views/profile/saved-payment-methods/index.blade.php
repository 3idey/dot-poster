<x-header title="Saved Payment Methods" />

<x-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Saved Payment Methods</h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">Manage your saved cards for faster checkout</p>
                    </div>
                    <a href="{{ route('profile.show') }}"
                        class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Profile
                    </a>
                </div>
            </div>

            @if ($savedPaymentMethods->count() > 0)
                <!-- Payment Methods Grid -->
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($savedPaymentMethods as $method)
                        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 hover:border-gray-300 dark:hover:border-gray-700 transition-colors shadow-sm dark:shadow-emerald-900"
                            data-payment-method-id="{{ $method->id }}">
                            <!-- Card Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <!-- Card Brand Icon -->
                                    <div
                                        class="w-12 h-8 bg-gradient-to-r from-blue-500 to-purple-600 dark:from-blue-700 dark:to-purple-900 rounded-lg flex items-center justify-center">
                                        <span
                                            class="text-white text-xs font-bold">{{ strtoupper(substr($method->brand ?? 'CARD', 0, 4)) }}</span>
                                    </div>
                                    <div>
                                        <h3 class="text-gray-900 dark:text-gray-100 font-semibold">
                                            {{ $method->display_name }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">•••• •••• ••••
                                            {{ $method->last_four }}</p>
                                    </div>
                                </div>

                                <!-- Default Badge -->
                                @if ($method->is_default)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-300">
                                        Default
                                    </span>
                                @endif
                            </div>

                            <!-- Card Details -->
                            <div class="space-y-2 mb-6">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-300">Expires</span>
                                    <span
                                        class="text-gray-900 dark:text-gray-100">{{ str_pad($method->exp_month, 2, '0', STR_PAD_LEFT) }}/{{ $method->exp_year }}</span>
                                </div>
                                @if ($method->is_expired)
                                    <div class="flex items-center text-red-500 dark:text-red-400 text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Expired
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                @if (!$method->is_default)
                                    <button onclick="setAsDefault({{ $method->id }})"
                                        class="flex-1 px-3 py-2 bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-700 dark:hover:bg-emerald-800 text-white text-sm rounded-lg transition-colors">
                                        Set Default
                                    </button>
                                @endif
                                <button onclick="editPaymentMethod({{ $method->id }}, '{{ $method->nickname }}')"
                                    class="flex-1 px-3 py-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 text-sm rounded-lg transition-colors">
                                    Edit
                                </button>
                                <button onclick="deletePaymentMethod({{ $method->id }})"
                                    class="px-3 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white text-sm rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div
                        class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">No Saved Payment Methods
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">You haven't saved any payment methods yet. Save a
                        card during checkout
                        for faster future purchases.</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-700 dark:hover:bg-emerald-800 text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Edit Payment Method Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 dark:bg-opacity-70 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-900 rounded-xl max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Edit Payment Method</h3>
                    <button onclick="closeEditModal()"
                        class="text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form id="editForm">
                    <div class="mb-4">
                        <label for="nickname"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Nickname</label>
                        <input type="text" id="nickname" name="nickname"
                            placeholder="e.g., Personal Card, Work Card"
                            class="w-full rounded-lg px-3 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors">
                    </div>

                    <div class="flex space-x-3">
                        <button type="button" onclick="closeEditModal()"
                            class="flex-1 px-4 py-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-700 dark:hover:bg-emerald-800 text-white rounded-lg transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite(['resources/js/modules/features/savedPaymentMethods.js'])
    @endpush
</x-layout>

<x-footer />
