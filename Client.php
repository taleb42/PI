<?php
// Inclure le fichier de connexion à la base de données
include 'db_connection.php';
session_start(); // Démarrer la session

// Définir une variable pour les messages d'erreur
$error_message = '';
$debug_message = ''; // Variable pour les messages de débogage

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier que les champs ne sont pas vides
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error_message = "Veuillez entrer l'adresse email et le mot de passe.";
    } else {
        // Récupérer les données du formulaire
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Stocker l'email dans la session
        $_SESSION['email'] = $email;
        $debug_message .= "Email saisi : $email<br>";

        // Vérifier l'existence de l'utilisateur dans la base de données
        $sql = "SELECT * FROM client WHERE email = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            $error_message = "Erreur dans la requête : " . $conn->error;
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            $debug_message .= "Nombre de résultats : " . $result->num_rows . "<br>";

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $debug_message .= "Mot de passe stocké : " . $row['password'] . "<br>";
                $debug_message .= "Mot de passe saisi : $password<br>";

                // Vérifier le mot de passe directement (car il n'est pas chiffré)
                if (password_verify($password, $row['password'])) {
                    $_SESSION['loggedin'] = true; // Définir l'état de connexion
                    $debug_message .= "Connexion réussie, redirection en cours...<br>";
                    header("Location: dashboard.php");
                    exit(); // S'assurer que l'exécution s'arrête après la redirection
                } else {
                    $error_message = "Adresse email ou mot de passe incorrect.";
                }
            } else {
                $error_message = "Adresse email non trouvée.";
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Login | Login and Verification System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="alertContainer">
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <svg class="icon icon-lg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color: #2563eb; margin: 0 auto 1rem auto; display: block;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <h1 class="form-title">Client Login</h1>
                <p class="form-description">Login to access your account.</p>
            </div>
            <form id="clientLoginForm" method="POST" action="">
                <div class="form-group">
                    <label for="email">Email <small id="emailError" class="text-danger"></small></label>
                    <input type="email" id="email" name="email" placeholder="Enter your E-mail" autocomplete="email">
                </div>
                <div class="form-group">
                    <label for="password">Password <small id="passwordError" class="text-danger"></small></label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password">
                        <button type="button" class="password-toggle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 1 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-block">Login</button>
            </form>
            <div class="separator">OR</div>
            <div class="d-flex justify-between">
                <a href="Administrator.php" class="btn-link">Administrator Login</a>
                <a href="#" class="btn-link">Forgot Password?</a>
            </div>
            <div class="creat_cont_text">
                <p>Don't have an account? <a href="signup.php" class="btn-link">Create an account</a></p>
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
    <script src="script.js"></script>
</body>
</html>