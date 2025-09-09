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
        this.initializeVisualState();
        this.setupThemeChangeListener();
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

    initializeVisualState() {
        // Set initial visual state based on the default checked radio button
        const checkedRadio = document.querySelector('input[name="payment_method_radio"]:checked');
        if (checkedRadio) {
            const label = checkedRadio.closest('.payment-method-label');
            const paymentMethod = label.dataset.payment;
            const savedId = label.dataset.savedId;
            
            const visualMethod = paymentMethod === 'saved' ? `saved_${savedId}` : paymentMethod;
            this.updatePaymentMethodVisuals(visualMethod);
            this.handlePaymentMethodChange(paymentMethod, savedId);
        }
    }

    setupThemeChangeListener() {
        // Listen for theme changes and update visual states
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    // Re-initialize visual state when theme changes
                    setTimeout(() => {
                        this.initializeVisualState();
                    }, 10);
                }
            });
        });
        
        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class']
        });
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
                
                // Update visual state - pass the specific selection context for saved methods
                const visualMethod = paymentMethod === 'saved' ? `saved_${savedId}` : paymentMethod;
                this.updatePaymentMethodVisuals(visualMethod);
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
            const paymentMethod = label.dataset.payment;
            const savedId = label.dataset.savedId;
            
            // Check if this label should be selected
            let isSelected = false;
            if (selectedMethod.startsWith('saved_')) {
                // For saved methods, match the specific saved ID
                const targetSavedId = selectedMethod.replace('saved_', '');
                isSelected = (paymentMethod === 'saved' && savedId === targetSavedId);
            } else {
                // For regular payment methods
                isSelected = (paymentMethod === selectedMethod);
            }
            
            // Remove all payment state classes first
            card.classList.remove('payment-method-selected', 'payment-method-unselected');
            radio.classList.remove('payment-radio-selected', 'payment-radio-unselected');
            dot.classList.remove('payment-dot-selected', 'payment-dot-unselected');
            
            if (isSelected) {
                card.classList.add('payment-method-selected');
                radio.classList.add('payment-radio-selected');
                dot.classList.add('payment-dot-selected');
            } else {
                card.classList.add('payment-method-unselected');
                radio.classList.add('payment-radio-unselected');
                dot.classList.add('payment-dot-unselected');
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
