<?php
require_once("../db_connection.php");
session_start();

if (isset($_POST['id_demande'])) {
    $id = $_POST['id_demande'];
    $stmt = $conn->prepare("UPDATE demande SET statut = 'en_cours' WHERE id_demande = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: dashboard_emp.php?accept=1");
    exit();
}
?>