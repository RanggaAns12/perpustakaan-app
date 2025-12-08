// resources/js/login.js

document.addEventListener('alpine:init', () => {
    Alpine.data('loginForm', () => ({
        showPassword: false,
        isLoading: false,
        username: '',
        password: '',

        togglePassword() {
            this.showPassword = !this.showPassword;
        },

        async submitForm() {
            this.isLoading = true;
            // Logika tambahan jika diperlukan sebelum submit
        }
    }));
});