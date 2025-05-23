<!-- Liste des services disponibles -->
 <?php
include(__DIR__ . '/../db_connection.php');

// Requête pour récupérer toutes les services
$sql = "SELECT * FROM service";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Services</title>
    <link rel="stylesheet" href="../style/style.css"> <!-- Assure-toi que ce fichier existe -->

    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .service-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card h3 {
            margin-top: 0;
        }

        .card p {
            margin: 8px 0;
        }

        .prix {
            font-weight: bold;
            color: green;
        }

        .duree {
            color: #666;
        }

        .btn {
            margin-top: 10px;
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>Nos Services Disponibles</h2>

<div class="service-container">
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="card">
            <h3><?= htmlspecialchars($row['nom_service']) ?></h3>
            <p><?= htmlspecialchars($row['description']) ?></p>
            <p class="prix"><?= number_format($row['prix'], 0, ',', ' ') ?> MRU</p>
            <p class="duree">Durée estimée : <?= htmlspecialchars($row['duree_estimee']) ?></p>
            <a class="btn" href="service_details.php?id_service=<?= $row['id_service'] ?>">Demander ce service</a>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>