// Form validation functions
function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function validatePassword(password) {
    return password.length >= 6;
}

// Client Login form validation
document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggle
    const passwordToggles = document.querySelectorAll('.password-toggle');
    
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const passwordField = this.previousElementSibling;
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Toggle icon
            this.innerHTML = type === 'password' ? 
                '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>' : 
                '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm-2.121 2.12 2.121-2.121-2.12 2.121z"/></svg>';
        });
    });
    
    // Form validation
    const clientLoginForm = document.getElementById('clientLoginForm');
    if (clientLoginForm) {
        clientLoginForm.addEventListener('submit', function(e) {
            let isValid = true;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            
            // Reset error messages
            emailError.textContent = '';
            passwordError.textContent = '';
            
            // Validate email
            if (!validateEmail(email)) {
                emailError.textContent = 'Please enter a valid email address';
                isValid = false;
            }
            
            // Validate password
            if (!validatePassword(password)) {
                passwordError.textContent = 'Password must be at least 6 characters';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    // Admin Login form validation
    const adminLoginForm = document.getElementById('adminLoginForm');
    if (adminLoginForm) {
        adminLoginForm.addEventListener('submit', function(e) {
            let isValid = true;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const securityCode = document.getElementById('securityCode')?.value;
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            const securityCodeError = document.getElementById('securityCodeError');
            
            // Reset error messages
            emailError.textContent = '';
            passwordError.textContent = '';
            if (securityCodeError) securityCodeError.textContent = '';
            
            // Validate email
            if (!validateEmail(email)) {
                emailError.textContent = 'Please enter a valid email address';
                isValid = false;
            }
            
            // Validate password
            if (!validatePassword(password)) {
                passwordError.textContent = 'Password must be at least 6 characters';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    // Verification form validation
    const verificationForm = document.getElementById('verificationForm');
    if (verificationForm) {
        verificationForm.addEventListener('submit', function(e) {
            let isValid = true;
            const code = document.getElementById('code').value;
            const codeError = document.getElementById('codeError');
            
            // Reset error message
            codeError.textContent = '';
            
            // Validate code
            if (code.length < 4) {
                codeError.textContent = 'Verification code must be at least 4 characters';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    // Auto-fill verification code if present in URL
    const urlParams = new URLSearchParams(window.location.search);
    const codeParam = urlParams.get('code');
    if (codeParam && document.getElementById('code')) {
        document.getElementById('code').value = codeParam;
    }
});

// Function to show loading state on button
function showLoading(button, loadingText = 'Loading...') {
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = `<span class="loading"></span>${loadingText}`;
    
    // Store original text for later restoration
    button.setAttribute('data-original-text', originalText);
}

// Function to hide loading state
function hideLoading(button) {
    const originalText = button.getAttribute('data-original-text');
    if (originalText) {
        button.innerHTML = originalText;
        button.disabled = false;
    }
}

// Function to display alerts
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.textContent = message;
    
    // Add close button
    const closeButton = document.createElement('button');
    closeButton.innerHTML = '&times;';
    closeButton.className = 'close-alert';
    closeButton.style.float = 'right';
    closeButton.style.background = 'none';
    closeButton.style.border = 'none';
    closeButton.style.cursor = 'pointer';
    closeButton.style.fontSize = '1.25rem';
    closeButton.onclick = function() {
        alert.remove();
    };
    
    alert.prepend(closeButton);
    alertContainer.appendChild(alert);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

// Resend verification code
function resendVerificationCode(email, userType) {
    const resendButton = document.getElementById('resendButton');
    if (!resendButton) return;
    
    showLoading(resendButton, 'Sending...');
    
    const formData = new FormData();
    formData.append('email', email);
    formData.append('user_type', userType);
    
    fetch('resend.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        hideLoading(resendButton);
        
        if (data.success) {
            showAlert('A new verification code has been sent.', 'success');
            
            // Update the verification code display if it exists
            if (data.verification_code && document.getElementById('verificationCodeDisplay')) {
                document.getElementById('verificationCodeDisplay').textContent = data.verification_code;
            }
        } else {
            showAlert(data.message || 'Failed to resend verification code.', 'danger');
        }
    })
    .catch(error => {
        hideLoading(resendButton);
        showAlert('An error occurred. Please try again later.', 'danger');
        console.error('Error:', error);
    });
}

// Logout function
function logout() {
    window.location.href = 'logout.php';
}