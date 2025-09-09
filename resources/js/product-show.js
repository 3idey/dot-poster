// Product show page image gallery functionality
document.addEventListener('DOMContentLoaded', function() {
    // Image modal functionality
    const imageModal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const mainImage = document.getElementById('main-product-image');
    const closeButton = document.querySelector('[data-close-image-modal]');
    const thumbnails = document.querySelectorAll('.product-thumbnail[data-change-main]');

    // Open image modal when clicking main image
    if (mainImage) {
        mainImage.addEventListener('click', function() {
            openImageModal(this.dataset.modalImage || this.src);
        });
    }

    // Thumbnail click functionality
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            changeMainImage(this.dataset.fullImage, this);
        });
    });

    // Close modal button
    if (closeButton) {
        closeButton.addEventListener('click', closeImageModal);
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });

    // Close modal when clicking outside the image
    if (imageModal) {
        imageModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    }

    function openImageModal(imageSrc) {
        if (modalImage && imageModal) {
            modalImage.src = imageSrc;
            imageModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeImageModal() {
        if (imageModal) {
            imageModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    function changeMainImage(imageSrc, clickedThumbnail) {
        if (mainImage) {
            // Update main image
            mainImage.src = imageSrc;
            mainImage.dataset.modalImage = imageSrc;
            
            // Update thumbnail borders
            thumbnails.forEach(thumb => {
                thumb.classList.remove('border-emerald-500', 'dark:border-emerald-400');
                thumb.classList.add('border-gray-300', 'dark:border-gray-600');
            });
            
            // Highlight selected thumbnail
            clickedThumbnail.classList.remove('border-gray-300', 'dark:border-gray-600');
            clickedThumbnail.classList.add('border-emerald-500', 'dark:border-emerald-400');
        }
    }
});
