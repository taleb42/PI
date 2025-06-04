
<?php
session_start();
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "khadamati");
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    $email = $_POST["email"];
    $motdepasse = $_POST["motdepasse"];

    $sql = "SELECT * FROM employe WHERE email = ? AND motdepasse = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $motdepasse);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $employe = $result->fetch_assoc();
        $_SESSION["id_employe"] = $employe["id_employe"];
        header("Location: dashboard_emp.php");
        exit();
    } else {
        $message = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion - Employé</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
    body {
      font-family: 'Tajawal', sans-serif;
      background-color: #f1f1f1;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .input {
      border-radius: 5px;
      border: 1px solid #ccc;
      padding: 2px;
      width: 90%;
      box-sizing: border-box;
    }
    .form-control {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      width: 100%;
    }
     {
      width: 100%;
    } 
    .login-box {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 600px;
      
    }
    .logo {
      text-align: left;
      margin-bottom: 2rem;
      font-size: 1.5rem;
      font-weight: bold;
      color:black;
     
    }
    .form-label {
      font-weight: 600;
    }
    .bottom-link {
      margin-top: 1rem;
      text-align: center;
    }
    .bottom-link a {
      text-decoration: none;
      color: #00796b;
    }
  </style>
</head>
<body>

<div class="login-box">
  <div class="logo"> </div>
  <h4 class="mb-3"><center>Connexion Employé</center></h4>

  <?php if ($message): ?>
    <div class="alert alert-danger"><?= $message ?></div>
  <?php endif; ?>

  <form  method="post">
    <div class="mb-3">
      <label for="email" class="form-label">Adresse e-mail</label>
      <input type="email" class="form-control" name="email" required>
    </div>
    <div class="mb-3">
      <label for="motdepasse" class="form-label">Mot de passe</label>
      <input type="password" class="form-control" name="motdepasse" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Connexion</button>
  </form>

  <div class="bottom-link">
    <p>Pas encore de compte ? <a href="register_employe.php">Créer un compte</a></p>
  </div>
</div>

</body>
</html>
