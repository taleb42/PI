<?php
session_start();

if (!isset($_SESSION['id_client'])) {
    echo '<div style="text-align:center;margin-top:100px;">
            <div style="padding:20px;box-shadow:0 4px 12px rgba(0,0,0,0.1);display:inline-block;">
                <p style="font-size:1.2rem;">Veuillez vous connecter pour voir vos demandes.</p>
                <a href="../login.php" style="text-decoration:none;color:#007bff;">Connexion</a>
            </div>
          </div>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mes Demandes</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .message {
      background-color: #fff;
      padding: 30px 40px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .message h2 {
      color: #333;
    }

    .message a {
      display: inline-block;
      margin-top: 15px;
      text-decoration: none;
      color: #007bff;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="message">
    <h2>Veuillez vous connecter pour voir vos demandes.</h2>
    <a href="partie_login/login_client">Connexion</a>
  </div>
</body>
</html>
<?php
  exit();
?>