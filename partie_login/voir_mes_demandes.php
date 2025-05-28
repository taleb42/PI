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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color:rgb(43, 41, 41);
            margin: 0;
            padding: 0;
            color: #2c3e50;
        }
        
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            background:rgb(36, 35, 35);
            padding: 30px;
           
        }
        
        h2 {
            color:rgb(216, 216, 224);
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }
        
        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(to right,rgb(136, 180, 210),rgb(83, 158, 208));
            border-radius: 3px;
        }
        
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        
        table th, table td {
            padding: 15px 20px;
            text-align: left;
            border: 1px solid rgb(145, 137, 137);
        }
        table th {
            background: linear-gradient(to right,rgb(7, 39, 61),rgb(5, 72, 116));
            color: white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
        }
        
        table tr:last-child td {
            border-bottom:border: 1px solid rgb(145, 137, 137);;
        }
        
        table tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }
        
        table td {
            color:rgb(32, 42, 52);
            font-size: 15px;
        }
        
        /* Style pour les différents statuts */
        td:last-child {
            font-weight: 500;
        }
        
        td[data-status="En attente"] {
            color: #f39c12;
        }
        
        td[data-status="Approuvée"] {
            color: #27ae60;
        }
        
        td[data-status="Refusée"] {
            color: #e74c3c;
        }
        
        /* Bouton de retour */
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background: linear-gradient(to right, #3498db, #2980b9);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
        
        .back-button i {
            margin-right: 8px;
        }
    </style>
</head>
<body>    <div class="container">
        <a href="indexx.php" class="back-button">
            <i class="fas fa-arrow-left"></i> Retour à l'accueil
        </a>
        <h2>Vos Demandes</h2>
        <table>
            <tr>
                <th>Description</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($row['date_demande'])); ?></td>
                    <td data-status="<?php echo htmlspecialchars($row['statut']); ?>">
                        <?php echo htmlspecialchars($row['statut']); ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
