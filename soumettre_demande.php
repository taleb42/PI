<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_client = $_SESSION['id'];
    $id_service = $_POST['id_service'];
    $description = $_POST['description'];
    $date_demande = date('Y-m-d');

    $sql = "INSERT INTO demande (description, statut, id_service, id_client, date_demande)
            VALUES (?, 'en_attente', ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siis", $description, $id_service, $id_client, $date_demande);

    if ($stmt->execute()) {
        header("Location: voir_mes_demandes.php");
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
