<?php
session_start();
include_once '../include/db_connection.php';
include_once '../include/dashboard_stats.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    exit('Accès non autorisé');
}

header('Content-Type: application/json');
echo json_encode(getDashboardStats($conn));
?>
