<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un service</title>
    <style>
        :root {
            --primary-color: #1a3a63;
            --secondary-color: #2c5282;
            --accent-color: #3182ce;
            --background-color: #f8fafc;
            --text-color: #2d3748;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--background-color) 0%, #e2e8f0 100%);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: var(--text-color);
        }

        .form-container {
            background-color: #ffffff;
            padding: 25px 35px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 
                        0 10px 15px rgba(0, 0, 0, 0.1);
            width: 450px;
            max-width: 95%;
            max-height: 95vh;
            overflow-y: auto;
        }

        .form-container h2 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 22px;
            font-weight: 600;
            position: relative;
            padding-bottom: 8px;
        }

        .form-container h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: var(--accent-color);
            border-radius: 2px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px 12px;
            margin: 4px 0;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
            background-color: #ffffff;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }

        textarea {
            min-height: 80px;
            resize: vertical;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, var(--secondary-color), var(--primary-color));
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(26, 58, 99, 0.2);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: var(--primary-color);
            font-weight: 500;
            font-size: 14px;
        }

        input::placeholder {
            color: #a0aec0;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Ajouter un nouveau service</h2>
    <form action="insert_service.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nom_service">Nom du service</label>
            <input type="text" id="nom_service" name="nom_service" placeholder="Entrez le nom du service" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="Entrez la description du service" required></textarea>
        </div>
        <div class="form-group">
            <label for="id_categorie">Catégorie</label>
            <select id="id_categorie" name="id_categorie" required>
                <?php
                include_once '../include/db_config.php';
                $catres = $conn->query("SELECT id_categorie, nom_categorie FROM categorie");
                while ($cat = $catres->fetch_assoc()): ?>
                    <option value="<?= $cat['id_categorie'] ?>"><?= htmlspecialchars($cat['nom_categorie']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="prix">Prix</label>
            <input type="number" id="prix" name="prix" step="0.01" placeholder="Entrez le prix" required>
        </div>
        <div class="form-group">
            <label for="duree_estimee">Durée estimée</label>
            <input type="number" id="duree_estimee" name="duree_estimee" placeholder="Durée en minutes" required>
        </div>
        <div class="form-group">
            <label for="id_admin">Administrateur</label>
            <input type="number" id="id_admin" name="id_admin" placeholder="ID de l'administrateur" required>
        </div>
        <div class="form-group">
            <label for="photo">Photo du service</label>
            <input type="file" id="photo" name="photo" accept="image/*" required>
        </div>
        <input type="submit" value="Ajouter le service">
    </form>
</div>
</body>
</html>
