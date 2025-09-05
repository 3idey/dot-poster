export class SavedPaymentMethods {
    constructor() {
        this.currentPaymentMethodId = null;
        this.init();
    }

    init() {
        this.setupEventListeners();
    }

    setupEventListeners() {
        // Set as default buttons
        document.querySelectorAll('[onclick^="setAsDefault"]').forEach(button => {
            const paymentMethodId = this.extractIdFromOnclick(button.getAttribute('onclick'));
            button.removeAttribute('onclick');
            button.addEventListener('click', () => this.setAsDefault(paymentMethodId));
        });

        // Edit buttons
        document.querySelectorAll('[onclick^="editPaymentMethod"]').forEach(button => {
            const onclickValue = button.getAttribute('onclick');
            const matches = onclickValue.match(/editPaymentMethod\((\d+),\s*'([^']*)'\)/);
            if (matches) {
                const paymentMethodId = matches[1];
                const nickname = matches[2];
                button.removeAttribute('onclick');
                button.addEventListener('click', () => this.editPaymentMethod(paymentMethodId, nickname));
            }
        });

        // Delete buttons
        document.querySelectorAll('[onclick^="deletePaymentMethod"]').forEach(button => {
            const paymentMethodId = this.extractIdFromOnclick(button.getAttribute('onclick'));
            button.removeAttribute('onclick');
            button.addEventListener('click', () => this.deletePaymentMethod(paymentMethodId));
        });

        // Modal close buttons
        document.querySelectorAll('[onclick="closeEditModal()"]').forEach(button => {
            button.removeAttribute('onclick');
            button.addEventListener('click', () => this.closeEditModal());
        });

        // Edit form submission
        const editForm = document.getElementById('editForm');
        if (editForm) {
            editForm.addEventListener('submit', (e) => this.handleEditFormSubmit(e));
        }
    }

    extractIdFromOnclick(onclickValue) {
        const match = onclickValue.match(/\((\d+)\)/);
        return match ? match[1] : null;
    }

    setAsDefault(paymentMethodId) {
        if (confirm('Set this as your default payment method?')) {
            fetch(`/profile/saved-payment-methods/${paymentMethodId}/set-default`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error setting default payment method');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error setting default payment method');
            });
        }
    }

    editPaymentMethod(paymentMethodId, currentNickname) {
        this.currentPaymentMethodId = paymentMethodId;
        const nicknameInput = document.getElementById('nickname');
        if (nicknameInput) {
            nicknameInput.value = currentNickname || '';
        }
        
        const modal = document.getElementById('editModal');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    closeEditModal() {
        const modal = document.getElementById('editModal');
        if (modal) {
            modal.classList.add('hidden');
        }
        this.currentPaymentMethodId = null;
    }

    deletePaymentMethod(paymentMethodId) {
        if (confirm('Are you sure you want to delete this payment method? This action cannot be undone.')) {
            fetch(`/profile/saved-payment-methods/${paymentMethodId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const element = document.querySelector(`[data-payment-method-id="${paymentMethodId}"]`);
                    if (element) {
                        element.remove();
                    }
                    
                    // Check if no payment methods left
                    if (document.querySelectorAll('[data-payment-method-id]').length === 0) {
                        location.reload();
                    }
                } else {
                    alert('Error deleting payment method');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting payment method');
            });
        }
    }

    handleEditFormSubmit(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);
        
        fetch(`/profile/saved-payment-methods/${this.currentPaymentMethodId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.closeEditModal();
                location.reload();
            } else {
                alert('Error updating payment method');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating payment method');
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('[data-payment-method-id]')) {
        new SavedPaymentMethods();
    }
});
