<?php
session_start();
include(__DIR__ . '/../db_connection.php');


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Khadamati - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; line-height: 1.6; }
         Navbar updates */
.navbar {
    padding: 1rem 5%;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 999;
}

.navbar .logo {
    display: flex;
    align-items: center;
    font-size: 1.8rem;
    font-weight: bold;
}

.navbar .logo img {
    height: 40px;
    margin-right: 10px;
}

.navbar nav a {
    margin: 0 1rem;
    text-decoration: none;
    color: #333;
    font-size: 1.1rem;
    font-weight: bold;
}

.navbar .search-bar input {
    padding: 0.4rem 1rem;
    border-radius: 20px;
    border: 1px solid #ccc;
    width: 220px;
}
header {
  padding: 1.5rem 5%;
  background: linear-gradient(to right, #fff, #f1f1f1);
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  border-bottom: 2px solid #ddd;
  font-size: 1.2rem;
}

.navbar a {
  font-size: 1.1rem;
  font-weight: 600;
}

.auth-buttons button {
  font-size: 1rem;
  padding: 0.6rem 1.2rem;
}

.hero {
  height: 80vh;
}

.carousel-item img {
  width: 100%;
  height: 80vh;
  object-fit: cover;
}

.carousel-caption {
  bottom: 30%;
  left: 10%;
  text-align: left;
}

.carousel-caption h1 {
  font-size: 3rem;
  color: #fff;
  text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.7);
}

.carousel-caption p {
  font-size: 1.5rem;
  color: #eee;
}

