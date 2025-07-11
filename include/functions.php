<?php
// Include database connection
require_once 'db_config.php';

// Function to clean input data
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to check if email is valid
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to register a client
function register_client($email, $password, $nom = null) {
    global $conn;
    
    // Clean the input data
    $email = clean_input($email);
    $nom = clean_input($nom);

    // Check if email already exists
    $check_sql = "SELECT id FROM client WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        return [
            'success' => false,
            'message' => 'Cette adresse e-mail est déjà utilisée'
        ];
    }

    // Prepare insert statement - only 3 parameters (email, password, nom)
    $sql = "INSERT INTO client (email, password, nom) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $password, $nom);

    if ($stmt->execute()) {
        return [
            'success' => true,
            'client_id' => $conn->insert_id,
            'message' => 'Client enregistré avec succès'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Échec de l\'inscription : ' . $stmt->error
        ];
    }
}

// Function to register an admin
function register_admin($email, $password) {
    global $conn;
    
    // Clean the input data
    $email = clean_input($email);
    
    // Check if email already exists
    $check_sql = "SELECT id FROM administrateur WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        return [
            'success' => false,
            'message' => 'Cette adresse e-mail est déjà utilisée'
        ];
    }

    // Prepare insert statement
    $sql = "INSERT INTO administrateur (email, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        return [
            'success' => true,
            'admin_id' => $conn->insert_id,
            'message' => 'Administrateur enregistré avec succès'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Échec de l\'inscription : ' . $stmt->error
        ];
    }
}

// Function to login a client
function login_client($email, $password) {
    global $conn;
    
    $email = clean_input($email);
    
    $stmt = $conn->prepare("SELECT * FROM client WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        return [
            "success" => true,
            "message" => "Connexion réussie"
        ];
    }
    
    return [
        "success" => false,
        "message" => "Adresse e-mail ou mot de passe invalide"
    ];
}

// Function to login an admin
function login_admin($email, $password) {
    global $conn;
    
    // Clean the input data
    $email = clean_input($email);
    
    // Prepare query
    $sql = "SELECT * FROM administrateur WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        
        // Simple password comparison (no hashing)
        if ($password === $admin['password']) {
            // Set session variables
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['user_type'] = 'admin';
            $_SESSION['is_verified'] = true; // Since new DB doesn't have verification system
            
            // Remove sensitive data
            unset($admin['password']);
            
            return [
                'success' => true,
                'admin' => $admin,
                'message' => 'Login successful'
            ];
        }
    }

    return [
        'success' => false,
        'message' => 'Invalid email or password'
    ];
}

// Simplified functions since new DB doesn't have verification system
// Function to verify code (kept for compatibility but simplified)
function verify_code($code, $email, $user_type) {
    // Since the new database doesn't have verification codes,
    // this function will just check if user exists and log them in
    global $conn;
    
    $email = clean_input($email);
    $user_type = clean_input($user_type);
    
    if ($user_type === 'client') {
        $sql = "SELECT * FROM client WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $client = $result->fetch_assoc();
            
            // Set session variables
            $_SESSION['user_id'] = $client['id'];
            $_SESSION['user_type'] = 'client';
            $_SESSION['is_verified'] = true;
            
            // Remove sensitive data
            unset($client['password']);
            
            return [
                'success' => true,
                'client' => $client,
                'message' => 'Verification successful'
            ];
        }
    } elseif ($user_type === 'admin') {
        $sql = "SELECT * FROM administrateur WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            
            // Set session variables
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['user_type'] = 'admin';
            $_SESSION['is_verified'] = true;
            
            // Remove sensitive data
            unset($admin['password']);
            
            return [
                'success' => true,
                'admin' => $admin,
                'message' => 'Verification successful'
            ];
        }
    }
    
    return [
        'success' => false,
        'message' => 'User not found'
    ];
}

// Function to resend verification code (kept for compatibility)
function resend_verification_code($email, $user_type) {
    // Since the new database doesn't support verification codes,
    // this function will return a success message
    return [
        'success' => true,
        'verification_code' => '123456', // Dummy code
        'message' => 'Verification not required in current system'
    ];
}

// Function to check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_type']);
}

// Function to check if user is a client
function is_client() {
    return is_logged_in() && $_SESSION['user_type'] === 'client';
}

// Function to check if user is an admin
function is_admin() {
    return is_logged_in() && $_SESSION['user_type'] === 'admin';
}

// Function to get current user info
function get_logged_user() {
    if (!is_logged_in()) {
        return null;
    }
    
    global $conn;
    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    
    if ($user_type === 'client') {
        $sql = "SELECT id, email, nom, created_at, updated_at FROM client WHERE id = ?";
    } else {
        $sql = "SELECT id, email, created_at, updated_at FROM administrateur WHERE id = ?";
    }
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    }
    
    return null;
}

// Function to logout user
function logout_user() {
    // Unset all session variables
    $_SESSION = array();
    
    // Destroy the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy the session
    session_destroy();
    
    return [
        'success' => true,
        'message' => 'Logged out successfully'
    ];
}

// Fonction pour récupérer les demandes en attente
function getDemandesEnAttente($conn) {
    $sql = "SELECT d.id_demande, d.description, d.date_demande, d.adresse, d.statut, s.nom_service, c.nom as client_nom FROM Demande d LEFT JOIN Service s ON d.id_service = s.id_service LEFT JOIN Client c ON d.id_client = c.id_client WHERE d.statut = 'en_attente' ORDER BY d.date_demande DESC";
    $result = $conn->query($sql);
    $demandes = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $demandes[] = $row;
        }
    }
    return $demandes;
}
?>