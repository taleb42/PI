<?php
$conn = new mysqli("localhost", "root", "", "khadamati");
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}
?>