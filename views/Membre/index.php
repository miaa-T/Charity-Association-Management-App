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
  <?php include 'navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-text">
            <h1>Faisons la différence ensemble!</h1>
            <p>Notre association soutient les plus démunis grâce à des dons, du bénévolat et des partenariats solidaires. Rejoignez-nous comme membre ou partenaire pour faire la différence et bénéficier d'avantages exclusifs !</p>
            <div class="hero-buttons">
                <a href="#" class="btn member">Rejoindre en tant que Membre</a>
                <a href="#" class="btn partner">Collaborer comme Partenaire</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="../Images/img1.png" alt="Teamwork">
        </div>
    </section>

    <script src="script.js"></script>






    <section class="news-section">
      <h2>Actualités</h2>
      <div class="news-container">
          <div class="news-card">
              <h3>Histoires Inspirantes</h3>
              <p>Grâce à vos dons, Rym, 12 ans, a pu bénéficier d’une opération vitale. Merci pour votre soutien !</p>
          </div>
          <div class="news-card">
              <h3>Partenariats Nouveaux</h3>
              <p>Bienvenue à notre nouveau partenaire, la clinique Santé+, offrant des remises exclusives à nos membres.</p>
          </div>
          <div class="news-card">
              <h3>Mise à Jour des Avantages</h3>
              <p>Découvrez nos nouvelles remises exclusives pour les membres chez nos partenaires : hôtels, restaurants, et plus encore.</p>
          </div>
          <div class="news-card">
              <h3>Résultats d’une Collecte</h3>
              <p>Nous avons collecté 2 tonnes de vêtements lors de notre dernière campagne – un grand merci à tous les donateurs !</p>
          </div>
          <div class="news-card">
              <h3>Appel au Bénévolat</h3>
              <p>Nous avons besoin de bénévoles pour notre collecte alimentaire du 15 janvier. Inscrivez-vous dès maintenant !</p>
          </div>
          <div class="news-card">
              <h3>Lancement d’une Nouvelle Campagne</h3>
              <p>Découvrez nos nouvelles remises exclusives pour les membres chez nos partenaires : hôtels, restaurants, et plus encore.</p>
          </div>
      </div>
      <div class="news-button">
          <a href="#" class="btn">Voir toutes les actualités</a>
      </div>
  </section>
  






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




<?php include 'footer.php'; ?>


</body>
</html>
