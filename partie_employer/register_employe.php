<?php
$message = "";
$conn = new mysqli("localhost", "root", "", "khadamati");
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $motdepasse = $_POST['motdepasse'];
    $specialite = $_POST['specialite'];
    $id_service = $_POST['id_service'];

    $stmt = $conn->prepare("SELECT id_categorie FROM service WHERE id_service = ?");
    $stmt->bind_param("i", $id_service);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $id_categorie = $row['id_categorie'];
        $insert = $conn->prepare("INSERT INTO employe (nom, email, motdepasse, specialite, id_service, id_categorie, statut) VALUES (?, ?, ?, ?, ?, ?, 'actif')");
        $insert->bind_param("ssssii", $nom, $email, $motdepasse, $specialite, $id_service, $id_categorie);
        $insert->execute();
        $message = "Inscription réussie.";
    } else {
        $message = "Service invalide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription Employé</title>
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Tajawal', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    form {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 610px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    input, select {
      width: 95%;
      padding: 14px;
      margin-top: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    button {
      background-color: #2e7d32;
      color: white;
      border: none;
      padding: 13px;
      width: 98%;
      border-radius: 4px;
     
      cursor: pointer;
    }
    .msg {
      text-align: center;
      color: green;
    }
  </style>
</head>
<body>

<form method="POST">
  <img src="../partie_login/images/logok.jpg" alt="Logo" style="width: 180px; height: auto; margin-bottom: 10px; display: block; margin-left: 10px; margin-right: 0;">
  <h2>Créer un compte Employé</h2>
  <?php if (!empty($message)) echo "<p class='msg'>$message</p>"; ?>
  <input type="text" name="nom" placeholder="Nom complet" required>
  <input type="email" name="email" placeholder="Adresse e-mail" required>
  <input type="password" name="motdepasse" placeholder="Mot de passe" required>
  <input type="text" name="specialite" placeholder="Spécialité" required>
  <select name="id_service" required>
    <option value="">-- Choisir un service --</option>
    <?php
    $result = $conn->query("SELECT id_service, nom_service FROM service");
    while ($s = $result->fetch_assoc()) {
        echo "<option value='{$s['id_service']}'>{$s['nom_service']}</option>";
    }
    ?>
  </select>
  <button type="submit">S'inscrire</button>
</form>

</body>
</html>