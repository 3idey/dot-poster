export class Newsletter {
    constructor() {
        this.form = document.getElementById('newsletter-form');
        this.emailInput = document.getElementById('newsletter-email');
        this.submitButton = document.getElementById('newsletter-submit');
        this.messageContainer = document.getElementById('newsletter-message');
        this.successMessage = document.getElementById('newsletter-success');
        this.errorMessage = document.getElementById('newsletter-error');
        this.successText = document.getElementById('newsletter-success-text');
        this.errorText = document.getElementById('newsletter-error-text');

        this.init();
    }

    init() {
        if (this.form) {
            this.form.addEventListener('submit', this.handleSubmit.bind(this));
            console.log('Newsletter subscription initialized');
        }
    }

    async handleSubmit(e) {
        e.preventDefault();
        
        const email = this.emailInput.value.trim();
        if (!email) {
            this.showError('Please enter your email address.');
            return;
        }

        this.setLoading(true);
        this.hideMessages();

        try {
            const formData = new FormData();
            formData.append('email', email);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            const response = await fetch('/newsletter/subscribe', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.showSuccess(data.message);
                this.form.reset();
            } else {
                this.showError(data.message);
            }
        } catch (error) {
            console.error('Newsletter subscription error:', error);
            this.showError('Something went wrong. Please try again later.');
        } finally {
            this.setLoading(false);
        }
    }

    setLoading(loading) {
        if (loading) {
            this.submitButton.disabled = true;
            this.submitButton.textContent = 'Subscribing...';
            this.submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            this.submitButton.disabled = false;
            this.submitButton.textContent = 'Subscribe';
            this.submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    }

    showSuccess(message) {
        this.successText.textContent = message;
        this.messageContainer.classList.remove('hidden');
        this.successMessage.classList.remove('hidden');
        this.errorMessage.classList.add('hidden');
    }

    showError(message) {
        this.errorText.textContent = message;
        this.messageContainer.classList.remove('hidden');
        this.errorMessage.classList.remove('hidden');
        this.successMessage.classList.add('hidden');
    }

    hideMessages() {
        this.messageContainer.classList.add('hidden');
        this.successMessage.classList.add('hidden');
        this.errorMessage.classList.add('hidden');
    }
}
