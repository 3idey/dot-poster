<x-header title="Checkout" />

<x-layout>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
                <p class="mt-2 text-gray-600">Complete your order and get your posters delivered</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                {{ implode(', ', $errors->all()) }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($items->isEmpty())
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h3>
                    <p class="text-gray-600 mb-6">Add some posters to your cart to continue with checkout</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Browse Posters
                    </a>
                </div>
            @else
                <!-- Order Summary -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                    <div class="space-y-4 mb-6">
                        @foreach ($items as $i)
                            <div class="flex items-center justify-between py-4 border-b border-gray-100 last:border-b-0">
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $i->product->name }}</div>
                                        <div class="text-sm text-gray-600">
                                            Quantity: {{ $i->quantity }} × ${{ number_format($i->product->price, 2) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="font-semibold text-gray-900">
                                    ${{ number_format($i->quantity * $i->product->price, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-semibold text-gray-900">Total</span>
                            <span class="text-2xl font-bold text-emerald-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>

        <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form" class="space-y-3">
            @csrf
            <input type="hidden" name="payment_method" id="selected_payment_method" value="cash">
            <input type="hidden" name="payment_method_id" id="payment_method_id">

                <!-- Payment Method Selection -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Payment Method</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative cursor-pointer payment-method-label" data-payment="cash">
                            <input type="radio" name="payment_method_radio" value="cash" class="sr-only" checked>
                            <div class="bg-white border-2 border-emerald-500 rounded-xl p-6 transition-all hover:border-emerald-600 payment-method-card">
                                <div class="flex items-center space-x-3">
                                    <div class="w-5 h-5 rounded-full border-2 border-emerald-500 bg-emerald-500 relative payment-radio">
                                        <div class="absolute inset-1 rounded-full bg-white scale-100 transition-transform"></div>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">Cash on Delivery</div>
                                        <div class="text-sm text-gray-600">Pay when you receive your order</div>
                                </div>
                            </div>
                        </div>
                    </label>
                    
                        <label class="relative cursor-pointer payment-method-label" data-payment="stripe">
                            <input type="radio" name="payment_method_radio" value="stripe" class="sr-only">
                            <div class="bg-white border-2 border-gray-200 rounded-xl p-6 transition-all hover:border-gray-300 payment-method-card">
                                <div class="flex items-center space-x-3">
                                    <div class="w-5 h-5 rounded-full border-2 border-gray-400 relative payment-radio">
                                    <div class="absolute inset-1 rounded-full bg-white scale-0 transition-transform"></div>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">Credit/Debit Card</div>
                                    <div class="text-sm text-gray-600">Secure payment via Stripe</div>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>

                    <!-- Saved Payment Methods -->
                    @if($savedPaymentMethods->count() > 0)
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold mb-3 text-gray-900">Or use a saved payment method</h4>
                        <div class="space-y-3">
                            @foreach($savedPaymentMethods as $savedMethod)
                                <label class="relative cursor-pointer payment-method-label" data-payment="saved" data-saved-id="{{ $savedMethod->id }}">
                                    <input type="radio" name="payment_method_radio" value="saved" class="sr-only">
                                    <div class="bg-white border-2 border-gray-200 rounded-xl p-4 transition-all hover:border-gray-300 payment-method-card">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-5 h-5 rounded-full border-2 border-gray-400 relative payment-radio">
                                                    <div class="absolute inset-1 rounded-full bg-white scale-0 transition-transform"></div>
                                                </div>
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-10 h-6 bg-gradient-to-r {{ $savedMethod->brand === 'visa' ? 'from-blue-600 to-blue-700' : ($savedMethod->brand === 'mastercard' ? 'from-red-500 to-orange-500' : 'from-gray-600 to-gray-700') }} rounded flex items-center justify-center">
                                                        <span class="text-white text-xs font-bold">{{ strtoupper(substr($savedMethod->brand, 0, 4)) }}</span>
                                                    </div>
                                                    <div>
                                                        <div class="font-semibold text-gray-900">{{ $savedMethod->display_name }}</div>
                                                        <div class="text-sm text-gray-600">Expires {{ $savedMethod->exp_month }}/{{ $savedMethod->exp_year }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($savedMethod->is_default)
                                                <span class="px-2 py-1 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-semibold">Default</span>
                                            @endif
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

                </div>

                <!-- Shipping Address Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Shipping Address</h2>
                    @if (!$user->address)
                        <input type="text" name="shipping_address" 
                               class="w-full rounded-lg px-4 py-3 bg-gray-50 border border-gray-300 text-gray-900 placeholder-gray-500 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                               placeholder="Enter your full shipping address" required>
                    @else
                        <input type="text" name="shipping_address" value="{{ $user->address }}" 
                               class="w-full rounded-lg px-4 py-3 bg-gray-50 border border-gray-300 text-gray-900 placeholder-gray-500 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                               placeholder="Enter your full shipping address" required>
                    @endif
                </div>
            </div>

                <!-- Stripe Card Element -->
                <div id="stripe-section" class="hidden">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Card Details</h2>
                        
                        <div class="relative z-10">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900">Card Information</h4>
                                    <p class="text-sm text-gray-600">Enter your payment details securely</p>
                                </div>
                            </div>
                            <div class="flex space-x-3 opacity-80">
                                <div class="w-10 h-6 bg-gradient-to-r from-blue-600 to-blue-700 rounded flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">VISA</span>
                                </div>
                                <div class="w-10 h-6 bg-gradient-to-r from-red-500 to-orange-500 rounded flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">MC</span>
                                </div>
                                <div class="w-10 h-6 bg-gradient-to-r from-blue-800 to-blue-900 rounded flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">AMEX</span>
                                </div>
                            </div>
                        </div>
                        
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 focus-within:ring-2 focus-within:ring-emerald-500/50 focus-within:border-emerald-400 transition-all duration-300">
                                <div id="card-element" class="min-h-[45px] text-gray-800">
                                    <!-- Stripe Elements will create form elements here -->
                                </div>
                            </div>
                            
                            <div id="card-errors" role="alert" class="text-red-500 text-sm mt-4 min-h-[20px] font-medium"></div>
                            
                            <!-- Save Payment Method Option -->
                            <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="checkbox" name="save_payment_method" value="1" class="w-4 h-4 text-emerald-600 bg-white border-gray-300 rounded focus:ring-emerald-500 focus:ring-2">
                                    <div>
                                        <span class="text-gray-900 font-medium">Save this payment method</span>
                                        <p class="text-sm text-gray-600">Securely save for faster checkout next time</p>
                                    </div>
                                </label>
                                <div class="mt-3 hidden" id="payment-nickname-section">
                                    <input type="text" name="payment_nickname" placeholder="Give this card a nickname (optional)" 
                                           class="w-full rounded-lg px-3 py-2 bg-white border border-gray-300 text-gray-900 placeholder-gray-500 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors text-sm">
                                </div>
                            </div>
                            
                            <div class="mt-6 flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span>256-bit SSL encryption</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="mr-2">Powered by</span>
                                    <div class="px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-xs font-semibold">
                                        Stripe
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8">
                <button type="submit" id="submit-button" 
                        class="w-full px-6 py-4 rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-semibold text-lg shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                    <span id="button-text" class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Place Order (COD)
                    </span>
                    <span id="spinner" class="hidden flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing Payment...
                    </span>
                </button>
            </div>
        </form>

        <script src="https://js.stripe.com/v3/"></script>
        @push('scripts')
            <script>
                // Initialize Stripe payment handling
                document.addEventListener('DOMContentLoaded', () => {
                    const checkoutForm = document.getElementById('checkout-form');
                    if (checkoutForm) {
                        checkoutForm.dataset.stripeKey = '{{ config("services.stripe.key") }}';
                        checkoutForm.dataset.total = '{{ $total }}';
                    }
                });
            </script>
        @endpush
    @endif
</x-layout>
<x-footer />
