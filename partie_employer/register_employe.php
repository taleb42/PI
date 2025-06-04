
<?php
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "khadamati");
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $motdepasse = $_POST["motdepasse"];
    $specialite = $_POST["specialite"];

    // Vérifier si l'email existe déjà
    $check = $conn->prepare("SELECT * FROM employe WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $res = $check->get_result();
    if ($res->num_rows > 0) {
        $message = "Cet email est déjà utilisé.";
    } else {
        $sql = "INSERT INTO employe (nom, email, motdepasse, specialite) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nom, $email, $motdepasse, $specialite);  // ✅ السطر الذي كان ناقصًا
        if ($stmt->execute()) {
            header("Location: login_employe.php");
            exit();
        } else {
            $message = "Erreur lors de l'inscription.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription Employé</title>
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
    .register-box {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 600px;
   
    }
    
    .form-label {
      font-weight: 600;
    }
    .h4{
      text-align: center;
    }
  </style>
</head>
<body>

<div class="register-box">
  <div class="logo"></div>
  <h4 class="mb-3"> <center>Créer un compte Employé</center></h4>

  <?php if ($message): ?>
    <div class="alert alert-danger"><?= $message ?></div>
  <?php endif; ?>

  <form  method="post">
    <div class="mb-3">
      <label for="nom" class="form-label">Nom complet</label>
      <input type="text" class="form-control" name="nom" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Adresse e-mail</label>
      <input type="email" class="form-control" name="email" required>
    </div>
    <div class="mb-3">
      <label for="motdepasse" class="form-label">Mot de passe</label>
      <input type="password" class="form-control" name="motdepasse" required>
    </div>
    <div class="mb-3">
      <label for="id_categorie" class="form-label">Spécialité</label>
      <select class="form-select" name="specialite" required>
        <option value="">-- Choisissez votre spécialité --</option>
        <option value="1">Plomberie</option>
        <option value="2">Électricité</option>
        <option value="3">Mécanique</option>
        <option value="4">Livraison</option>
        <!-- Ajoutez ici d'autres catégories -->
      </select>
    </div>
    <button type="submit" class="btn btn-success w-100">S'inscrire</button>
  </form>
</div>

</body>
</html>
