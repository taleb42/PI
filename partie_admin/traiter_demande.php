<?php
session_start();
include_once '../include/db_config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../partie_login/login_admin.php');
    exit;
}

if (isset($_POST['id_demande'], $_POST['action'])) {
    $id = intval($_POST['id_demande']);
    $action = $_POST['action'];
    $statut = '';
    if ($action == 'accepter') {
        $statut = 'en_cours';
    } elseif ($action == 'refuser') {
        $statut = 'annulee';
    }
    if ($statut) {
        $sql = "UPDATE Demande SET statut = $statut WHERE id_demande = $id";
        $conn->query($sql);
    }
}
header('Location: dashbord.php');
exit;

