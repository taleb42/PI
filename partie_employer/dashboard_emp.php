<!-- Tableau de bord employé -->
 
<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "khadamati";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Assumons que l'employé est connecté et son ID est en session
$id_employe = $_SESSION['id_employe'] ?? 1; // valeur par défaut pour test

// Obtenir la catégorie de l'employé
// Obtenir la spécialité de l'employé
$sql_cat = "SELECT specialite FROM employe WHERE id_employe = ?";
$stmt = $conn->prepare($sql_cat);
$stmt->bind_param("i", $id_employe);
$stmt->execute();
$result_cat = $stmt->get_result();
$row_cat = $result_cat->fetch_assoc();
$specialite = $row_cat['specialite'] ?? null;

// Requête des demandes liées à la spécialité (texte)
$sql = "SELECT d.id_demande, s.nom_service, d.date_demande, d.statut, c.nom
        FROM demande d
        JOIN service s ON d.id_service = s.id_service
        JOIN client c ON d.id_client = c.id_client
        WHERE s.nom_service = ? AND d.statut = 'en attente'";

// Obtenir la spécialité de l'employé
$sql_cat = "SELECT specialite FROM employe WHERE id_employe = ?";
$stmt = $conn->prepare($sql_cat);
$stmt->bind_param("i", $id_employe);
$stmt->execute();
$result_cat = $stmt->get_result();
$row_cat = $result_cat->fetch_assoc();
$specialite = $row_cat['specialite'] ?? null;

$stmt2 = $conn->prepare($sql);
if (!$stmt2) {
    die("Erreur dans la requête: " . $conn->error);
}
$stmt2->bind_param("s", $specialite);
$stmt2->execute();
$result = $stmt2->get_result();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tableau de Bord - Employé</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { font-family: 'Tajawal', sans-serif; background-color: #f9f9f9; }
    .sidebar {
      width: 220px; background-color: #004d40; min-height: 100vh;
      color: white; position: fixed; top: 0; left: 0; padding: 2rem 1rem;
    }
    .sidebar h4 { color: #fff; margin-bottom: 2rem; text-align: center; }
    .sidebar a {
      display: block; color: white; padding: 10px; margin-bottom: 10px;
      text-decoration: none; border-radius: 5px;
    }
    .sidebar a:hover { background-color: #00695c; }
    .content { margin-left: 240px; padding: 2rem; }
    .header {
      background-color: white; padding: 1rem 2rem; border-bottom: 1px solid #ddd;
      display: flex; justify-content: space-between; align-items: center;
    }
    .stats {
      display: flex; gap: 1rem; margin-top: 2rem;
    }
    .stat-card {
      background-color: white; padding: 1rem; border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1); flex: 1; text-align: center;
    }
    table {
      background-color: white; border-radius: 8px; overflow: hidden;
    }
    th { background-color: #e0f2f1; }
  </style>
</head>
<body>

<div class="sidebar">
  <h4>🛠 Khadamati</h4>
  <a href="#">🏠 Tableau de bord</a>
  <a href="#">📋 Mes demandes</a>
  <a href="#">👤 Profil</a>
  <a href="#">⚙️ Paramètres</a>
  <a href="#">🔓 Déconnexion</a>
</div>

<div class="content">
  <div class="header">
    <h3>Bienvenue, Employé</h3>
    <button class="btn btn-outline-danger">Déconnexion</button>
  </div>

  <div class="stats">
    <div class="stat-card"><h4>3</h4><p>En cours</p></div>
    <div class="stat-card"><h4>7</h4><p>Terminées</p></div>
    <div class="stat-card"><h4>2</h4><p>Aujourd'hui</p></div>
  </div>

  <div class="mt-5">
    <h4>Demandes dans votre domaine</h4>
    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>Service</th>
          <th>Client</th>
          <th>Date</th>
          <th>État</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['nom_service']) ?></td>
          <td><?= htmlspecialchars($row['nom_client']) ?></td>
          <td><?= htmlspecialchars($row['date_demande']) ?></td>
          <td><?= htmlspecialchars($row['etat']) ?></td>
          <td><a href="#" class="btn btn-sm btn-primary">Voir</a></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
