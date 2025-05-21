
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 350px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
  

    </style>
</head>
<body>
<div class="form-container">
    <h2>Ajouter un nouveau service</h2>
    
    <form action="insert_service.php" method="POST">
        
            <input type="text" name="nom_service" placeholder="Nom du service" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="number" name="id_categorie" placeholder="ID de la catégorie" required>
            <input type="number" step="0.01" name="prix" placeholder="Prix" required>
            <input type="number" name="duree_estimee" placeholder="Durée estimée (minutes)" required>
            <input type="number" name="id_admin" placeholder="ID de l'administrateur" required>
        
        <input type="submit" value="Ajouter">
    </form>
</div>
</body>
</html>
