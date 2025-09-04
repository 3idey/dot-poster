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
        const paymentRadios = document.querySelectorAll('input[name="payment_method_radio"]');
        
        paymentRadios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                this.handlePaymentMethodChange(e.target.value);
            });
        });
    }

    handlePaymentMethodChange(paymentMethod) {
        this.paymentMethodInput.value = paymentMethod;
        
        if (paymentMethod === 'stripe') {
            this.stripeSection.classList.remove('hidden');
            this.buttonText.textContent = `Pay $${this.total.toFixed(2)}`;
        } else {
            this.stripeSection.classList.add('hidden');
            this.buttonText.textContent = 'Place Order (COD)';
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
