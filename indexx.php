<?php
include('./db_connection.php');
$sql = "SELECT * FROM service";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Khadamti - Accueil</title>
  <link rel="stylesheet" href="style/css/style.css">
</head>
<body>

  <header>
    <div class="logo">Khadamti</div>
    <nav>
      <a href="#">Accueil</a>
      <a href="#">Nos Services</a>
      <a href="partie_login/login_client.php">Connexion</a>
    </nav>
  </header>

  <section class="hero">
    <h1>Découvrez nos services</h1>
    <form class="search-bar">
      <input type="text" placeholder="Rechercher des services...">
      <button type="submit">Rechercher</button>
    </form>
  </section>

  <section class="services">
    <h2>Nos Services</h2>
    <div class="service-cards">
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="card">
          <div class="icon">🔧</div>
          <h3><?php echo htmlspecialchars($row['nom_service']); ?></h3>
          <p><?php echo htmlspecialchars($row['description']); ?></p>
        </div>
      <?php endwhile; ?>
    </div>
  </section>

</body>
</html>