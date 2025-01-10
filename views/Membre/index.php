<?php
session_start(); // Start the session
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name

// Include the controller
require_once __DIR__ . '/../../controllers/EvenementsActualitesController.php';
$controller = new EvenementsActualitesController();
$actualites = $controller->getAllActualites();
$evenements = $controller->getAllEvenements();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Association Caritative</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <!-- Include the navbar -->
  <?php include 'navbar.php'; ?>

  <!-- Hero Section (only shown if the user is not logged in) -->
  <?php if (!isset($_SESSION['user_id'])): ?>
    <section class="hero">
        <div class="hero-text">
            <h1>Faisons la différence ensemble!</h1>
            <p>Notre association soutient les plus démunis grâce à des dons, du bénévolat et des partenariats solidaires. Rejoignez-nous comme membre ou partenaire pour faire la différence et bénéficier d'avantages exclusifs !</p>
            <div class="hero-buttons">
                <a href="#" class="btn member">Rejoindre en tant que Membre</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="../Images/img1.png" alt="Teamwork">
        </div>
    </section>
  <?php endif; ?>

  <!-- Mixed Actualités and Événements Section -->
  <section class="news-page">
      <h1>Actualités et Événements</h1>

      <!-- Display Actualités -->
      <h2>Actualités</h2>
      <div class="news-container">
          <?php foreach ($actualites as $actualite): ?>
              <div class="news-card">
                  <img src="<?php echo htmlspecialchars($actualite['image']); ?>" alt="<?php echo htmlspecialchars($actualite['titre']); ?>">
                  <h3><?php echo htmlspecialchars($actualite['titre']); ?></h3>
                  <p><?php echo htmlspecialchars($actualite['description']); ?></p>
                  <a href="#" class="btn">Lire plus</a>
              </div>
          <?php endforeach; ?>
      </div>

    

  <!-- Advantages Section -->
  <section class="advantages-section">
    <h2>Avantages pour les Membres</h2>
    <div class="search-filter">
        <input type="text" placeholder="Rechercher..." id="search-input">
        <button class="filter-btn">Filtres</button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nom de l’avantage</th>
                <th>Description</th>
                <th>Catégorie</th>
                <th>Validité</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>⭐ Réduction en Boutique Premium</td>
                <td>20% de réduction dans tous les membres premium</td>
                <td><span class="badge shopping">Shopping</span></td>
                <td>31 Dec 2025</td>
                <td><button class="info-btn">Plus d’infos</button></td>
            </tr>
            <tr>
                <td>Bilan de Santé</td>
                <td>Forfait annuel de dépistage santé</td>
                <td><span class="badge health">Santé</span></td>
                <td>Annuel</td>
                <td><button class="info-btn">Plus d’infos</button></td>
            </tr>
        </tbody>
    </table>
    <div class="pagination">
        <span>Affichage de 1 à 10 sur 24 avantages</span>
        <div class="pagination-buttons">
            <button class="pagination-btn">Précédent</button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">3</button>
            <button class="pagination-btn">Suivant</button>
        </div>
    </div>
  </section>

  <!-- Partners Section -->
  <section class="partners-section">
    <h2>Nos partenaires</h2>
    <div class="partners-grid">
        <div class="partner-logo">
            <img src="../Images/partner1.png" alt="ComgTime">
        </div>
        <div class="partner-logo">
            <img src="../Images/partner2.png" alt="Hotel">
        </div>
        <div class="partner-logo">
            <img src="../Images/partner3.png" alt="Medical">
        </div>
        <div class="partner-logo">
            <img src="../Images/partner4.png" alt="Education">
        </div>
        <div class="partner-logo">
            <img src="../Images/partner5.png" alt="Business">
        </div>
        <div class="partner-logo">
            <img src="../Images/partner6.png" alt="Spontor">
        </div>
    </div>
  </section>

 

  <script src="script.js"></script>
   <!-- Footer -->
  <?php include 'footer.php'; ?>
</body>
</html>