<?php
session_start();
include_once '../include/db_config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../partie_login/login_admin.php');
    exit;
}

// Récupérer toutes les demandes avec les informations associées
$sql = "SELECT 
            d.id_demande,
            d.description as demande_description,
            d.statut,
            d.date_demande,
            d.date_execution,
            s.nom_service,
            s.categorie,
            c.nom as client_nom,
            e.nom as employe_nom,
            a.nom as admin_nom
        FROM Demande d
        LEFT JOIN Service s ON d.id_service = s.id_service
        LEFT JOIN Client c ON d.id_client = c.id_client
        LEFT JOIN Employe e ON d.id_employe = e.id_employe
        LEFT JOIN Administrateur a ON s.id_admin = a.id_admin
        ORDER BY d.date_demande DESC";

$result = $conn->query($sql);
$demandes = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $demandes[] = $row;
    }
}

// Fonction pour obtenir la classe de statut
function getStatusClass($statut) {
    switch ($statut) {
        case 'en_attente':
            return 'status-pending';
        case 'en_cours':
            return 'status-progress';
        case 'terminee':
            return 'status-completed';
        case 'annulee':
            return 'status-cancelled';
        default:
            return 'status-pending';
    }
}

// Fonction pour obtenir le libellé du statut
function getStatusLabel($statut) {
    switch ($statut) {
        case 'en_attente':
            return 'En attente';
        case 'en_cours':
            return 'En cours';
        case 'terminee':
            return 'Terminée';
        case 'annulee':
            return 'Annulée';
        default:
            return 'En attente';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Demandes - Khadamati</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
        }

        .page-header {
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

        .demandes-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .demandes-table th, 
        .demandes-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .demandes-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2C3E50;
        }

        .demandes-table tr:hover {
            background-color: #f8f9fa;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            display: inline-block;
        }

        .status-pending {
            background-color: #ffeeba;
            color: #856404;
        }

        .status-progress {
            background-color: #b8daff;
            color: #004085;
        }

        .status-completed {
            background-color: #c3e6cb;
            color: #155724;
        }

        .status-cancelled {
            background-color: #f5c6cb;
            color: #721c24;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
        }

        @media (max-width: 1024px) {
            .demandes-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <div>
                <h1 class="page-title">Gestion des Demandes</h1>
                <p>Liste de toutes les demandes de services</p>
            </div>
            <a href="dashbord.php" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Retour au tableau de bord
            </a>
        </div>

        <?php if (!empty($demandes)): ?>
            <table class="demandes-table">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Catégorie</th>
                        <th>Client</th>
                        <th>Employé</th>
                        <th>Administrateur</th>
                        <th>Date de demande</th>
                        <th>Statut</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($demandes as $demande): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($demande['nom_service']); ?></td>
                            <td><?php echo htmlspecialchars($demande['categorie']); ?></td>
                            <td><?php echo htmlspecialchars($demande['client_nom']); ?></td>
                            <td><?php echo $demande['employe_nom'] ? htmlspecialchars($demande['employe_nom']) : 'Non assigné'; ?></td>
                            <td><?php echo $demande['admin_nom'] ? htmlspecialchars($demande['admin_nom']) : 'Non validé'; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($demande['date_demande'])); ?></td>
                            <td>
                                <span class="status-badge <?php echo getStatusClass($demande['statut']); ?>">
                                    <?php echo getStatusLabel($demande['statut']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($demande['demande_description']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-inbox fa-3x"></i>
                <p>Aucune demande n'a été trouvée</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>