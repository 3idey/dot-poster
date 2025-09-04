/**
 * Star Rating Module
 * Handles interactive star rating functionality
 */
export class StarRating {
    constructor() {
        this.stars = document.querySelectorAll('.star-rating');
        this.ratingInputs = document.querySelectorAll('input[name="rating"]');
        this.currentRating = 0;
        this.init();
    }

    init() {
        if (this.stars.length === 0) return;

        // Add event listeners to stars
        this.stars.forEach((star, index) => {
            star.addEventListener('mouseenter', () => this.highlightStars(index + 1));
            star.addEventListener('mouseleave', () => this.resetStars());
            star.addEventListener('click', () => this.selectRating(index + 1));
        });

        // Add initialization marker
        document.body.classList.add('star-rating-initialized');
    }

    highlightStars(rating) {
        this.stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('text-gray-600');
                star.classList.add('text-yellow-400', 'fill-current');
            } else {
                star.classList.remove('text-yellow-400', 'fill-current');
                star.classList.add('text-gray-600');
            }
        });
    }

    resetStars() {
        // Reset to current selected rating or no rating
        this.highlightStars(this.currentRating);
    }

    selectRating(rating) {
        this.currentRating = rating;
        
        // Update the corresponding radio input
        const radioInput = document.getElementById(`star${rating}`);
        if (radioInput) {
            radioInput.checked = true;
        }

        // Update visual state
        this.highlightStars(rating);
        
        // Dispatch custom event
        const event = new CustomEvent('rating:selected', { 
            detail: { rating: rating } 
        });
        document.dispatchEvent(event);
    }

    // Clean up event listeners
    destroy() {
        this.stars.forEach(star => {
            star.removeEventListener('mouseenter', this.highlightStars);
            star.removeEventListener('mouseleave', this.resetStars);
            star.removeEventListener('click', this.selectRating);
        });
        
        document.body.classList.remove('star-rating-initialized');
        
        // Dispatch custom event
        const event = new CustomEvent('star-rating:destroyed');
        document.dispatchEvent(event);
    }
}
