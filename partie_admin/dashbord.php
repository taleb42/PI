<?php
session_start();
include_once '../include/db_config.php';
include_once '../include/dashboard_stats.php';
include_once '../include/functions.php';

if (!isset($_SESSION['role'])) {
    header("Location: ../partie_login/login_admin.php");
    exit;
}

$role = $_SESSION['role'];
$stats = getDashboardStats($conn);


// Récupérer les demandes en attente pour l'admin
$demandes_en_attente = [];
if ($role === 'admin') {
    $demandes_en_attente = getDemandesEnAttente($conn);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khadamati - Tableau de bord</title>
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
            background-color: #ECF0F1;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #2C3E50;
            color: white;
            padding: 20px 0;
            height: 100vh;
            position: fixed;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h1 {
            font-size: 24px;
            color: #1ABC9C;
        }

        .sidebar-menu {
            margin-top: 20px;
        }

        .menu-item {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .menu-item:hover {
            background-color: #1ABC9C;
            color: white;
        }

        .menu-item i {
            margin-right: 10px;
            width: 20px;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 30px;
        }

        .dashboard-header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .dashboard-title {
            color: #2C3E50;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 24px;
            color: white;
        }

        .stat-title {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 600;
            color: #2C3E50;
        }

        .actions-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 30px;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .action-button {
            padding: 15px;
            border: none;
            border-radius: 8px;
            background-color: #1ABC9C;
            color: white;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-button:hover {
            background-color: #16A085;
            text-decoration: none;
        }

        .action-button i {
            margin-right: 8px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            color: #333;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-accepter {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn-refuser {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h1>Khadamati</h1>
        </div>
        <div class="sidebar-menu">
            <a href="dashbord.php" class="menu-item">
                <i class="fas fa-home"></i>
                Tableau de bord
            </a>
            <a href="../partie_login/indexx.php" class="menu-item">
                <i class="fas fa-globe"></i>
                Site Principal
            </a>
            <?php if ($role === 'admin'): ?>
                
                <a href="../partie_categories/categories_services.php" class="menu-item">
                    <i class="fas fa-tags"></i>
                    Catégories/service
                </a>
                <a href="../partie_employer/employes_demandes.php" class="menu-item">
                    <i class="fas fa-users"></i>
                    Employés
                </a>
                <a href="../partie_client/Clients_demandes.php" class="menu-item">
                    <i class="fas fa-user-friends"></i>
                    Clients
                </a>
                <a href="../partie_admin/demandes.php" class="menu-item">
                    <i class="fas fa-clipboard-list"></i>
                    Commandes
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <h2 class="dashboard-title">Tableau de bord</h2>
            <p>Bienvenue sur votre espace d'administration Khadamati</p>
        </div>

        <?php if ($role === 'admin'): ?>
            <!-- Stats Container -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: #3498db;">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="stat-title">Services</div>
                    <div class="stat-value"><?php echo $stats['services']; ?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background-color: #e74c3c;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-title">Employés</div>
                    <div class="stat-value"><?php echo $stats['employes']; ?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background-color: #2ecc71;">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <div class="stat-title">Clients</div>
                    <div class="stat-value"><?php echo $stats['clients']; ?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background-color: #f1c40f;">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="stat-title">Commandes</div>
                    <div class="stat-value"><?php echo $stats['commandes']; ?></div>
                </div>
            </div>
            <!-- Actions Container -->
            <div class="actions-container">
                <h3>Actions rapides</h3>
                <div class="action-buttons">
                    <a href="../partie_admin/add_admin_form.php" class="action-button">
                        <i class="fas fa-user-shield"></i>
                        Ajouter un administrateur
                    </a>
                    <a href="../partie_employer/add_employe_form.php" class="action-button">
                        <i class="fas fa-user-plus"></i>
                        Ajouter un employé
                    </a>
                    <a href="../partie_service/add_service_form.php" class="action-button">
                        <i class="fas fa-plus-circle"></i>
                        Ajouter un service
                    </a>
                    <a href="../partie_categories/add_categorie_form.php" class="action-button">
                        <i class="fas fa-folder-plus"></i>
                        Ajouter une catégorie
                    </a>
                    <a href="../partie_client/add_client_form.php" class="action-button">
                        <i class="fas fa-user-plus"></i>
                        Ajouter un client
                    </a>
                </div>
            </div>

            <!-- Demandes en attente -->
            <div class="actions-container" style="margin-top:30px;">
                <h3><i class="fas fa-hourglass-half"></i> Nouvelles demandes de service en attente</h3>
                <?php if (!empty($demandes_en_attente)): ?>
                    <table style="width:100%;margin-top:15px;background:white;border-radius:8px;overflow:hidden;">
                        <thead>
                            <tr style="background:#f8f9fa;">
                                <th style="padding:10px;">Service</th>
                                <th style="padding:10px;">Client</th>
                                <th style="padding:10px;">Adresse</th>
                                <th style="padding:10px;">Description</th>
                                <th style="padding:10px;">Date</th>
                                <th style="padding:10px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($demandes_en_attente as $demande): ?>
                                <tr>
                                    <td style="padding:10px;"><?= htmlspecialchars($demande['nom_service']) ?></td>
                                    <td style="padding:10px;"><?= htmlspecialchars($demande['client_nom']) ?></td>
                                    <td style="padding:10px;"><?= htmlspecialchars($demande['adresse']) ?></td>
                                    <td style="padding:10px;"><?= htmlspecialchars($demande['description']) ?></td>
                                    <td style="padding:10px;"><?= date('d/m/Y H:i', strtotime($demande['date_demande'])) ?></td>
                                    <td style="padding:10px;">
                                        <form action="traiter_demande.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="id_demande" value="<?= $demande['id_demande'] ?>">
                                            <button type="submit" name="action" value="accepter" style="background:#2ecc71;color:white;border:none;padding:6px 12px;border-radius:5px;cursor:pointer;margin-right:5px;">✅ Accepter</button>
                                            <button type="submit" name="action" value="refuser" style="background:#e74c3c;color:white;border:none;padding:6px 12px;border-radius:5px;cursor:pointer;">❌ Refuser</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="padding:20px;text-align:center;color:#666;">Aucune nouvelle demande en attente</p>
                <?php endif; ?>
            </div>

        <?php elseif ($role === 'client'): ?>
            <div class="actions-container">
                <h3>Espace Client</h3>
                <div class="action-buttons">
                    <a href="../partie_client/nouvelle_demande.php" class="action-button">
                        <i class="fas fa-plus-circle"></i>
                        Nouvelle demande
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
    // Mise à jour automatique des statistiques
    function updateStats() {
        fetch('get_stats.php')
            .then(response => response.json())
            .then(data => {
                document.querySelector('.stat-value[data-type="services"]').textContent = data.services;
                document.querySelector('.stat-value[data-type="employes"]').textContent = data.employes;
                document.querySelector('.stat-value[data-type="clients"]').textContent = data.clients;
                document.querySelector('.stat-value[data-type="commandes"]').textContent = data.commandes;
            });
    }

    // Mise à jour toutes les 30 secondes
    setInterval(updateStats, 30000);
    </script>
</body>
</html>