<?php
session_start();
include(__DIR__ . '/../db_connection.php');

if (!isset($_SESSION['id'])) {
    echo "<div style='margin: 50px auto; padding: 20px; max-width: 400px; background-color: #f8d7da; color: #721c24; border-radius: 6px; text-align: center; font-family: Arial;'>
            Veuillez vous connecter pour voir vos demandes.
            <br><a href='../login.php' style='color: #721c24; font-weight: bold;'>Connexion</a>
          </div>";
    exit;
}

$id_client = $_SESSION['id'];
$sql = "SELECT * FROM demande WHERE id_client = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_client);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Demandes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        h2 {
            color: #007bff;
            text-align: center;
        }
        .message {
            padding: 12px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">Votre demande a été envoyée avec succès.</div>
        <h2>Mes Demandes</h2>
        <table>
            <tr>
                <th>Description</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['date_demande']); ?></td>
                    <td><?php echo htmlspecialchars($row['statut']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
