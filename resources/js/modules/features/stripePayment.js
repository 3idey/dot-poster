/**
 * Stripe Payment Module
 * Handles Stripe payment processing and form interactions
 */

export class StripePayment {
    constructor(options = {}) {
        this.stripeKey = options.stripeKey;
        this.stripe = null;
        this.cardElement = null;
        this.form = document.getElementById('checkout-form');
        this.submitButton = document.getElementById('submit-button');
        this.buttonText = document.getElementById('button-text');
        this.spinner = document.getElementById('spinner');
        this.stripeSection = document.getElementById('stripe-section');
        this.paymentMethodInput = document.getElementById('selected_payment_method');
        this.total = options.total || 0;

        this.init();
    }

    init() {
        if (!this.form) return;

        this.initializeStripe();
        this.setupPaymentMethodHandlers();
        this.setupFormSubmission();
    }

    initializeStripe() {
        if (!this.stripeKey || this.stripeKey === '') {
            console.error('Stripe key not configured');
            return;
        }

        try {
            this.stripe = Stripe(this.stripeKey);
            const elements = this.stripe.elements();
            this.cardElement = elements.create('card');
            this.cardElement.mount('#card-element');
            console.log('Stripe initialized successfully');
        } catch (error) {
            console.error('Stripe initialization error:', error);
        }
    }

    setupPaymentMethodHandlers() {
        const paymentLabels = document.querySelectorAll('.payment-method-label');
        
        paymentLabels.forEach(label => {
            label.addEventListener('click', (e) => {
                const paymentMethod = label.dataset.payment;
                const savedId = label.dataset.savedId;
                const radio = label.querySelector('input[type="radio"]');
                
                // Update radio selection
                document.querySelectorAll('input[name="payment_method_radio"]').forEach(r => r.checked = false);
                radio.checked = true;
                
                // Update hidden form fields
                if (paymentMethod === 'saved' && savedId) {
                    document.getElementById('selected_payment_method').value = 'saved';
                    document.getElementById('payment_method_id').value = savedId;
                } else {
                    document.getElementById('selected_payment_method').value = paymentMethod;
                    if (paymentMethod !== 'stripe') {
                        document.getElementById('payment_method_id').value = '';
                    }
                }
                
                // Update visual state
                this.updatePaymentMethodVisuals(paymentMethod);
                this.handlePaymentMethodChange(paymentMethod, savedId);
            });
        });
        
        // Handle save payment method checkbox
        const saveCheckbox = document.querySelector('input[name="save_payment_method"]');
        const nicknameSection = document.getElementById('payment-nickname-section');
        
        if (saveCheckbox && nicknameSection) {
            saveCheckbox.addEventListener('change', (e) => {
                if (e.target.checked) {
                    nicknameSection.classList.remove('hidden');
                } else {
                    nicknameSection.classList.add('hidden');
                }
            });
        }
    }

    updatePaymentMethodVisuals(selectedMethod) {
        const labels = document.querySelectorAll('.payment-method-label');
        
        labels.forEach(label => {
            const card = label.querySelector('.payment-method-card');
            const radio = label.querySelector('.payment-radio');
            const dot = radio.querySelector('div');
            const isSelected = label.dataset.payment === selectedMethod;
            
            if (isSelected) {
                card.classList.remove('border-gray-700');
                card.classList.add('border-emerald-500', 'bg-emerald-900/20');
                radio.classList.remove('border-gray-400');
                radio.classList.add('border-emerald-500', 'bg-emerald-500');
                dot.classList.remove('scale-0');
                dot.classList.add('scale-100');
            } else {
                card.classList.remove('border-emerald-500', 'bg-emerald-900/20');
                card.classList.add('border-gray-700');
                radio.classList.remove('border-emerald-500', 'bg-emerald-500');
                radio.classList.add('border-gray-400');
                dot.classList.remove('scale-100');
                dot.classList.add('scale-0');
            }
        });
    }

    handlePaymentMethodChange(paymentMethod, savedId = null) {
        this.paymentMethodInput.value = paymentMethod;
        
        // Update payment method ID if using saved payment method
        if (paymentMethod === 'saved' && savedId) {
            const paymentMethodIdInput = document.getElementById('payment_method_id');
            if (paymentMethodIdInput) {
                paymentMethodIdInput.value = savedId;
            }
        }
        
        if (paymentMethod === 'stripe') {
            this.stripeSection.classList.remove('hidden');
            this.buttonText.innerHTML = `
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                Pay $${this.total.toFixed(2)}
            `;
        } else if (paymentMethod === 'saved') {
            this.stripeSection.classList.add('hidden');
            this.buttonText.innerHTML = `
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                Pay with Saved Card $${this.total.toFixed(2)}
            `;
        } else if (paymentMethod === 'cash') {
            this.stripeSection.classList.add('hidden');
            this.buttonText.innerHTML = `
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Place Order (Cash on Delivery)
            `;
        }
    }

    setupFormSubmission() {
        this.form.addEventListener('submit', async (event) => {
            event.preventDefault();
            await this.handleFormSubmit();
        });
    }

    async handleFormSubmit() {
        if (this.paymentMethodInput.value === 'stripe') {
            await this.processStripePayment();
        } else {
            this.form.submit();
        }
    }

    async processStripePayment() {
        if (!this.stripe || !this.cardElement) {
            console.error('Stripe not initialized');
            return;
        }

        this.setLoadingState(true);

        try {
            const { token, error } = await this.stripe.createToken(this.cardElement);

            if (error) {
                this.displayError(error.message);
                this.setLoadingState(false);
            } else {
                document.getElementById('payment_method_id').value = token.id;
                this.form.submit();
            }
        } catch (error) {
            console.error('Payment processing error:', error);
            this.displayError('Payment processing failed. Please try again.');
            this.setLoadingState(false);
        }
    }

    setLoadingState(loading) {
        this.submitButton.disabled = loading;
        
        if (loading) {
            this.buttonText.classList.add('hidden');
            this.spinner.classList.remove('hidden');
        } else {
            this.buttonText.classList.remove('hidden');
            this.spinner.classList.add('hidden');
        }
    }

    displayError(message) {
        const errorElement = document.getElementById('card-errors');
        if (errorElement) {
            errorElement.textContent = message;
        }
    }
}

// Auto-initialize if checkout form exists
document.addEventListener('DOMContentLoaded', () => {
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        const stripeKey = checkoutForm.dataset.stripeKey;
        const total = parseFloat(checkoutForm.dataset.total) || 0;
        
        new StripePayment({
            stripeKey: stripeKey,
            total: total
        });
    }
});
