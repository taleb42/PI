<?php
// Inclure le fichier de connexion à la base de données
include 'db_connection.php';
session_start();

// Définir une variable pour les messages d'erreur
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if (!empty($error_message)) {
        die($error_message); // Afficher le message d'erreur et arrêter l'exécution
    }

    // Validation côté serveur
    // Vérifier que les champs ne sont pas vides
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "Tous les champs sont requis.";
    }
    // Vérifier la longueur du nom
    elseif (strlen($name) < 2) {
        $error_message = "Le nom complet doit contenir au moins 2 caractères.";
    }
    // Vérifier l'email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Veuillez entrer une adresse email valide.";
    }
    // Vérifier le mot de passe (minimum 8 caractères, lettres et chiffres)
    elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
        $error_message = "Le mot de passe doit contenir au moins 8 caractères, incluant des lettres et des chiffres.";
    }
    // Vérifier la confirmation du mot de passe
    elseif ($password !== $confirm_password) {
        $error_message = "Les mots de passe ne correspondent pas.";
    }
    else {
        // Vérifier si l'email existe déjà dans la base de données
        $sql_check = "SELECT * FROM client WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $error_message = "Cet email est déjà utilisé. Veuillez utiliser un autre email.";
        } else {
            // Chiffrer le mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insérer le nouveau client dans la table
            $sql = "INSERT INTO client (nom, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            if ($stmt === false) {
                $error_message = "Erreur dans la requête : " . $conn->error;
            } else {
                $stmt->bind_param("sss", $name, $email, $hashed_password);
                if ($stmt->execute()) {
                    // Rediriger vers la page de connexion avec un message de succès
                    header("Location: Client.php?success=Compte créé avec succès ! Veuillez vous connecter.");
                    exit();
                } else {
                    $error_message = "Erreur lors de la création du compte : " . $stmt->error;
                }
                $stmt->close();
            }
        }
        $stmt_check->close();
    }
}

// Si une erreur survient, rediriger vers signup.php avec le message d'erreur
if (!empty($error_message)) {
    header("Location: signup.php?error=" . urlencode($error_message));
    exit();
}

$conn->close();
?>