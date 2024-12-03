document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('mdp');
    const confimPasswordInput = document.getElementById('confirmerMdp');
    const togglePasswordIcon = document.getElementById('togglePassword');
    const toggleConfirmPasswordIcon = document.getElementById('toggleConfirmPassword');

	
    togglePasswordIcon.addEventListener('click', function(e) {

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        } else {
            passwordInput.type = 'password';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        }
    });

	toggleConfirmPasswordIcon.addEventListener('click', function(e) {

        if (confimPasswordInput.type === 'password') {
            confimPasswordInput.type = 'text';
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        } else {
            confimPasswordInput.type = 'password';
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        }
    });
});
