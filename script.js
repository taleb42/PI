// Form validation functions
document.addEventListener('DOMContentLoaded', function() {
    // Password toggle functionality
    const passwordToggles = document.querySelectorAll('.password-toggle');
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const passwordInput = this.parentElement.querySelector('input');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });
    });

    // Form validation for both Client and Admin login forms
    const clientForm = document.getElementById('clientLoginForm');
    const adminForm = document.getElementById('adminLoginForm');

    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function validatePassword(password) {
        return password.length >= 6;
    }

    function handleFormSubmit(e, formType) {
        e.preventDefault();
        
        const form = e.target;
        const email = form.querySelector('#email').value;
        const password = form.querySelector('#password').value;
        const emailError = form.querySelector('#emailError');
        const passwordError = form.querySelector('#passwordError');
        
        // Reset error messages and styles
        emailError.textContent = '';
        emailError.style.color = 'red';
        emailError.style.fontSize = '10px';
        passwordError.textContent = '';
        passwordError.style.color = 'red';
        passwordError.style.fontSize = '10px';
        

        passwordError.style.fontSize = '10px';          let isValid = true;

        // Email validation
        if (!validateEmail(email)) {
            emailError.textContent = 'Please enter a valid email address';
            isValid = false;
        }

        // Password validation
        if (!validatePassword(password)) {
            passwordError.textContent = 'Password must be at least 6 characters long';
            isValid = false;
        }

        if (isValid) {
            // If validation passes, submit the form
            form.submit();
        }
    }

    // Add submit event listeners to both forms
    if (clientForm) {
        clientForm.addEventListener('submit', (e) => handleFormSubmit(e, 'client'));
    }
    
    if (adminForm) {
        adminForm.addEventListener('submit', (e) => handleFormSubmit(e, 'admin'));
    }

    // Real-time validation for email fields
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(input => {
        input.addEventListener('blur', function() {
            const errorElement = this.parentElement.querySelector('.text-danger');
            if (!validateEmail(this.value)) {
                errorElement.textContent = 'Please enter a valid email address';
                this.classList.add('invalid');
            } else {
                errorElement.textContent = '';
                this.classList.remove('invalid');
            }
        });
    });

    // Real-time validation for password fields
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach(input => {
        input.addEventListener('blur', function() {
            const errorElement = this.parentElement.parentElement.querySelector('.text-danger');
            if (!validatePassword(this.value)) {
                errorElement.textContent = 'Password must be at least 6 characters long';
                this.classList.add('invalid');
            } else {
                errorElement.textContent = '';
                this.classList.remove('invalid');
            }
        });
    });
});

// Logout function
function logout() {
    window.location.href = 'logout.php';
}