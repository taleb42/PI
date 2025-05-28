<?php
// Start session
require_once '../include/db_config.php';
require_once '../include/functions.php';
session_start();

// Check if already logged in
if (is_logged_in() && is_client()) {
    header("Location: indexx.php");
    exit;
}

$error_message = "";
$success_message = "";

// Process login form

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    // Validate input
    if (!is_valid_email($email)) {
        $error_message = "Please enter a valid email address";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters";
    } else {
        // Attempt to login
        $result = login_client($email, $password);
        
        if ($result["success"]) {
            // Redirect to dashboard
            $stmt = $conn->prepare("SELECT * FROM client WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $client = $stmt->get_result()->fetch_assoc();
            $_SESSION['id'] = $client['id_client'];
            $_SESSION['role'] = 'client';
            header("Location: indexx.php");
            exit;
        } elseif (isset($result["verification_needed"]) && $result["verification_needed"]) {
            // Redirect to verification page
            header("Location: ../verification.php?email=" . urlencode($email) . "&user_type=client&code=" . urlencode($result["verification_code"]));
            exit;
        } else {
            $error_message = $result["message"];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Login | Login and Verification System</title>
    <link rel="stylesheet" href="log/styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <svg class="icon icon-lg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #2563eb; margin: 0 auto 1rem auto; display: block;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <h1 class="form-title">Khadamati</h1>
                <p class="form-description">Login to access your account.</p>
            </div>
            
            <div id="alertContainer">
                <?php if ($error_message): ?>
                    <div class="alert alert-danger">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success_message): ?>
                    <div class="alert alert-success">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <form id="clientLoginForm" method="POST" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="your.email@example.com" autocomplete="email" required>
                    <small id="emailError" class="text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label for="password">mote de passe</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                        <button type="button" class="password-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </button>
                    </div>
                    <small id="passwordError" class="text-danger"></small>
                </div>
                
                <button type="submit" class="btn btn-block">Login</button>
            </form>
            
            <div class="separator">OR</div>
            
            <div class="d-flex justify-between">
                <a href="signup.php" class="btn-link">creer un compte</a>
                <a href="#" class="btn-link">Forgot Password?</a>
            </div>
        </div>
    </div>
    
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <p class="footer-text">&copy; <?php echo date('Y'); ?> Login and Verification System</p>
            </div>
        </div>
    </footer>
    
    <script src="log/script.js"></script>
</body>
</html>