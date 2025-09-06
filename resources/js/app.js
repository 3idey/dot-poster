import './bootstrap';
import { ImageUploader } from './modules/features/imageUploader.js';
import { MobileSidebar } from './modules/features/mobileSidebar.js';
import { ImagePreview } from './modules/features/imagePreview.js';
import { StarRating } from './modules/features/starRating.js';
import { Wishlist } from './modules/features/wishlist.js';
import { StripePayment } from './modules/features/stripePayment.js';
import { SavedPaymentMethods } from './modules/features/savedPaymentMethods.js';
import { DarkMode } from './modules/features/darkMode.js';

document.addEventListener('DOMContentLoaded', function () {
    // Initialize Dark Mode
    new DarkMode();

    // Initialize Image Uploader if the required elements exist
    if (document.getElementById('upload-area') && document.getElementById('image')) {
        console.log('Initializing ImageUploader...');
        new ImageUploader({
            uploadAreaId: 'upload-area',
            imageInputId: 'image',
            imagePreviewId: 'image-preview',
            previewImgId: 'preview-img',
            removeBtnId: 'remove-image',
            currentImageId: 'current-image',
            changeImageBtnId: 'change-image-btn'
        });
    } else {
        console.log('ImageUploader elements not found:', {
            uploadArea: !!document.getElementById('upload-area'),
            imageInput: !!document.getElementById('image')
        });
    }

    // Initialize Wishlist if we're on a page with wishlist functionality
    if (document.querySelector('[data-wishlist-button]') || window.location.pathname.includes('wishlist')) {
        new Wishlist();
    }

    // Initialize Mobile Sidebar
    new MobileSidebar();

    // Initialize Image Preview if on product show page
    if (document.getElementById('main-product-image')) {
        new ImagePreview();
    }

    // Initialize Stripe Payment if on checkout page
    if (document.getElementById('payment-form')) {
        new StripePayment();
    }

    // Initialize Star Rating if rating elements exist
    if (document.querySelector('.star-rating')) {
        console.log('Initializing StarRating...');
        new StarRating();
    }

    // Initialize saved payment methods functionality
    if (document.querySelector('[data-payment-method-id]')) {
        new SavedPaymentMethods();
    }

    // Initialize Newsletter subscription
    if (document.getElementById('newsletter-form')) {
        console.log('Initializing Newsletter...');
        new Newsletter();
    }
});
