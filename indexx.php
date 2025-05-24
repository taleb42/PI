<?php
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Khadamati - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; line-height: 1.6; }
        * Navbar updates */
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

/* Hero spacing from top and bottom */

.carousel {
  margin-top: 80px;
  margin-bottom: 40px;
}

.carousel-item img {
  height: 70vh;
  width: 100%;
  object-fit: cover;
  transition: transform 0.6s ease-in-out, opacity 0.6s ease-in-out;
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
    <a href="#">À propos</a>
    <a href="#">Contact</a>
  </nav>
  <div class="search-bar">
    <input type="text" placeholder="Rechercher un service...">
  </div>
        <div>
          <button><a href="partie_login/login_client.php">Connexion</a></button>
           <button> <a href="partie_login/signup.php">S'inscrire</a></button>
        </div>
    </div>
</nav>

<!-- Slider -->
<!-- Hero Slider Start -->
<div id="heroSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
  <div class="carousel-inner">

    <div class="carousel-item active">
      <img src="images/nettoyage.jpg" class="d-block w-100" alt="Nettoyage">
      <div class="carousel-caption d-none d-md-block">
        <h5>Service de Nettoyage</h5>
      </div>
    </div>

    <div class="carousel-item">
      <img src="images/plomberie.jpg" class="d-block w-100" alt="Plomberie">
      <div class="carousel-caption d-none d-md-block">
        <h5>Service de Plomberie</h5>
      </div>
    </div>

    <div class="carousel-item">
      <img src="images/electricite.jpg" class="d-block w-100" alt="Électricité">
      <div class="carousel-caption d-none d-md-block">
        <h5>Service d'Électricité</h5>
      </div>
    </div>

    <div class="carousel-item">
      <img src="images/mecanique.jpg" class="d-block w-100" alt="Mécanique">
      <div class="carousel-caption d-none d-md-block">
        <h5>Service de Mécanique</h5>
      </div>
    </div>

    <div class="carousel-item">
      <img src="images/livraison.jpg" class="d-block w-100" alt="Livraison">
      <div class="carousel-caption d-none d-md-block">
        <h5>Service de Livraison</h5>
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






