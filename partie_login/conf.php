<?php
session_start();
include(__DIR__ . '/../db_connection.php');

if (!isset($_SESSION['id'])) {
    header("Location: login_client.php");
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
<head>    <meta charset="UTF-8">
    <title>Mes Demandes</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            width: 90%;
            max-width: 600px;
            margin: 20px;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .container:hover {
            transform: translateY(-5px);
        }
        h2 {
            color: #2c3e50;
            text-align: center;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        .message {
            padding: 40px;
            background-color: #ffffff;
            color: #2c3e50;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #e1e8f0;
        }
        .message h3 {
            color: #2c3e50;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .message p {
            color: #5d6778;
            line-height: 1.6;
            margin: 0.5rem 0;
        }
        .message a {
            display: inline-block;
            margin-top: 1.5rem;
            padding: 12px 28px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(52, 152, 219, 0.2);
        }
        .message a:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(52, 152, 219, 0.3);
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
        }
        table th, table td {
            padding: 16px;
            border-bottom: 1px solid #e1e8f0;
            text-align: left;
        }
        table th {
            background-color: #3498db;
            color: white;
            font-weight: 500;
            border-radius: 8px 8px 0 0;
        }
    </style>
</head>
<body>    <div class="container">
        <div class="message">
            <i class="fas fa-check-circle" style="font-size: 4rem; color: #2ecc71; margin-bottom: 1rem; display: block;"></i>
            <h3 style="margin-bottom: 15px;"><strong>Demande Envoyée</strong></h3>
            <p>Votre demande a été envoyée avec succès.</p>
            <p style="margin-top: 10px;">Nous traiterons votre demande dans les plus brefs délais.</p>
            <a href="indexx.php">Retour à l'accueil</a>
        </div>
    </div>
</body>
</html>
