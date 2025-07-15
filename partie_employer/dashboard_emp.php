<?php
session_start();
require_once("../db_connection.php");

// التحقق من دخول الموظف
if (!isset($_SESSION['id_employe']) || !isset($_SESSION['nom'])) {
    header("Location: login_employe.php");
    exit();
}

$id_employe = $_SESSION['id_employe'];
$nom_employe = $_SESSION['nom'];

// استخراج الخدمة والفئة الخاصة بالموظف
$sqlEmp = "SELECT id_service, id_categorie FROM employe WHERE id_employe = ?";
$stmtEmp = $conn->prepare($sqlEmp);
$stmtEmp->bind_param("i", $id_employe);
$stmtEmp->execute();
$resultEmp = $stmtEmp->get_result();
$employe = $resultEmp->fetch_assoc();

$id_service = $employe['id_service'];
$id_categorie = $employe['id_categorie'];

// استخراج الطلبات المرتبطة بالخدمة والفئة

$sql = "SELECT d.id_demande, d.description, d.date_demande, d.adresse, c.nom AS nom_client
        FROM demande d
        JOIN client c ON d.id_client = c.id_client
        WHERE d.statut = 'en_attente' 
        AND d.id_service = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_service);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Employé</title>
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            margin: 0;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 220px;
            background-color: #343a40;
            color: white;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 12px;
            text-decoration: none;
            margin-bottom: 5px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main {
            margin-left: 230px;
            padding: 20px;
        }
        .welcome {
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 12px;
            border: 1px solid #dee2e6;
        }
        th {
            background-color: green;
            color: white;
            border-raduis: 4px;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .acc { background-color: #28a745; }
        .ref { background-color: #dc3545; }
         .ter { background-color: green; 
            border-raduis:4px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <img src="../partie_login/images/logok2.jpg" alt="Logo" style="width: 190px; height: auto; margin-bottom: 10px; display: block; margin-left: 10px; margin-right: 0;">
        <a href="#">Tableau de bord</a>
        <a href="#">Commandes</a>
        <a href="#">Déconnexion</a>
    </div>

    <div class="main">
        <div class="welcome">Bienvenue, <?php echo htmlspecialchars($nom_employe); ?> !</div>

        <h3>Demandes en attente</h3>
        <table>
            <thead>
                
                <tr>
                    <th>Service</th>
                    <th>Client</th>
                    <th>Adresse</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($id_service); ?></td>
                    <td><?php echo htmlspecialchars($row['nom_client']); ?></td>
                    <td><?php echo htmlspecialchars($row['adresse']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['date_demande']); ?></td>
                       <td>
  <!-- زر Accepter -->
  <form  method="POST" action="acc.php" style="display:inline;">
      <input  type="hidden" name="id_demande" value="<?= $row['id_demande'] ?>">
      <button type="submit" class="acc">Accepter</button>
  </form>

  <!-- زر Refuser -->
  <form method="POST" action="reff.php" style="display:inline;">
      <input type="hidden" name="id_demande" value="<?= $row['id_demande'] ?>">
      <button type="submit" class="ref">Refuser</button>
  </form>

  <!-- زر Terminer -->
  <form method="POST" action="terminer.php" style="display:inline;">
      <input type="hidden" name="id_demande" value="<?= $row['id_demande'] ?>">
      <button type="submit" class="ter">Terminer</button>
  </form>
</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>