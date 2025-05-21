<?php
session_start();
include '../db_connection.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST['description'];
    $id_service = $_POST['id_service'];
    $id_client = $_SESSION['id'];

    $stmt = $conn->prepare("INSERT INTO demande (description, id_service, id_client, date_demande, statut)
                            VALUES (?, ?, ?, NOW(), 'en attente')");
    if ($stmt) {
        $stmt->bind_param("sii", $description, $id_service, $id_client);
        if ($stmt->execute()) {
            $message = "<div class='alert success'>✅ Demande envoyée avec succès.</div>";
        } else {
            $message = "<div class='alert error'>❌ Erreur lors de l'envoi : " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='alert error'>❌ Erreur de préparation : " . $conn->error . "</div>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle Demande</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-box {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            width: 400px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        textarea, select, input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
        }

        .alert {
            padding: 12px;
            margin: 15px 0;
            border-radius: 6px;
            font-weight: bold;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
<div class="form-box">
    <h2>Nouvelle Demande</h2>

    <?php if (!empty($message)) echo $message; ?>

    <form method="post">
        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Service</label>
        <select name="id_service" required>
            <option value="">-- Choisir un service --</option>
            <option value="1">Service 1</option>
            <option value="2">Service 2</option>
            <!-- يمكنك لاحقًا جلبها من قاعدة البيانات -->
        </select>

        <input type="submit" value="Envoyer la demande">
    </form>
</div>
</body>
</html>