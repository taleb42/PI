<?php
session_start();
require_once '../include/db_config.php';


?>
<!DOCTYPE html>
<html lang="fr">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Khadamati</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <header>
   
    <nav>
      <img src="../partie_login/images/logok2.jpg" alt="Logo" style="width: 190px; height: auto; margin-bottom: 8px; display: block; margin-left: 15px; margin-right: 0;">
      <ul>
        
        <li><a href="#" class="active">Accueil</a></li>
        <li><a href="#service">Services</a></li>
        <li><a href="#about">À propos</a></li>
      </ul>
    </nav>
      <div class="auth-buttons">
    <?php if (isset($_SESSION['id']) && $_SESSION['role'] == 'client'): ?>
        <button onclick="location.href='#service'" class="btn btn-primary">Demander un service</button>
        <button onclick="location.href='voir_mes_demandes.php'" class="btn btn-secondary">Mes demandes</button>
    <?php else: ?>
        <button onclick="location.href='login_client.php'" class="btn btn-outline-primary">Connexion</button>
        <button onclick="location.href='signup.php'" class="btn btn-outline-success">S'inscrire</button>
    <?php endif; ?>
</div>
</nav>
  </header>

  <section class="hero">
    <div class="hero-slider">
      <div class="slide active" style="background-image: url('images/livraison.jpg');">
        <div class="slide-content">
          <div class="hero-content">
            <h1>Services Publics Simplifiés</h1>
            <p>Votre guichet unique pour tous les services administratifs</p>
          </div>
        </div>
      </div>
      <div class="slide" style="background-image: url('images/servic.jpg');">
        <div class="slide-content">
          <div class="hero-content">
            <h1>Rapidité et Efficacité</h1>
            <p>Gagnez du temps avec nos services en ligne</p>
          </div>
        </div>
      </div>
      <div class="slide" style="background-image: url('images/service2.webp');">
        <div class="slide-content">
          <div class="hero-content">
            <h1>Innovation Digitale</h1>
            <p>Des services modernes pour une administration efficace</p>
          </div>
        </div>
      </div>
      <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1350&q=80');">
        <div class="slide-content">
          <div class="hero-content">
            <h1>À Votre Service</h1>
            <p>Des solutions adaptées à vos besoins</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="about-platform" id="about">
    <div class="container">
      <h2>Bienvenue sur Khadamati</h2>
      <div class="platform-info">
        <div class="info-card">
          <i class="fas fa-bullseye"></i>
          <h3>Faciliter l'Accès</h3>
          <p>Nous connectons les citoyens aux services essentiels pour simplifier leur quotidien.</p>
        </div>
        <div class="info-card">
          <i class="fas fa-hand-holding-heart"></i>
          <h3>Nos Solutions</h3>
          <p>De la santé à l'éducation, nous offrons des services pratiques et accessibles en un clic.</p>
        </div>
        <div class="info-card">
          <i class="fas fa-users"></i>
          <h3>Inclusivité</h3>
          <p>Une plateforme pensée pour tous, favorisant l'accès équitable aux services publics.</p>
        </div>
      </div>
    </div>
  </section>

<section class="services-section" id="service">
    <h2 class="services-title">Nos Services</h2>
    <div class="row">
        <?php
        $sql = "SELECT * FROM service";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $image_name = strtolower($row['nom_service']) . ".jpg";
            echo '            <div class="service-card">
                <img src="images/' . $image_name . '" alt="' . htmlspecialchars($row['nom_service']) . '">
                <div class="service-card-body">
                    <h3>' . htmlspecialchars($row['nom_service']) . '</h3>
                    <p>' . htmlspecialchars($row['description']) . '</p>
                    <a href="service_details.php?id_service=' . $row['id_service'] . '">Voir les détails</a>
                </div>
            </div>';
        }
        ?>
    </div>
</section>

  <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h3>Liens rapides</h3>
        <ul>
          <li><a href="#">Accueil</a></li>
          <li><a href="#">Services</a></li>
          <li><a href="#">Conditions</a></li>
          <li><a href="#">Confidentialité</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h3>Informations de contact</h3>
        <p>Téléphone : +222 42909646 </p>
        <p>Email : khadamaty@gmail.com</p>
        <p>Adresse : Nouakchott TVZ</p>
      </div>
      <div class="footer-section">
        <h3>Suivez-nous</h3>
        <div class="social-icons">
          <a href="https://web.facebook.com/profile.php?id=100068443420353"><i class="fab fa-facebook"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>
  </footer>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;

    function showSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        slides[index].classList.add('active');
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    // Change de slide toutes les 5 secondes
    setInterval(nextSlide, 5000);
});
</script>
</body>
</html>