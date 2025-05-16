<?php
session_start();
$error_message = isset($_GET['error']) ? htmlspecialchars(urldecode($_GET['error'])) : '';
$success_message = isset($_GET['success']) ? htmlspecialchars(urldecode($_GET['success'])) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - MyServices</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #c1ccf0 0%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        p {
            font-family: 'Poppins', sans-serif;
            color: #1f2937;
        }
        h1 i {
            font-family: 'Times New Roman', Times, serif;
            color: #3b82f6;
        }
        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            max-width: 38rem;
            width: 100%;
            transition: transform 0.3s ease;
        }
        label {
            font-family: 'Times New Roman', Times, serif;
            font-weight: 540;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .input-field {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            width: 100%;
            box-sizing: border-box;
        }
        .input-field:hover {
            border-color: #3b82f6;
        }
        .input-field:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }
        .btn {
            background: linear-gradient(to right, #3b82f6, #2563eb);
            color: white;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 0.5rem;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn:hover:not(:disabled) {
            background: linear-gradient(to right, #2563eb, #1d4ed8);
            transform: scale(1.02);
        }
        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }
        .link:hover {
            text-decoration: underline;
        }
        .error {
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 0.2rem;
            display: none;
        }
    </style>
</head>
<body>
    <div class="card">
        <!-- Afficher les messages d'erreur ou de succès -->
        <?php if (!empty($error_message)): ?>
            <div class="text-red-600 text-center mb-4"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="text-green-600 text-center mb-4"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6"><p>Create Account - <i>Khadamati</i></p></h1>
        
        <form id="create-account-form" class="space-y-5" method="POST" action="insert_client.php">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required class="input-field">
                <div id="name-error" class="error">Full name must be at least 2 characters long.</div>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required class="input-field">
                <div id="email-error" class="error">Please enter a valid email address.</div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required class="input-field">
                <div id="password-error" class="error">Password must be at least 8 characters long and contain letters and numbers.</div>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required class="input-field">
                <div id="confirm-password-error" class="error">Passwords do not match.</div>
            </div>
            <div class="checkbox-container">
                <input type="checkbox" id="terms" name="terms">
                <label for="terms">I agree to the <a href="#" class="link">Terms of Service</a></label>
                <div id="terms-error" class="error">You must agree to the Terms of Service.</div>
            </div>
            <button type="submit" id="create-account-btn" disabled class="btn">Create Account</button>
        </form>
        <p class="mt-5 text-center text-sm text-gray-600">
            Already have an account? <a href="Client.php" class="link">Sign in</a>
        </p>
    </div>

    <script>
        // Get the checkbox, button, and form elements
        const termsCheckbox = document.getElementById('terms');
        const createAccountBtn = document.getElementById('create-account-btn');
        const form = document.getElementById('create-account-form');

        // Enable/disable the button based on checkbox state
        termsCheckbox.addEventListener('change', function() {
            createAccountBtn.disabled = !termsCheckbox.checked;
        });

        // Validate the form on submission
        form.addEventListener('submit', function(event) {
            // Reset error messages
            document.querySelectorAll('.error').forEach(error => error.style.display = 'none');

            // Get form values
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const terms = document.getElementById('terms').checked;

            let isValid = true;

            // Validate name
            if (name.length < 2) {
                document.getElementById('name-error').style.display = 'block';
                isValid = false;
            }

            // Validate email
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                document.getElementById('email-error').style.display = 'block';
                isValid = false;
            }

            // Validate password (minimum 8 characters, must contain letters and numbers)
            const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
            if (!passwordPattern.test(password)) {
                document.getElementById('password-error').style.display = 'block';
                isValid = false;
            }

            // Validate confirm password
            if (password !== confirmPassword) {
                document.getElementById('confirm-password-error').style.display = 'block';
                isValid = false;
            }

            // Validate terms
            if (!terms) {
                document.getElementById('terms-error').style.display = 'block';
                isValid = false;
            }

            // If validation fails, prevent form submission
            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>