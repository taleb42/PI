<?php
session_start();
include(__DIR__ . '/../db_connection.php');

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['password'];

    // Vérification dans la table administrateur
    $stmt = $conn->prepare("SELECT * FROM administrateur WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();

    if ($admin && password_verify($mot_de_passe, $admin['password'])) {
        $_SESSION['id'] = $admin['id_admin'];
        $_SESSION['role'] = "admin";
        header("Location: login_dashbors.php");
        exit;
    }

    // Vérification dans la table client
    $stmt = $conn->prepare("SELECT * FROM client WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $client = $stmt->get_result()->fetch_assoc();

    if ($client && password_verify($mot_de_passe, $client['password'])) {
        $_SESSION['id'] = $client['id_client'];
        $_SESSION['role'] = "client";
        header("Location: login_dashbors.php");
        exit;
    }

    $erreur = "Adresse e-mail ou mot de passe incorrect.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 350px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; }
        input[type="email"], input[type="password"] {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error { color: red; text-align: center; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Connexion</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Adresse e-mail" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" value="Se connecter">
        </form>
        <?php if (!empty($erreur)) echo "<p class='error'>$erreur</p>"; ?>
    </div>
</body>
</html>
