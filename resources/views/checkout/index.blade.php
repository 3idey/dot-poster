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
                <div class="flex items-center justify-between bg-gray-900 p-3 rounded-xl">
                    <div>
                        <div class="font-medium">{{ $i->product->name }}</div>
                        <div class="text-sm text-gray-400">
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
                    <label class="relative cursor-pointer">
                        <input type="radio" name="payment_method_radio" value="cash" class="sr-only peer" checked>
                        <div class="bg-gray-800 border-2 border-gray-700 rounded-xl p-6 transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-900/20 hover:border-gray-600">
                            <div class="flex items-center space-x-3">
                                <div class="w-5 h-5 rounded-full border-2 border-gray-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 relative">
                                    <div class="absolute inset-0 rounded-full bg-emerald-500 scale-0 peer-checked:scale-50 transition-transform"></div>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Cash on Delivery</div>
                                    <div class="text-sm text-gray-400">Pay when you receive your order</div>
                                </div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="relative cursor-pointer">
                        <input type="radio" name="payment_method_radio" value="stripe" class="sr-only peer">
                        <div class="bg-gray-800 border-2 border-gray-700 rounded-xl p-6 transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-900/20 hover:border-gray-600">
                            <div class="flex items-center space-x-3">
                                <div class="w-5 h-5 rounded-full border-2 border-gray-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-500 relative">
                                    <div class="absolute inset-0 rounded-full bg-emerald-500 scale-0 peer-checked:scale-50 transition-transform"></div>
                                </div>
                                <div>
                                    <div class="font-semibold text-white">Credit/Debit Card</div>
                                    <div class="text-sm text-gray-400">Secure payment via Stripe</div>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
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
                        <div class="text-gray-300 bg-gray-700 rounded-lg p-3">
                            <span class="font-medium text-white">{{ $user->address }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Stripe Card Element -->
            <div id="stripe-section" class="hidden mb-6">
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-xl p-6 shadow-lg">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 text-emerald-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <h4 class="text-lg font-semibold text-white">Card Information</h4>
                        <div class="ml-auto flex space-x-2">
                            <img src="https://js.stripe.com/v3/fingerprinted/img/visa-729c05c240c4.svg" alt="Visa" class="h-6">
                            <img src="https://js.stripe.com/v3/fingerprinted/img/mastercard-4d8844094130.svg" alt="Mastercard" class="h-6">
                            <img src="https://js.stripe.com/v3/fingerprinted/img/amex-a49b82f46c5c.svg" alt="Amex" class="h-6">
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4 border-2 border-gray-300 focus-within:border-emerald-500 transition-colors">
                        <div id="card-element" class="min-h-[40px]">
                            <!-- Stripe Elements will create form elements here -->
                        </div>
                    </div>
                    
                    <div id="card-errors" role="alert" class="text-red-400 text-sm mt-3 min-h-[20px]"></div>
                    
                    <div class="mt-4 flex items-center text-sm text-gray-400">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        Your payment information is secure and encrypted
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
        <script>
            // Debug: Check if Stripe key is available
            console.log('Stripe key:', '{{ config("services.stripe.key") }}');
            
            // Initialize Stripe only if key exists
            let stripe = null;
            let cardElement = null;
            
            const stripeKey = '{{ config("services.stripe.key") }}';
            if (stripeKey && stripeKey !== '') {
                try {
                    stripe = Stripe(stripeKey);
                    const elements = stripe.elements();
                    cardElement = elements.create('card');
                    cardElement.mount('#card-element');
                    console.log('Stripe initialized successfully');
                } catch (error) {
                    console.error('Stripe initialization error:', error);
                }
            } else {
                console.error('Stripe key not configured');
            }

            const form = document.getElementById('checkout-form');
            const submitButton = document.getElementById('submit-button');
            const buttonText = document.getElementById('button-text');
            const spinner = document.getElementById('spinner');
            const stripeSection = document.getElementById('stripe-section');
            const paymentMethodInput = document.getElementById('selected_payment_method');

            // Debug: Check if elements exist
            console.log('Form found:', !!form);
            console.log('Stripe section found:', !!stripeSection);
            console.log('Radio buttons found:', document.querySelectorAll('input[name="payment_method_radio"]').length);

            // Handle payment method selection
            document.querySelectorAll('input[name="payment_method_radio"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    console.log('Payment method changed to:', this.value);
                    paymentMethodInput.value = this.value;
                    if (this.value === 'stripe') {
                        console.log('Showing Stripe section');
                        stripeSection.classList.remove('hidden');
                        buttonText.textContent = 'Pay ${{ number_format($total, 2) }}';
                    } else {
                        console.log('Hiding Stripe section');
                        stripeSection.classList.add('hidden');
                        buttonText.textContent = 'Place Order (COD)';
                    }
                });
            });

            // Test function to manually show Stripe section
            function testStripeSection() {
                const section = document.getElementById('stripe-section');
                if (section.classList.contains('hidden')) {
                    section.classList.remove('hidden');
                    console.log('Stripe section shown manually');
                } else {
                    section.classList.add('hidden');
                    console.log('Stripe section hidden manually');
                }
            }

            // Handle form submission
            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                if (paymentMethodInput.value === 'stripe') {
                    submitButton.disabled = true;
                    buttonText.classList.add('hidden');
                    spinner.classList.remove('hidden');

                    const {token, error} = await stripe.createToken(cardElement);

                    if (error) {
                        document.getElementById('card-errors').textContent = error.message;
                        submitButton.disabled = false;
                        buttonText.classList.remove('hidden');
                        spinner.classList.add('hidden');
                    } else {
                        document.getElementById('payment_method_id').value = token.id;
                        form.submit();
                    }
                } else {
                    form.submit();
                }
            });
        </script>
    @endif
</x-layout>
<x-footer />
