export class DarkMode {
    constructor() {
        this.toggleButtons = document.querySelectorAll('[id^="dark-mode-toggle"]');
        this.html = document.documentElement;
        this.darkMode = localStorage.getItem('darkMode') === 'true' || 
                       (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches);
        
        this.init();
    }

    init() {
        // Set initial mode
        this.setMode(this.darkMode);
        
        // Add event listeners to all toggle buttons
        this.toggleButtons.forEach(button => {
            button.addEventListener('click', () => this.toggleMode());
        });
        
        // Watch for system color scheme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (localStorage.getItem('darkMode') === null) {
                this.setMode(e.matches);
            }
        });
    }

    toggleMode() {
        this.darkMode = !this.darkMode;
        this.setMode(this.darkMode);
        localStorage.setItem('darkMode', this.darkMode);
    }

    setMode(isDark) {
        // Toggle dark class on html element
        if (isDark) {
            this.html.classList.add('dark');
            document.querySelectorAll('.dark-mode-icon').forEach(icon => icon.classList.add('hidden'));
            document.querySelectorAll('.light-mode-icon').forEach(icon => icon.classList.remove('hidden'));
            document.querySelectorAll('.dark-mode-text').forEach(el => el.textContent = 'Light Mode');
        } else {
            this.html.classList.remove('dark');
            document.querySelectorAll('.dark-mode-icon').forEach(icon => icon.classList.remove('hidden'));
            document.querySelectorAll('.light-mode-icon').forEach(icon => icon.classList.add('hidden'));
            document.querySelectorAll('.dark-mode-text').forEach(el => el.textContent = 'Dark Mode');
        }
    }
}
