<?php
include(__DIR__ . '/../db_connection.php');
if (!isset($_GET['id_service'])) {
    die("Aucun service sélectionné.");
}

$id_service = intval($_GET['id_service']);
$sql = "SELECT * FROM service WHERE id_service = $id_service";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Service introuvable.");
}

$service = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du service</title>
    <link rel="stylesheet" href="../style/style.css">

    <style>
        body {
            font-family: 'Tajawal',Arial, sans-serif;
            padding: 40px 20px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
          box-shadow: 0 150px 1000px rgba(0,0,0,0.18);
        }
        h2 {
            color: black;
            font-size: 28px;
            margin-bottom: 25px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            text-align: center;
        }
        .info {
            margin-bottom: 30px;
            background: whitesmoke;
            padding: 20px;
            border-radius: 10px;
        }
        .info p {
            margin: 10px 0;
            color: #2c3e50;
            font-size: 16px;
        }
        label {
            font-weight: 600;
            color: #34495e;
            display: block;
            margin-bottom: 8px;
        }
        textarea, input[type="text"] {
            width: 98%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 15px;
            transition: border-color 0.3s ease;
            border-color: grey;
        }
        textarea:focus, input[type="text"]:focus {
            outline: none;
            border-color:black;
        }
        .file-input-container {
            margin-bottom: 20px;
        }
        .file-input-label {
            display: inline-block;
            padding: 10px 20px;
            background: #e9ecef;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .file-input-label:hover {
            background: #dee2e6;
        }
        input[type="file"] {
            display: none;
        }
        .optional-text {
            color: #6c757d;
            font-size: 14px;
            margin-left: 8px;
        }
        button {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 13px 125px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        button:hover {
           transform: translateX(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            background: rgb(28, 99, 54);
        }
        .required {
            color: #dc3545;
            margin-left: 4px;
        }
        .back-link {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            color:rgb(248, 251, 255);
            display: flex;
            align-items: center;
            padding: 10px 15px;
            background:  linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .back-link:hover {
            transform: translateX(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            background: rgb(28, 99, 54);
        }
        .back-link:before {
            content: '←';
            margin-right: 8px;
            font-size: 20px;
        }
        body {
            position: relative;
        }
        .logok {
       
            margin-bottom: 19px;
            
            width: 110px;
        }   
    </style>
</head>
<body>
    <a href="indexx.php" class="back-link">Retour à l'accueil</a>
    
    <div class="container">
        <img src="../partie_login/images/logok.jpg" alt="Logo" style="width: 180px; height: auto; margin-bottom: 8px; display: block; margin-left: 0px; margin-right: 0;">
     <br>
    
        <h2>Service <?= htmlspecialchars($service['nom_service']) ?></h2>
    

        <div class="info">
            <p><strong>Description :</strong> <?= htmlspecialchars($service['description']) ?></p>
            <p><strong>Prix :</strong> <?= number_format($service['prix'], 0, ',', ' ') ?> MRU</p>
            <p><strong>Durée estimée :</strong> <?= htmlspecialchars($service['duree_estimee']) ?></p>
        </div>

        <form action="soumettre_demande.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_service" value="<?= $service['id_service'] ?>">

            <label for="details">Décrivez votre besoin: <span class="required">*</span></label>
            <textarea name="description" id="details" required 
                placeholder="Décrivez en détail votre besoin pour que nous puissions mieux vous aider..." 
                rows="5"></textarea>

            <label for="adresse">Votre adresse complète: <span class="required">*</span></label>
            <input type="text" name="adresse" id="adresse" required 
                placeholder="Rue, quartier, ville...">
<label for="num">Votre Numero Telephone: <span class="required">*</span></label>
            <input type="text" name="num" id="num" required 
                placeholder="votre numero">
            <div class="file-input-container">
                <label>
                    Photo du problème:
                    <span class="optional-text">(optionnel)</span>
                </label>
                <label for="photo" class="file-input-label">
                    Choisir une photo
                </label>
                <input type="file" name="photo" id="photo" accept="image/*">
            </div>
<center>
            <button type="submit">Soumettre la demande</button>
    </center>
        </form>
    </div>

</body>
</html>