<?php
session_start();
include(__DIR__ . '/../db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_client = $_SESSION['id'];
    $id_service = $_POST['id_service'];
    $description = $_POST['description'];
    $adresse = $_POST['adresse'];
    $date_demande = date('Y-m-d');
    
    // Gestion de l'upload de photo
    $photo_path = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/demandes/';
        
        // Créer le dossier s'il n'existe pas
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Générer un nom de fichier unique
        $file_extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_path = $upload_dir . $new_filename;
        
        // Vérifier le type de fichier
        $allowed_types = ['jpg', 'jpeg', 'png'];
        if (in_array($file_extension, $allowed_types) && move_uploaded_file($_FILES['photo']['tmp_name'], $target_path)) {
            $photo_path = $target_path;
        }
    }

    // Modification de la requête SQL pour inclure l'adresse et la photo
    $sql = "INSERT INTO demande (description, statut, id_service, id_client, date_demande, adresse, image)
            VALUES (?, 'en_attente', ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siisss", $description, $id_service, $id_client, $date_demande, $adresse, $photo_path);

    if ($stmt->execute()) {
        header("Location: conf.php");
        exit();
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
