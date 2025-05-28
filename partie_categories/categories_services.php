<?php
session_start();
include_once '../include/db_config.php';

// Récupérer tous les services groupés par catégorie
$sql = "SELECT DISTINCT s.categorie as categorie_nom,
               s.id_service, s.nom_service, s.description as service_description, 
               s.prix, s.duree_estimee,
               a.nom as admin_nom
        FROM Service s
        LEFT JOIN Administrateur a ON s.id_admin = a.id_admin
        ORDER BY s.categorie, s.nom_service";

$result = $conn->query($sql);
$categories = [];

// Organiser les données par catégorie
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categorie_nom = $row['categorie_nom'];
        
        if (!isset($categories[$categorie_nom])) {
            $categories[$categorie_nom] = [
                'nom' => $row['categorie_nom'],
                'services' => []
            ];
        }
        
        if ($row['id_service']) {
            $categories[$categorie_nom]['services'][] = [
                'nom' => $row['nom_service'],
                'description' => $row['service_description'],
                'prix' => $row['prix'],
                'duree' => $row['duree_estimee'],
                'admin' => $row['admin_nom']
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catégories et Services - Khadamati</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
            color: #2C3E50;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 20px;
        }        .page-header {
            margin-bottom: 30px;
            padding: 20px;
            border-bottom: 2px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            color: #2C3E50;
            font-size: 24px;
            font-weight: 600;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background-color: #2C3E50;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #1ABC9C;
        }

        .back-button i {
            margin-right: 8px;
        }

        .categories-section {
            margin-bottom: 40px;
        }

        .category-header {
            background: #2C3E50;
            color: white;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0;
            margin-top: 30px;
        }

        .category-name {
            font-size: 20px;
            font-weight: 500;
        }

        .services-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .services-table th {
            background-color: #f8f9fa;
            color: #2C3E50;
            font-weight: 600;
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .services-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: top;
        }

        .services-table tr:hover {
            background-color: #f8f9fa;
        }

        .service-name {
            color: #2C3E50;
            font-weight: 500;
            min-width: 200px;
        }

        .service-description {
            color: #666;
            max-width: 400px;
        }

        .service-price {
            font-weight: 600;
            color: #27AE60;
            white-space: nowrap;
        }

        .service-admin {
            color: #7f8c8d;
            font-size: 14px;
        }

        .service-duration {
            color: #666;
            white-space: nowrap;
        }

        .no-services {
            text-align: center;
            padding: 30px;
            color: #7f8c8d;
            font-style: italic;
            background: #f8f9fa;
            border-radius: 0 0 8px 8px;
        }

        @media (max-width: 1024px) {
            .services-table {
                display: block;
                overflow-x: auto;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            
            .page-header {
                padding: 15px;
            }

            .services-table td {
                min-width: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="container">        <div class="page-header">
            <div>
                <h1 class="page-title">Catégories et Services</h1>
                <p>Vue d'ensemble des services par catégorie</p>
            </div>
            <a href="../partie_admin/dashbord.php" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Retour au tableau de bord
            </a>
        </div><div class="categories-section">
            <?php foreach ($categories as $categorie): ?>
                <div class="category-header">
                    <h2 class="category-name"><?php echo htmlspecialchars($categorie['nom']); ?></h2>
                </div>

                <?php if (!empty($categorie['services'])): ?>
                    <table class="services-table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Description</th>
                                <th>Prix</th>
                                <th>Durée estimée</th>
                                <th>Administrateur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categorie['services'] as $service): ?>
                                <tr>
                                    <td class="service-name"><?php echo htmlspecialchars($service['nom']); ?></td>
                                    <td class="service-description"><?php echo htmlspecialchars($service['description']); ?></td>
                                    <td class="service-price"><?php echo number_format($service['prix'], 0, ',', ' '); ?> MRU</td>
                                    <td class="service-duration"><?php echo htmlspecialchars($service['duree']); ?> min</td>
                                    <td class="service-admin">
                                        <i class="fas fa-user"></i> <?php echo htmlspecialchars($service['admin']); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-services">
                        <i class="fas fa-info-circle"></i> Aucun service dans cette catégorie
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
