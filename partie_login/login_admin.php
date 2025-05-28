<?php
session_start();
include('../db_connection.php');
require_once '../include/functions.php';


// Check if already logged in
if (is_logged_in() && is_admin()) {
    header("Location: ../partie_admin/dashbord.php");
    exit;
}

$error_message = "";
$success_message = "";

// Process login form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = clean_input($_POST["email"]);
    $password = $_POST["password"];
    
    
    // Validate input
    if (!is_valid_email($email)) {
        $error_message = "Please enter a valid email address";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters";
    } else {
        // Attempt to login
        $result = login_admin($email, $password,);
        
        if ($result["success"]) {
            $_SESSION['role'] = 'admin';
            // Redirect to dashboard
            header("Location: ../partie_admin/dashbord.php");
            exit;
        } elseif (isset($result["verification_needed"]) && $result["verification_needed"]) {
            // Redirect to verification page
            header("Location: ../verification.php?email=" . urlencode($email) . "&user_type=admin&code=" . urlencode($result["verification_code"]));
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Login | Login and Verification System</title>
    <link rel="stylesheet" href="log/styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <svg class="icon icon-lg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #2563eb; margin: 0 auto 1rem auto; display: block;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <h1 class="form-title">khadamati Administrateur</h1>
                <p class="form-description">Login to the admin dashboard.</p>
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
            
            <form id="adminLoginForm" method="POST" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="admin@example.com" autocomplete="email" required>
                    <small id="emailError" class="text-danger"></small>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
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
                <a href="#" class="btn-link">Forgot Password?</a>
            </div>
            
            <div class="alert alert-warning mt-4" style="font-size: 0.875rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-right: 0.25rem;">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                Admin access only. Unauthorized access is prohibited.
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