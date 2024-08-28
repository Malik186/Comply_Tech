<script>
    document.querySelectorAll('.toggle-form').forEach(function(element) {
        element.addEventListener('click', function() {
            const signInForm = document.getElementById('sign-in');
            const signUpForm = document.getElementById('sign-up');
            const formTitle = document.getElementById('form-title');
            const formSubtitle = document.getElementById('form-subtitle');
            const socialText = document.getElementById('social-text');

            if (signInForm.style.display === 'block') {
                signInForm.style.display = 'none';
                signUpForm.style.display = 'block';
                formTitle.textContent = 'Get started with Us';
                formSubtitle.textContent = 'Register a new membership';
                socialText.textContent = 'Sign Up With';
            } else {
                signInForm.style.display = 'block';
                signUpForm.style.display = 'none';
                formTitle.textContent = "Let's Get Started";
                formSubtitle.textContent = 'Sign in to continue to Comply Tech.';
                socialText.textContent = 'Sign With';
            }
        });
    });
</script>