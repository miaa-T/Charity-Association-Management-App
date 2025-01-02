<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remises et Avantages</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Discounts and Advantages Section -->
    <main class="discounts-page-section">
        <div class="search-filter-container">
            <input type="text" placeholder="Rechercher..." class="search-input">
            <button class="filter-btn"><i class="fa fa-filter"></i> Filtres</button>
        </div>

        <!-- Limited Time Offers -->
        <section class="limited-offers-section">
            <h2>Offres Limitées</h2>
            <div class="limited-offers-container">
                <!-- Offer 1 -->
                <div class="limited-offer-card">
                    <div class="limited-offer-header">
                        <span class="offer-expiry"><i class="fa fa-clock-o"></i> Expire dans 2 jours</span>
                    </div>
                    <div class="limited-offer-body">
                        <div class="offer-icon">
                            <i class="fa fa-shopping-bag"></i>
                        </div>
                        <h4>Partenaire A</h4>
                        <p>Commerce local</p>
                        <p class="offer-discount">-30%</p>
                        <p>Sur tous les articles en magasin</p>
                        <button class="offer-btn">Voir l'offre</button>
                    </div>
                </div>
                <!-- Offer 2 -->
                <div class="limited-offer-card">
                    <div class="limited-offer-header">
                        <span class="offer-expiry"><i class="fa fa-clock-o"></i> Expire dans 5 jours</span>
                    </div>
                    <div class="limited-offer-body">
                        <div class="offer-icon">
                            <i class="fa fa-cutlery"></i>
                        </div>
                        <h4>Restaurant B</h4>
                        <p>Restauration</p>
                        <p class="offer-discount">2 pour 1</p>
                        <p>Sur les menus du midi</p>
                        <button class="offer-btn">Voir l'offre</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Permanent Discounts -->
        <section class="permanent-discounts-section">
            <h2>Remises Permanentes</h2>
            <div class="permanent-discounts-container">
                <div class="permanent-discount-card">
                    <h4>Boutique C</h4>
                    <p>Mode</p>
                    <p class="discount-value">-15%</p>
                    <p>Permanent sur présentation de la carte</p>
                    <button class="offer-btn">Plus d'infos</button>
                </div>
                <div class="permanent-discount-card">
                    <h4>Salle de Sport D</h4>
                    <p>Sport</p>
                    <p class="discount-value">-20%</p>
                    <p>Sur l'abonnement annuel</p>
                    <button class="offer-btn">Plus d'infos</button>
                </div>
                <div class="permanent-discount-card">
                    <h4>Librairie E</h4>
                    <p>Culture</p>
                    <p class="discount-value">-10%</p>
                    <p>Sur tous les livres</p>
                    <button class="offer-btn">Plus d'infos</button>
                </div>
                <div class="permanent-discount-card">
                    <h4>Librairie E</h4>
                    <p>Culture</p>
                    <p class="discount-value">-10%</p>
                    <p>Sur tous les livres</p>
                    <button class="offer-btn">Plus d'infos</button>
                </div>
                <div class="permanent-discount-card">
                    <h4>Librairie E</h4>
                    <p>Culture</p>
                    <p class="discount-value">-10%</p>
                    <p>Sur tous les livres</p>
                    <button class="offer-btn">Plus d'infos</button>
                </div>
                <div class="permanent-discount-card">
                    <h4>Librairie E</h4>
                    <p>Culture</p>
                    <p class="discount-value">-10%</p>
                    <p>Sur tous les livres</p>
                    <button class="offer-btn">Plus d'infos</button>
                </div>
                <div class="permanent-discount-card">
                    <h4>Librairie E</h4>
                    <p>Culture</p>
                    <p class="discount-value">-10%</p>
                    <p>Sur tous les livres</p>
                    <button class="offer-btn">Plus d'infos</button>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
