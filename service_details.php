<?php
include 'db_connection.php';
if (!isset($_GET['id_service'])) {
    die("Aucun service sélectionné.");
}

$id_service = intval($_GET['id_service']);
$sql = "SELECT * FROM service WHERE id_service = $id_service";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Service introuvable.");
}

$service = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du service</title>
    <link rel="stylesheet" href="../style/style.css">
    <style>
        body {
            font-family: Arial;
            padding: 30px;
            background: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 0 10px #ccc;
        }
        h2 {
            color: #333;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        label {
            font-weight: bold;
        }
        textarea, input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2><?= htmlspecialchars($service['nom_service']) ?></h2>

    <div class="info">
        <p><strong>Description :</strong> <?= htmlspecialchars($service['description']) ?></p>
        <p><strong>Prix :</strong> <?= number_format($service['prix'], 0, ',', ' ') ?> MRU</p>
        <p><strong>Durée estimée :</strong> <?= htmlspecialchars($service['duree_estimee']) ?></p>
    </div>

    <form action="soumettre_demande.php" method="post">
        <input type="hidden" name="id_service" value="<?= $service['id_service'] ?>">

        <label for="details">Décrivez votre besoin :</label>
        <textarea name="description" id="details" required placeholder="Ex: fuite dans la salle de bain..."></textarea>

        <label for="duree">Nombre d'heures souhaité :</label>
        <input type="number" name="duree" id="duree" min="1" max="12" required>

        <button type="submit">Soumettre la demande</button>
    </form>
</div>

</body>
</html>