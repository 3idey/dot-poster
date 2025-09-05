<x-header title="checkout" />

<x-layout>

    <h1 class="text-2xl font-semibold mb-4">Checkout</h1>

    @if ($errors->any())
        <div class="mb-4 text-red-400">{{ implode(', ', $errors->all()) }}</div>
    @endif

    @if ($items->isEmpty())
        <p>Your cart is empty.</p>
    @else
        <div class="space-y-3 mb-6">
            @foreach ($items as $i)
                <div class="flex items-center justify-between bg-white border border-gray-200 p-4 rounded-lg shadow-sm">
                    <div>
                        <div class="font-medium">{{ $i->product->name }}</div>
                        <div class="text-sm text-gray-600">
                            {{ $i->quantity }} × ${{ number_format($i->product->price, 2) }}
                        </div>
                    </div>
                    <div class="font-semibold">
                        ${{ number_format($i->quantity * $i->product->price, 2) }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mb-4 text-xl">Total: <strong>${{ number_format($total, 2) }}</strong></div>

        <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form" class="space-y-3">
            @csrf
            <input type="hidden" name="payment_method" id="selected_payment_method" value="cash">
            <input type="hidden" name="payment_method_id" id="payment_method_id">

            <!-- Payment Method Selection -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 text-white">Choose Payment Method</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="relative cursor-pointer payment-method-label" data-payment="cash">
                        <input type="radio" name="payment_method_radio" value="cash" class="sr-only" checked>
                        <div class="bg-gray-800 border-2 border-emerald-500 bg-emerald-900/20 rounded-xl p-6 transition-all hover:border-gray-600 payment-method-card">
                            <div class="flex items-center space-x-3">
                                <div class="w-5 h-5 rounded-full border-2 border-emerald-500 bg-emerald-500 relative payment-radio">
                                    <div class="absolute inset-1 rounded-full bg-white scale-100 transition-transform"></div>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Cash on Delivery</div>
                                    <div class="text-sm text-gray-400">Pay when you receive your order</div>
                                </div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="relative cursor-pointer payment-method-label" data-payment="stripe">
                        <input type="radio" name="payment_method_radio" value="stripe" class="sr-only">
                        <div class="bg-gray-800 border-2 border-gray-700 rounded-xl p-6 transition-all hover:border-gray-600 payment-method-card">
                            <div class="flex items-center space-x-3">
                                <div class="w-5 h-5 rounded-full border-2 border-gray-400 relative payment-radio">
                                    <div class="absolute inset-1 rounded-full bg-white scale-0 transition-transform"></div>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Credit/Debit Card</div>
                                    <div class="text-sm text-gray-400">Secure payment via Stripe</div>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Saved Payment Methods -->
                @if($savedPaymentMethods->count() > 0)
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-3 text-white">Or use a saved payment method</h4>
                        <div class="space-y-3">
                            @foreach($savedPaymentMethods as $savedMethod)
                                <label class="relative cursor-pointer payment-method-label" data-payment="saved" data-saved-id="{{ $savedMethod->id }}">
                                    <input type="radio" name="payment_method_radio" value="saved" class="sr-only">
                                    <div class="bg-gray-800 border-2 border-gray-700 rounded-xl p-4 transition-all hover:border-gray-600 payment-method-card">
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
                                                        <div class="font-semibold text-white">{{ $savedMethod->display_name }}</div>
                                                        <div class="text-sm text-gray-400">Expires {{ $savedMethod->exp_month }}/{{ $savedMethod->exp_year }}</div>
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

            <!-- Shipping Address Section -->
            <div class="mb-6">
                @if (!$user->address)
                    <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
                        <h4 class="text-lg font-semibold text-white mb-3">Shipping Address</h4>
                        <input type="text" name="shipping_address" 
                               class="w-full rounded-lg px-4 py-3 bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                               placeholder="Enter your full shipping address" required>
                    </div>
                @else
                    <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
                        <h4 class="text-lg font-semibold text-white mb-2">Shipping Address</h4>
                        <input type="text" name="shipping_address" value="{{ $user->address }}" 
                               class="w-full rounded-lg px-4 py-3 bg-gray-700 border border-gray-600 text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors"
                               placeholder="Enter your full shipping address" required>
                    </div>
                @endif
            </div>

            <!-- Stripe Card Element -->
            <div id="stripe-section" class="hidden mb-6">
                <div class="bg-gradient-to-br from-gray-800 via-gray-850 to-gray-900 border border-gray-700 rounded-2xl p-8 shadow-2xl relative overflow-hidden">
                    <!-- Background decoration -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-500/10 to-blue-500/10 rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-purple-500/10 to-emerald-500/10 rounded-full blur-2xl"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-white">Card Information</h4>
                                    <p class="text-sm text-gray-400">Enter your payment details securely</p>
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
                        
                        <div class="bg-white/95 backdrop-blur-sm rounded-xl p-5 border border-gray-200 shadow-inner focus-within:ring-2 focus-within:ring-emerald-500/50 focus-within:border-emerald-400 transition-all duration-300">
                            <div id="card-element" class="min-h-[45px] text-gray-800">
                                <!-- Stripe Elements will create form elements here -->
                            </div>
                        </div>
                        
                        <div id="card-errors" role="alert" class="text-red-400 text-sm mt-4 min-h-[20px] font-medium"></div>
                        
                        <!-- Save Payment Method Option -->
                        <div class="mt-6 p-4 bg-gray-700/50 rounded-lg border border-gray-600">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="save_payment_method" value="1" class="w-4 h-4 text-emerald-600 bg-gray-700 border-gray-600 rounded focus:ring-emerald-500 focus:ring-2">
                                <div>
                                    <span class="text-white font-medium">Save this payment method</span>
                                    <p class="text-sm text-gray-400">Securely save for faster checkout next time</p>
                                </div>
                            </label>
                            <div class="mt-3 hidden" id="payment-nickname-section">
                                <input type="text" name="payment_nickname" placeholder="Give this card a nickname (optional)" 
                                       class="w-full rounded-lg px-3 py-2 bg-gray-600 border border-gray-500 text-white placeholder-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-colors text-sm">
                            </div>
                        </div>
                        
                        <div class="mt-6 flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-400">
                                <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span>256-bit SSL encryption</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-400">
                                <span class="mr-2">Powered by</span>
                                <div class="px-3 py-1 bg-indigo-500/20 text-indigo-400 rounded-full text-xs font-semibold">
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
