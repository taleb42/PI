<?php
include(__DIR__ . '/../db_connection.php');
session_start();

$succes = false;
$erreur = "";
$message = "";

try {
    $nom = $_POST['nom'];
$description = $_POST['description'];
$stmt = $conn->prepare("INSERT INTO categorie (nom, description) VALUES (?, ?)");
$stmt->bind_param("ss", $nom, $description);
$stmt->execute();
    $succes = true;
    $message = "La catégorie a été ajoutée avec succès.";
} catch (Exception $e) {
    $erreur = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
            background-color: { $succes ? '#d4edda' : '#f8d7da' };
            color: { $succes ? '#155724' : '#721c24' };
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .icon {
            font-size: 60px;
        }
    </style>
</head>
<body>
<div class="box">
    <div class="icon"><?php echo $succes ? '✅' : '❌'; ?></div>
    <h2><?php echo $succes ? "Succès" : "Erreur"; ?></h2>
    <p><?php echo $succes ? $message : $erreur; ?></p>
</div>
</body>
</html>
