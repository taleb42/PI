<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un client</title>
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
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
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
        input[type="password"]:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }

        input[type="submit"] {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, var(--secondary-color), var(--primary-color));
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 500;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        input[type="submit"]:hover {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(26, 58, 99, 0.2);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
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
    <h2>Ajouter un nouveau client</h2>
    <form action="insert_client.php" method="POST">
        <div class="form-group">
            <label for="nom">Nom complet</label>
            <input type="text" id="nom" name="nom" placeholder="Entrez le nom complet" required>
        </div>
        <div class="form-group">
            <label for="email">Adresse e-mail</label>
            <input type="email" id="email" name="email" placeholder="Entrez l'adresse e-mail" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Entrez le mot de passe" required>
        </div>
        <input type="submit" value="Ajouter le client">
    </form>
</div>
</body>
</html>
