<?php
function getDashboardStats($conn) {
    $stats = array(
        'services' => 0,
        'employes' => 0,
        'clients' => 0,
        'commandes' => 0
    );
    
    // Compter les services
    $sql = "SELECT COUNT(*) as count FROM service";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['services'] = $row['count'];
    }
    
    // Compter les employés
    $sql = "SELECT COUNT(*) as count FROM employe";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['employes'] = $row['count'];
    }
    
    // Compter les clients
    $sql = "SELECT COUNT(*) as count FROM client";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['clients'] = $row['count'];
    }
    
    // Compter les commandes
    $sql = "SELECT COUNT(*) as count FROM demande";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['commandes'] = $row['count'];
    }
    
    return $stats;
}

function logAction($conn, $user_id, $action_type, $description) {
    $sql = "INSERT INTO audit_log (user_id, action_type, description, created_at) 
            VALUES (?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $action_type, $description);
    return $stmt->execute();
}
?>
