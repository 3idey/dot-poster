/**
 * Image Preview Module
 * Handles product image thumbnail clicks and main image updates
 */
export class ImagePreview {
    constructor() {
        this.mainImage = null;
        this.thumbnails = [];
        this.init();
    }

    init() {
        // Find the main product image
        this.mainImage = document.getElementById('main-product-image');
        if (!this.mainImage) return;

        // Find all thumbnail images
        this.thumbnails = document.querySelectorAll('.product-thumbnail');
        
        // Add click handlers to thumbnails
        this.thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', (e) => {
                e.preventDefault();
                this.updateMainImage(thumbnail);
            });
        });

        // Add initialization marker
        document.body.classList.add('image-preview-initialized');
    }

    updateMainImage(thumbnail) {
        if (!this.mainImage || !thumbnail) return;

        const newImageSrc = thumbnail.dataset.fullImage || thumbnail.src;
        const newImageAlt = thumbnail.alt;

        // Update main image with smooth transition
        this.mainImage.style.opacity = '0.7';
        
        setTimeout(() => {
            this.mainImage.src = newImageSrc;
            this.mainImage.alt = newImageAlt;
            this.mainImage.style.opacity = '1';
        }, 150);

        // Update active thumbnail styling
        this.updateActiveThumbnail(thumbnail);
    }

    updateActiveThumbnail(activeThumbnail) {
        // Remove active class from all thumbnails
        this.thumbnails.forEach(thumb => {
            thumb.classList.remove('border-emerald-500');
            thumb.classList.add('border-gray-700');
        });

        // Add active class to clicked thumbnail
        activeThumbnail.classList.remove('border-gray-700');
        activeThumbnail.classList.add('border-emerald-500');
    }

    // Clean up event listeners
    destroy() {
        this.thumbnails.forEach(thumbnail => {
            thumbnail.removeEventListener('click', this.updateMainImage);
        });
        
        document.body.classList.remove('image-preview-initialized');
        
        // Dispatch custom event
        const event = new CustomEvent('image-preview:destroyed');
        document.dispatchEvent(event);
    }
}
