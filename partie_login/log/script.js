// Fonctions de validation de formulaire
function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function validatePassword(password) {
    return password.length >= 6;
}

// Validation du formulaire de connexion client
document.addEventListener('DOMContentLoaded', function() {
    // Basculement de la visibilité du mot de passe
    const passwordToggles = document.querySelectorAll('.password-toggle');
    
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const passwordField = this.previousElementSibling;
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Basculer l'icône
            this.innerHTML = type === 'password' ? 
                '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/><path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>' : 
                '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm-2.121 2.12 2.121-2.121-2.12 2.121z"/></svg>';
        });
    });
    
    // Validation du formulaire client
    const clientLoginForm = document.getElementById('clientLoginForm');
    if (clientLoginForm) {
        clientLoginForm.addEventListener('submit', function(e) {
            let isValid = true;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');
            
            // Réinitialiser les messages d'erreur
            emailError.textContent = '';
            passwordError.textContent = '';
            
            // Valider l'email
            if (!validateEmail(email)) {
                emailError.textContent = 'Veuillez entrer une adresse e-mail valide';
                isValid = false;
            }
            
            // Valider le mot de passe
            if (!validatePassword(password)) {
                passwordError.textContent = 'Le mot de passe doit contenir au moins 6 caractères';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    // Validation du formulaire administrateur
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
            
            // Réinitialiser les messages d'erreur
            emailError.textContent = '';
            passwordError.textContent = '';
            if (securityCodeError) securityCodeError.textContent = '';
            
            // Valider l'email
            if (!validateEmail(email)) {
                emailError.textContent = 'Veuillez entrer une adresse e-mail valide';
                isValid = false;
            }
            
            // Valider le mot de passe
            if (!validatePassword(password)) {
                passwordError.textContent = 'Le mot de passe doit contenir au moins 6 caractères';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    // Validation du formulaire de vérification
    const verificationForm = document.getElementById('verificationForm');
    if (verificationForm) {
        verificationForm.addEventListener('submit', function(e) {
            let isValid = true;
            const code = document.getElementById('code').value;
            const codeError = document.getElementById('codeError');
            
            // Réinitialiser le message d'erreur
            codeError.textContent = '';
            
            // Valider le code
            if (code.length < 4) {
                codeError.textContent = 'Le code de vérification doit contenir au moins 4 caractères';
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    // Auto-remplissage du code de vérification si présent dans l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const codeParam = urlParams.get('code');
    if (codeParam && document.getElementById('code')) {
        document.getElementById('code').value = codeParam;
    }
});

// Fonction pour afficher l'état de chargement sur le bouton
function showLoading(button, loadingText = 'Chargement...') {
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = `<span class="loading"></span>${loadingText}`;
    
    // Stocker le texte original pour restauration ultérieure
    button.setAttribute('data-original-text', originalText);
}

// Fonction pour masquer l'état de chargement
function hideLoading(button) {
    const originalText = button.getAttribute('data-original-text');
    if (originalText) {
        button.innerHTML = originalText;
        button.disabled = false;
    }
}

// Fonction pour afficher les alertes
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.textContent = message;
    
    // Ajouter le bouton de fermeture
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
    
    // Suppression automatique après 5 secondes
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

// Renvoyer le code de vérification
function resendVerificationCode(email, userType) {
    const resendButton = document.getElementById('resendButton');
    if (!resendButton) return;
    
    showLoading(resendButton, 'Envoi en cours...');
    
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
            showAlert('Un nouveau code de vérification a été envoyé.', 'success');
            
            // Mettre à jour l'affichage du code de vérification s'il existe
            if (data.verification_code && document.getElementById('verificationCodeDisplay')) {
                document.getElementById('verificationCodeDisplay').textContent = data.verification_code;
            }
        } else {
            showAlert(data.message || 'Échec de l\'envoi du code de vérification.', 'danger');
        }
    })
    .catch(error => {
        hideLoading(resendButton);
        showAlert('Une erreur est survenue. Veuillez réessayer plus tard.', 'danger');
        console.error('Erreur:', error);
    });
}

// Fonction de déconnexion
function logout() {
    window.location.href = 'logout.php';
}