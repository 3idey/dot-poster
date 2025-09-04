/**
 * MobileSidebar Module
 * Handles the mobile sidebar toggle functionality
 */

export class MobileSidebar {
    constructor() {
        this.sidebar = document.getElementById('mobile-sidebar');
        this.overlay = document.getElementById('mobile-sidebar-overlay');
        this.toggleButton = document.getElementById('mobile-sidebar-toggle');
        this.closeButton = document.getElementById('close-mobile-sidebar');
        this.isOpen = false;
        
        // Add initialization marker
        if (this.sidebar) {
            this.sidebar.classList.add('mobile-sidebar-initialized');
        }
        
        this.init();
    }

    init() {
        if (!this.sidebar || !this.overlay || !this.toggleButton) return;

        // Toggle sidebar when button is clicked
        this.toggleButton.addEventListener('click', (e) => {
            e.preventDefault();
            this.toggle();
        });
        
        // Close button event
        if (this.closeButton) {
            this.closeButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.close();
            });
        }
        
        // Close sidebar when clicking outside
        this.overlay.addEventListener('click', (e) => {
            e.preventDefault();
            this.close();
        });
        
        // Close sidebar when clicking on a link
        const navLinks = this.sidebar.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', () => this.close());
        });
        
        // Close sidebar when pressing escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.close();
            }
        });
        
        // Close sidebar when window is resized to desktop
        const handleResize = () => {
            if (window.innerWidth >= 1024) {
                this.close();
            }
        };
        
        window.addEventListener('resize', handleResize);
        
        // Cleanup event listeners when instance is destroyed
        this.cleanup = () => {
            window.removeEventListener('resize', handleResize);
        };
    }

    toggle() {
        if (this.isOpen) {
            this.close();
        } else {
            this.open();
        }
    }

    open() {
        this.sidebar.classList.remove('-translate-x-full');
        this.overlay.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        this.isOpen = true;
    }

    close() {
        if (!this.sidebar || !this.overlay) return;
        
        this.sidebar.classList.add('-translate-x-full');
        this.overlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        this.isOpen = false;
        
        // Dispatch custom event
        const event = new CustomEvent('mobile-sidebar:closed', { detail: { sidebar: this } });
        document.dispatchEvent(event);
    }
    
    // Clean up event listeners
    destroy() {
        if (this.cleanup) {
            this.cleanup();
        }
        
        // Remove initialization marker
        if (this.sidebar) {
            this.sidebar.classList.remove('mobile-sidebar-initialized');
        }
        
        // Dispatch custom event
        const event = new CustomEvent('mobile-sidebar:destroyed', { detail: { sidebar: this } });
        document.dispatchEvent(event);
    }
}

// Auto-initialize if data-auto-init is present on the body
document.addEventListener('DOMContentLoaded', () => {
    if (document.body.hasAttribute('data-mobile-sidebar')) {
        new MobileSidebar();
    }
});
