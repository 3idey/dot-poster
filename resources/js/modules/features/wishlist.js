/**
 * Wishlist functionality
 */

export class Wishlist {
    constructor() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        // Event delegation for dynamically added elements
        document.addEventListener('click', (e) => {
            const wishlistButton = e.target.closest('[data-wishlist-button]');
            if (wishlistButton) {
                e.preventDefault();
                const productId = wishlistButton.dataset.productId;
                if (productId) {
                    this.toggleWishlist(productId, wishlistButton);
                }
            }
        });
    }

    async toggleWishlist(productId, button) {
        if (!this.csrfToken) {
            console.error('CSRF token not found');
            return;
        }

        try {
            const response = await fetch(button.dataset.wishlistUrl || '/wishlist/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ product_id: productId })
            });

            const data = await response.json();

            if (data.success) {
                this.updateWishlistUI(button, data.in_wishlist);
                
                // If we're on the wishlist page, remove the item from the list
                if (window.location.pathname.includes('wishlist')) {
                    const itemElement = button.closest('[data-wishlist-item]');
                    if (itemElement) {
                        itemElement.remove();
                        
                        // Check if wishlist is empty
                        const wishlistContainer = document.querySelector('[data-wishlist-container]');
                        const emptyState = document.querySelector('[data-wishlist-empty]');
                        
                        if (wishlistContainer && emptyState && 
                            !wishlistContainer.querySelector('[data-wishlist-item]')) {
                            wishlistContainer.innerHTML = emptyState.innerHTML;
                        }
                    }
                }
                
                // Show success message
                this.showNotification(data.message || 'Wishlist updated');
            } else {
                throw new Error(data.message || 'Failed to update wishlist');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showNotification(error.message || 'Something went wrong', 'error');
        }
    }

    updateWishlistUI(button, inWishlist) {
        if (!button) return;
        
        // Update button classes
        if (inWishlist) {
            button.className = 'p-2 rounded-lg border transition-all duration-200 text-red-500 border-red-500 hover:bg-red-500/10';
        } else {
            button.className = 'p-2 rounded-lg border transition-all duration-200 text-gray-400 border-gray-300 hover:border-red-500 hover:text-red-500';
        }
        
        // Update title/aria-label
        const action = inWishlist ? 'Remove from' : 'Add to';
        button.setAttribute('title', `${action} wishlist`);
        button.setAttribute('aria-label', `${action} wishlist`);
        
        // Update icon fill
        const icon = button.querySelector('svg');
        if (icon) {
            icon.setAttribute('fill', inWishlist ? 'currentColor' : 'none');
        }
        
        // Update text if it exists (for detailed wishlist buttons)
        const textSpan = button.querySelector('span');
        if (textSpan) {
            textSpan.textContent = inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist';
        }
    }

    showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform translate-x-full opacity-0 transition-all duration-300 ${
            type === 'error' ? 'bg-red-600 text-white' : 'bg-emerald-600 text-white'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => {
            notification.classList.remove('translate-x-full', 'opacity-0');
        }, 100);
        
        // Hide notification after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
}
