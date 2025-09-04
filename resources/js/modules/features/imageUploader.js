import { showElement, hideElement, addClass, removeClass } from '../utils/dom';

export class ImageUploader {
    constructor(options) {
        this.uploadArea = document.getElementById(options.uploadAreaId);
        this.imageInput = document.getElementById(options.imageInputId);
        this.imagePreview = document.getElementById(options.imagePreviewId);
        this.previewImg = document.getElementById(options.previewImgId);
        this.removeBtn = document.getElementById(options.removeBtnId);
        this.currentImage = document.getElementById(options.currentImageId);
        this.changeImageBtn = document.getElementById(options.changeImageBtnId);

        this.initialize();
    }

    initialize() {
        console.log('ImageUploader initialize called', {
            uploadArea: !!this.uploadArea,
            imageInput: !!this.imageInput,
            imagePreview: !!this.imagePreview,
            previewImg: !!this.previewImg
        });

        if (!this.uploadArea || !this.imageInput) {
            console.log('Missing required elements for ImageUploader');
            return;
        }

        // Handle upload area click
        this.uploadArea.addEventListener('click', () => {
            console.log('Upload area clicked');
            this.imageInput.click();
        });

        // Handle change image button click
        if (this.changeImageBtn) {
            this.changeImageBtn.addEventListener('click', () => this.showUploadArea());
        }

        // Handle file input change
        this.imageInput.addEventListener('change', (e) => this.handleFileSelect(e));

        // Handle remove image
        if (this.removeBtn) {
            this.removeBtn.addEventListener('click', () => this.removeImage());
        }

        // Drag and drop functionality
        this.setupDragAndDrop();
    }

    showUploadArea() {
        showElement(this.uploadArea);
        if (this.currentImage) {
            hideElement(this.currentImage);
        }
    }

    handleFileSelect(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (!file.type.match('image.*')) {
            alert('Please select an image file');
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            if (this.previewImg) {
                this.previewImg.src = e.target.result;
            }
            if (this.imagePreview) {
                showElement(this.imagePreview);
            }
            hideElement(this.uploadArea);
            if (this.currentImage) {
                hideElement(this.currentImage);
            }
        };
        reader.readAsDataURL(file);
    }

    removeImage() {
        this.imageInput.value = '';
        if (this.imagePreview) {
            hideElement(this.imagePreview);
        }
        
        if (this.currentImage) {
            showElement(this.currentImage);
            hideElement(this.uploadArea);
        } else {
            showElement(this.uploadArea);
        }
    }

    setupDragAndDrop() {
        if (!this.uploadArea) return;

        const handleDragOver = (e) => {
            e.preventDefault();
            addClass(this.uploadArea, 'border-blue-400', 'bg-blue-50');
        };

        const handleDragLeave = (e) => {
            e.preventDefault();
            removeClass(this.uploadArea, 'border-blue-400', 'bg-blue-50');
        };

        const handleDrop = (e) => {
            e.preventDefault();
            removeClass(this.uploadArea, 'border-blue-400', 'bg-blue-50');

            const files = e.dataTransfer.files;
            if (files.length > 0 && files[0].type.match('image.*')) {
                this.imageInput.files = files;
                const event = new Event('change', { bubbles: true });
                this.imageInput.dispatchEvent(event);
            }
        };

        this.uploadArea.addEventListener('dragover', handleDragOver);
        this.uploadArea.addEventListener('dragleave', handleDragLeave);
        this.uploadArea.addEventListener('drop', handleDrop);
    }
}