.cta-button {
  margin-top: 1rem;
  padding: 0.8rem 2rem;
  font-size: 1.2rem;
  background-color: #007bff;
  border: none;
  border-radius: 6px;
  color: white;
}
.auth-buttons button {
    margin-left: 10px;
    padding: 0.5rem 1.2rem;
    border-radius: 6px;
    font-size: 1rem;
    cursor: pointer;
    font-weight: bold;
    border: none;
    transition: background-color 0.3s ease;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-outline-primary {
    background-color: transparent;
    color: #007bff;
    border: 2px solid #007bff;
}

.btn-outline-success {
    background-color: transparent;
    color: #28a745;
    border: 2px solid #28a745;
}

.btn-outline-primary:hover,
.btn-outline-success:hover,
.btn-primary:hover,
.btn-secondary:hover {
    opacity: 0.9;
}

/* Hero spacing from top and bottom */
.slider-title {
  font-size: 2.8rem;
  font-weight: bold;
  color: white;
  text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
}

.slider-subtitle {
  font-size: 1.4rem;
  color: #eee;
  text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
}

.carousel-caption {
  bottom: 20%;
  left: 8%;
  right: auto;
  text-align: left;
}

.carousel {
  margin-top: 80px;
  margin-bottom: 40px;
}

.carousel-item {
  height: 75vh;
  width: 100vw;
  object-fit: cover;
  transition: transform 0.6s ease-in-out, opacity 0.5s ease-in-out;
}

        .services-section { padding: 4rem 5%; background: #f9f9f9; }
        .services-title { text-align: center; font-size: 2.5rem; margin-bottom: 2rem; }

        .service-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .service-card:hover { transform: translateY(-5px); }
        .service-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .service-card-body {
            padding: 1.5rem;
            text-align: center;
        }
        .service-card h3 { font-size: 1.5rem; margin-bottom: 1rem; }
        .service-card p { color: #555; margin-bottom: 1.5rem; }
        .service-card a {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            background: #007bff;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
        }
        .service-card a:hover { background: #0056b3; }
        
    </style>
</head>
<body>

<!-- Navbar -->
<header class="navbar">
  <div class="logo">
    <img src="images/logok.jpg" alt="Khadamati Logo" style="height: 50px;">
   
  </div>
  <nav>
    <a href="#">Accueil</a>
    <a href="#">Services</a>
    <a href="#">Contact</a>
  </nav>
  <div class="search-bar">
    <input type="text" placeholder="Rechercher un service..">
  </div>
  
      <div class="auth-buttons">
    <?php if (isset($_SESSION['id']) && $_SESSION['role'] == 'client'): ?>
        <button onclick="location.href='soumettre_demande.php'" class="btn btn-primary">Demander un service</button>
        <button onclick="location.href='voir_mes_demandes.php'" class="btn btn-secondary">Mes demandes</button>
    <?php else: ?>
        <button onclick="location.href='login_client.php'" class="btn btn-outline-primary">Connexion</button>
        <button onclick="location.href='signup.php'" class="btn btn-outline-success">S'inscrire</button>
    <?php endif; ?>
</div>
</nav>

<!-- Slider -->
<!-- Hero Slider Start -->
 
<div id="heroSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
  <div class="carousel-inner">

    <div class="carousel-item active">
    <div class="carousel-caption d-none d-md-block text-start">
  <h1 class="slider-title">Tous vos services à domicile</h1>
  <p class="slider-subtitle">Réparations, nettoyage, plomberie, électricité et plus encore.</p>
</div>
      <img src="images/nett.jpg" class="d-block w-100" alt="Nettoyage">
      <div class="carousel-caption d-none d-md-block">
       
      </div>
    </div>

    <div class="carousel-item">
      <div class="carousel-caption d-none d-md-block text-start">
  <h1 class="slider-title">Tous vos services à domicile</h1>
  <p class="slider-subtitle">Réparations, nettoyage, plomberie, électricité et plus encore.</p>
</div>
      <img src="images/plomberie.jpg" class="d-block w-100" alt="Plomberie">
      <div class="carousel-caption d-none d-md-block">
      
      </div>
    </div>

    <div class="carousel-item">
      <div class="carousel-caption d-none d-md-block text-start">
  <h1 class="slider-title">Tous vos services à domicile</h1>
  <p class="slider-subtitle">Réparations, nettoyage, plomberie, électricité et plus encore.</p>
</div>
      <img src="images/Électricité.jpg" class="d-block w-100" alt="Électricité">
      <div class="carousel-caption d-none d-md-block">
        
      </div>
    </div>

    <div class="carousel-item">
      <div class="carousel-caption d-none d-md-block text-start">
  <h1 class="slider-title">Tous vos services à domicile</h1>
  <p class="slider-subtitle">Réparations, nettoyage, plomberie, électricité et plus encore.</p>
</div>
      <img src="images/Mécanique.jpg" class="d-block w-100" alt="Mécanique">
      <div class="carousel-caption d-none d-md-block">
        
      </div>
    </div>

    <div class="carousel-item">
      <div class="carousel-caption d-none d-md-block text-start">
  <h1 class="slider-title">Tous vos services à domicile</h1>
  <p class="slider-subtitle">Réparations, nettoyage, plomberie, électricité et plus encore.</p>
</div>
      <img src="images/livraison.jpg" class="d-block w-100" alt="Livraison">
      <div class="carousel-caption d-none d-md-block">
      
      </div>
     
    </div>

  </div>
</div>
<!-- Hero Slider End -->
<!-- Services -->
<section class="services-section">
    <h2 class="services-title">Nos Services</h2>
    <div class="row">
        <?php
        $sql = "SELECT * FROM service";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $image_name = strtolower($row['nom_service']) . ".jpg";
            echo '
            <div class="col-md-4 mb-4">
                <div class="service-card">
                    <img src="images/' . $image_name . '" alt="' . htmlspecialchars($row['nom_service']) . '">
                    <div class="service-card-body">
                        <h3>' . htmlspecialchars($row['nom_service']) . '</h3>
                        <p>' . htmlspecialchars($row['description']) . '</p>
                        <a href="service_details.php?id_service=' . $row['id_service'] . '">Voir les détails</a>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>






