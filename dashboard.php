<?php
require_once 'db_connection.php';
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: Client.php");
    exit();
}

// Fetch user data from database
$email = $_SESSION['email'];
$sql = "SELECT * FROM client WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenue sur votre tableau de bord</h1>
        <?php
        // Check if 'name' key exists in the user array and handle null values
        $nom = isset($user['nom']) ? htmlspecialchars($user['nom']) : 'Utilisateur inconnu';
        ?>
        <p>Bienvenue, <strong><?php echo $nom; ?></strong> ! Nous sommes ravis de vous revoir.</p>
        <!-- Ajouter ici les éléments du tableau de bord -->
        <a href="client.php" class="btn">Déconnexion</a>
    </div>
</body>
</html>