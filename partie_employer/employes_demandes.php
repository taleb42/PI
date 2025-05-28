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

// Construction de la requête de base
$sql = "SELECT 
            e.id_employe,
            e.nom as employe_nom,
            e.specialite,
            e.email,
            e.numero_telephone,
            e.adresse,
            e.statut as employe_statut,
            COUNT(DISTINCT d.id_demande) as total_demandes,
            d.id_demande,
            d.description as demande_description,
            d.statut as demande_statut,
            d.date_demande,
            s.nom_service,
            s.categorie,
            c.nom as client_nom,
            a.nom as admin_nom
        FROM Employe e
        LEFT JOIN Demande d ON e.id_employe = d.id_employe
        LEFT JOIN Service s ON d.id_service = s.id_service
        LEFT JOIN Client c ON d.id_client = c.id_client
        LEFT JOIN Administrateur a ON s.id_admin = a.id_admin
        WHERE 1=1";

// Ajout des conditions de filtrage
if ($searchQuery) {
    $sql .= " AND (e.nom LIKE '%$searchQuery%' OR e.email LIKE '%$searchQuery%')";
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

$sql .= " GROUP BY e.id_employe, d.id_demande
          ORDER BY e.nom, d.date_demande DESC";

$result = $conn->query($sql);
$employes = [];

// Organisation des données par employé
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $id_employe = $row['id_employe'];
        if (!isset($employes[$id_employe])) {
            $employes[$id_employe] = [
                'nom' => $row['employe_nom'],
                'specialite' => $row['specialite'],
                'email' => $row['email'],
                'telephone' => $row['numero_telephone'],
                'adresse' => $row['adresse'],
                'statut' => $row['employe_statut'],
                'total_demandes' => $row['total_demandes'],
                'demandes' => []
            ];
        }
        
        if ($row['id_demande']) {
            $employes[$id_employe]['demandes'][] = [
                'service' => $row['nom_service'],
                'categorie' => $row['categorie'],
                'client' => $row['client_nom'],
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
    <title>Gestion des Employés - Khadamati</title>
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
        }

        .filters form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            margin-bottom: 5px;
            font-weight: 500;
        }

        .filter-group input,
        .filter-group select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .employe-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .employe-header {
            background: #2C3E50;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .employe-info {
            flex: 1;
        }

        .employe-stats {
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

        .export-btn {
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

        .export-btn:hover {
            background: #1ABC9C;
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
                <h1>Gestion des Employés</h1>
                <p>Vue d'ensemble des employés et leurs commandes</p>
            </div>
            <div>
                <a href="export.php" class="export-btn">
                    <i class="fas fa-download"></i>
                    Exporter les données
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

        <?php foreach ($employes as $employe): ?>
            <div class="employe-card">
                <div class="employe-header">
                    <div class="employe-info">
                        <h2><?php echo htmlspecialchars($employe['nom']); ?></h2>
                        <p>
                            <i class="fas fa-briefcase"></i> <?php echo htmlspecialchars($employe['specialite']); ?> |
                            <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($employe['email']); ?> |
                            <i class="fas fa-phone"></i> <?php echo htmlspecialchars($employe['telephone']); ?>
                        </p>
                    </div>
                    <div class="employe-stats">
                        <strong><?php echo $employe['total_demandes']; ?></strong> demandes traitées
                    </div>
                </div>

                <?php if (!empty($employe['demandes'])): ?>
                    <table class="demandes-table">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Catégorie</th>
                                <th>Client</th>
                                <th>Admin</th>
                                <th>Date</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($employe['demandes'] as $demande): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($demande['service']); ?></td>
                                    <td><?php echo htmlspecialchars($demande['categorie']); ?></td>
                                    <td><?php echo htmlspecialchars($demande['client']); ?></td>
                                    <td><?php echo $demande['admin'] ? htmlspecialchars($demande['admin']) : 'Non assigné'; ?></td>
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
                        Aucune demande traitée par cet employé
                    </p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
