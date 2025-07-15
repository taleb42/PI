<?php
session_start();
include_once("../db_connection.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];

    // حماية من الحقن
    $email = mysqli_real_escape_string($conn, $email);
    $motdepasse = mysqli_real_escape_string($conn, $motdepasse);

    $query = "SELECT * FROM employe WHERE email = '$email' AND motdepasse = '$motdepasse'";
    $result = mysqli_query($conn, $query);

    if ($user = mysqli_fetch_assoc($result)) {
        // تخزين بيانات الموظف في السيشن
        $_SESSION['employe'] = $user;
        header("Location: dashboard_emp.php");
        exit();
    } else {
        $message = "Email ou mot de passe incorrect.";
    }
}
?>

<!-- HTML بسيط مع تنسيق مدمج (CSS داخل الصفحة) -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Employé</title>
    <style>
        body {
            font-family: 'Tajawal', Arial, sans-serif;
            background: whitesmoke;
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        form {
            background: #fff;
            padding: 3rem 4rem;
            border-radius: 18px;
            box-shadow: 0 9px 90px rgba(0,0,0,0.18);
            width: 640px;
            text-align: center;
            position: relative;
        }
        h2 {
            margin-bottom: 18px;
            text-align: center;
            color:black;
            font-size: 1.5rem;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 16px 22px;
            margin-bottom: 1rem;
            border-radius: 8px;
            border: 1px solid #b2dfdb;
            background: #f8f8f8;
            font-size: 1rem;
            color: #333;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.2s;
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: black;
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px 0;
            background: linear-gradient(90deg, #00796b 60%, #26a69a 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 2px 8px rgba(38,166,154,0.12);
            cursor: pointer;
            margin-bottom: 1rem;
            transition: background 0.2s;
        }
        input[type="submit"]:hover {
            background: green;
        }
        .error {
            color: #fff;
            background: #e53935;
            border-radius: 8px;
            padding: 8px 0;
            margin-top: 10px;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(229,57,53,0.08);
        }
        .register-link {
            margin-top: 0.5rem;
        }
        .register-link a {
            color: #00796b;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        .register-link a:hover {
            color: #004d40;
        }
    </style>
</head>
<body>

<form method="POST">
    <img src="../partie_login/images/logok.jpg" alt="Logo" style="width: 200px; height: auto; margin-bottom: 10px; display: block; margin-left: 10px; margin-right: 0;">
    <h2>Connexion Employé</h2>
    <input type="email" name="email" placeholder="Email" required />
    <input type="password" name="motdepasse" placeholder="Mot de passe" required />
    <br><br>
    <input type="submit" value="Connexion" />
   
    <div class="register-link">
       Vous pas encore du compte? <a href="register_employe.php">Créer un compte</a>
    </div>
     <?php if ($message): ?>
        <p class="error"><?= $message ?></p>
    <?php endif; ?>
</form>

</body>
</html>