<?php
session_start();
include_once '../include/db_config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../partie_login/login_admin.php');
    exit;
}

// Fonction pour obtenir le statut formaté
function getStatusLabel($statut) {
    switch ($statut) {
        case 'en_attente': return 'En attente';
        case 'en_cours': return 'En cours';
        case 'terminee': return 'Terminée';
        case 'annulee': return 'Annulée';
        default: return 'Inconnu';
    }
}

// Récupération des filtres
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$dateStart = isset($_GET['date_start']) ? $_GET['date_start'] : '';
$dateEnd = isset($_GET['date_end']) ? $_GET['date_end'] : '';

// Construction de la requête
$sql = "SELECT 
            c.id_client,
            c.nom as client_nom,
            c.email as client_email,
            COUNT(DISTINCT d.id_demande) as total_demandes,
            d.id_demande,
            d.description as demande_description,
            d.statut as demande_statut,
            d.date_demande,
            s.nom_service,
            s.categorie,
            e.nom as employe_nom,
            a.nom as admin_nom
        FROM Client c
        LEFT JOIN Demande d ON c.id_client = d.id_client
        LEFT JOIN Service s ON d.id_service = s.id_service
        LEFT JOIN Employe e ON d.id_employe = e.id_employe
        LEFT JOIN Administrateur a ON s.id_admin = a.id_admin
        WHERE 1=1";

// Ajout des conditions de filtrage
if ($searchQuery) {
    $sql .= " AND (c.nom LIKE '%$searchQuery%' OR c.email LIKE '%$searchQuery%')";
}
if ($statusFilter) {
    $sql .= " AND d.statut = '$statusFilter'";
}
if ($dateStart) {
    $sql .= " AND d.date_demande >= '$dateStart'";
}
if ($dateEnd) {
    $sql .= " AND d.date_demande <= '$dateEnd'";
}

$sql .= " GROUP BY c.id_client, d.id_demande
          ORDER BY c.nom, d.date_demande DESC";

$result = $conn->query($sql);
$clients = [];

// Organisation des données par client
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $id_client = $row['id_client'];
        if (!isset($clients[$id_client])) {
            $clients[$id_client] = [
                'nom' => $row['client_nom'],
                'email' => $row['client_email'],
                'total_demandes' => $row['total_demandes'],
                'demandes' => []
            ];
        }
        
        if ($row['id_demande']) {
            $clients[$id_client]['demandes'][] = [
                'service' => $row['nom_service'],
                'categorie' => $row['categorie'],
                'employe' => $row['employe_nom'],
                'admin' => $row['admin_nom'],
                'statut' => $row['demande_statut'],
                'date' => $row['date_demande'],
                'description' => $row['demande_description']
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
    <title>Gestion des Clients - Khadamati</title>
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
        }

        .page-header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filters {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }        .filters form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            margin-bottom: 8px;
            font-weight: 600;
            color: #2C3E50;
            font-size: 0.9rem;
        }

        .filter-group input,
        .filter-group select {
            padding: 10px 12px;
            border: 2px solid #e2e8f0;
            border-radius: 6px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .filter-group input:focus,
        .filter-group select:focus {
            border-color: #2C3E50;
            outline: none;
            box-shadow: 0 0 0 3px rgba(44, 62, 80, 0.1);
        }

        .filter-group button {
            padding: 10px 20px;
            background: #2C3E50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .filter-group button:hover {
            background: rgb(8, 192, 155);
            transform: translateY(-1px);
        }

        .client-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .client-header {
            background: #2C3E50;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .client-info {
            flex: 1;
        }

        .client-stats {
            background: #34495e;
            padding: 10px 20px;
            border-radius: 20px;
        }

        .demandes-table {
            width: 100%;
            border-collapse: collapse;
        }

        .demandes-table th,
        .demandes-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .demandes-table th {
            background: #f8f9fa;
            font-weight: 600;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-en_attente { background: #ffeeba; color: #856404; }
        .status-en_cours { background: #b8daff; color: #004085; }
        .status-terminee { background: #c3e6cb; color: #155724; }
        .status-annulee { background: #f5c6cb; color: #721c24; }

        .back-button{
            padding: 10px 20px;
            background: #2C3E50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-button:hover {
            background:rgb(8, 192, 155);
        }

        @media (max-width: 768px) {
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
                <h1>Gestion des Clients</h1>
                <p>Vue d'ensemble des clients et leurs demandes</p>
            </div>
            <div>
               <a href="../partie_admin/dashbord.php" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Retour au tableau de bord
            </a>
            </div>
        </div>

        <div class="filters">
            <form action="" method="GET">
                <div class="filter-group">
                    <label>Rechercher</label>
                    <input type="text" name="search" value="<?php echo htmlspecialchars($searchQuery); ?>" placeholder="Nom ou email">
                </div>
                <div class="filter-group">
                    <label>Statut</label>
                    <select name="status">
                        <option value="">Tous</option>
                        <option value="en_attente" <?php echo $statusFilter === 'en_attente' ? 'selected' : ''; ?>>En attente</option>
                        <option value="en_cours" <?php echo $statusFilter === 'en_cours' ? 'selected' : ''; ?>>En cours</option>
                        <option value="terminee" <?php echo $statusFilter === 'terminee' ? 'selected' : ''; ?>>Terminée</option>
                        <option value="annulee" <?php echo $statusFilter === 'annulee' ? 'selected' : ''; ?>>Annulée</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Date début</label>
                    <input type="date" name="date_start" value="<?php echo $dateStart; ?>">
                </div>
                <div class="filter-group">
                    <label>Date fin</label>
                    <input type="date" name="date_end" value="<?php echo $dateEnd; ?>">
                </div>
                <div class="filter-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="export-btn">
                        <i class="fas fa-filter"></i>
                        Filtrer
                    </button>
                </div>
            </form>
        </div>

        <?php foreach ($clients as $client): ?>
            <div class="client-card">
                <div class="client-header">
                    <div class="client-info">
                        <h2><?php echo htmlspecialchars($client['nom']); ?></h2>
                        <p>
                            <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($client['email']); ?>
                        </p>
                    </div>
                    <div class="client-stats">
                        <strong><?php echo $client['total_demandes']; ?></strong> demandes au total
                    </div>
                </div>

                <?php if (!empty($client['demandes'])): ?>
                    <table class="demandes-table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Catégorie</th>
                                <th>Employé</th>
                                <th>Admin</th>
                                <th>Date</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($client['demandes'] as $demande): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($demande['service']); ?></td>
                                    <td><?php echo htmlspecialchars($demande['categorie']); ?></td>
                                    <td><?php echo $demande['employe'] ? htmlspecialchars($demande['employe']) : 'Non assigné'; ?></td>
                                    <td><?php echo $demande['admin'] ? htmlspecialchars($demande['admin']) : 'Non validé'; ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($demande['date'])); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $demande['statut']; ?>">
                                            <?php echo getStatusLabel($demande['statut']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="padding: 20px; text-align: center; color: #666;">
                        Aucune demande pour ce client
                    </p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
