// resources/js/app.js
import './bootstrap';

import.meta.glob([
  '../images/**',
]);

// Logic untuk Landing Page
document.addEventListener('alpine:init', () => {
    // 1. Komponen Navbar (Scroll Effect & Mobile Menu)
    Alpine.data('navbar', () => ({
        scrolled: false,
        mobileMenuOpen: false,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 20;
            });
        }
    }));

    // 2. Komponen Intersection Observer (Animasi saat di-scroll)
    Alpine.data('animateOnScroll', () => ({
        shown: false,
        init() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.shown = true;
                        observer.unobserve(this.$el);
                    }
                });
            }, { threshold: 0.1 });
            
            observer.observe(this.$el);
        }
    }));
});