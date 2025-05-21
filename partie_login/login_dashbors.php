<?php
session_start();

// التحقق من تسجيل الجلسة
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .section-title {
            font-size: 18px;
            margin-top: 30px;
            color: #007BFF;
            border-bottom: 2px solid #007BFF;
            padding-bottom: 5px;
        }

        ul {
            list-style-type: none;
            padding-left: 0;
        }

        li {
            margin: 12px 0;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Bienvenue dans votre tableau de bord</h2>

    <?php if ($role === 'admin'): ?>
        <div class="section-title">Espace Administrateur</div>
        <ul>
            <li><a href="../partie_admin/add_admin_form.php">Ajouter un administrateur</a></li>
            <li><a href="../partie_employer/add_employe_form.php">Ajouter un employé</a></li>
            <li><a href="../partie_service/add_service_form.php">Ajouter un service</a></li>
            <li><a href="../partie_categories/add_categorie_form.php">Ajouter une catégorie</a></li>
            <li><a href="../partie_client/add_client_form.php">Ajouter un client</a></li>
        </ul>
    <?php elseif ($role === 'client'): ?>
        <div class="section-title">Espace Client</div>
        <ul>
            
            <li><a href="../partie_client/nouvelle_demande.php">Nouvelle demande</a></li>
        </ul>
    <?php endif; ?>
</div>

</body>
</html>