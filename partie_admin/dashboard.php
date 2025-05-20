<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: ../partie_admin/login.php");
    exit;
}
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
    <style>
        body {{
            font-family: Arial, sans-serif;
            background-color: #eef2f7;
            padding: 50px;
        }}
        .container {{
            max-width: 700px;
            margin: auto;
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }}
        h2 {{ text-align: center; }}
        ul {{
            list-style: none;
            padding: 0;
        }}
        li {{
            margin: 10px 0;
            background-color: #007bff;
            padding: 10px;
            color: white;
            border-radius: 5px;
            text-align: center;
        }}
        li a {{
            color: white;
            text-decoration: none;
            display: block;
        }}
    </style>
</head>
<body>
    <div class="container">
        <h2>Bienvenue dans votre tableau de bord</h2>
        <ul>
            <?php if ($role === 'admin'): ?>
                <li><a href='add_admin_form.php'>Ajouter un administrateur</a></li>
                <li><a href='add_employe_form.php'>Ajouter un employé</a></li>
                <li><a href='add_service_form.php'>Ajouter un service</a></li>
                <li><a href='add_categorie_form.php'>Ajouter une catégorie</a></li>
                <li><a href='add_client_form.php'>Ajouter un client</a></li>
            <?php elseif ($role === 'client'): ?>
                <li><a href='voir_demandes.php'>Voir mes demandes</a></li>
                <li><a href='nouvelle_demande.php'>Nouvelle demande</a></li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
