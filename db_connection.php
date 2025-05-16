<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Informations de connexion à la base de données
$servername = "localhost"; // Nom du serveur (généralement localhost)
$username = "root";        // Nom d'utilisateur MySQL
$password = "";            // Mot de passe MySQL (à modifier si nécessaire)
$dbname = "khadamati";     // Nom de la base de données
$port = 3306;              // Port MySQL par défaut

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Vérifier la connexion
if ($conn->connect_error) {
    // Afficher un message d'erreur détaillé
    die("Échec de la connexion : " . $conn->connect_error . " (Code erreur : " . $conn->connect_errno . ")");
}

// Définir l'encodage pour éviter les problèmes de caractères
$conn->set_charset("utf8mb4");

// Message de confirmation (pour tester)
// echo "Connexion à la base de données réussie !";

?>