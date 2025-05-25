<?php
session_start();
include(__DIR__ . '/../db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM client WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $client = $stmt->get_result()->fetch_assoc();

    if ($client && password_verify($mot_de_passe, $client['password'])) {
        $_SESSION['id'] = $client['id_client'];
        $_SESSION['role'] = 'client';

        // توجيه إلى الصفحة الرئيسية أو لوحة التحكم الخاصة بالعميل
        header("Location: ../partie_login/indexx.php"); 
        exit;
    } else {
        echo "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }

        .login-box {
            background-color: white;
            padding: 30px;
            width: 350px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            text-align: center;
        }
        .signup-link {
    margin-top: 15px;
    font-size: 14px;
}

.signup-link a {
    color: #007bff;
    text-decoration: none;
}

.signup-link a:hover {
    text-decoration: underline;

    }
    </style>
</head>
<body>

<div class="login-box">
    <form method="POST" action="">
        <h2>Connexion Client</h2>
        <input type="email" name="email" placeholder="Email client" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
         <div class="signup-link">
        Pas encore de compte ?
        <a href="signup.php">Créer un compte</a>
    </div>
        <?php if (isset($erreur)) echo "<div class='error'>$erreur</div>"; ?>

       </div>
           
           

            
    </form>
</div>

</body>
</html>
