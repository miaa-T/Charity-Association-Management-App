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

    <?php
    require_once __DIR__ . '/../controllers/RemisesController.php';
    $controller = new RemisesController();
    $limitedOffers = $controller->getLimitedOffers();
    $permanentOffers = $controller->getPermanentOffers();
    ?>

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
        <?php foreach ($limitedOffers as $offer): ?>
            <div class="limited-offer-card">
                <div class="limited-offer-header">
                    <span class="offer-expiry"><i class="fa fa-clock-o"></i> Expire dans <?php 
                        $daysLeft = (strtotime($offer['expire_le']) - strtotime(date('Y-m-d'))) / 86400; 
                        echo $daysLeft; ?> jours</span>
                </div>
                <div class="limited-offer-body">
                    <h4><?php echo htmlspecialchars($offer['nom']); ?></h4>
                    <p>Partenaire : <?php echo htmlspecialchars($offer['partenaire_nom']); ?></p>
                    <p class="offer-discount"><?php echo htmlspecialchars($offer['valeur_remise']); ?></p>
                    <p><?php echo htmlspecialchars($offer['description']); ?></p>
                    <button class="offer-btn">Voir l'offre</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Permanent Discounts -->
<section class="permanent-discounts-section">
    <h2>Remises Permanentes</h2>
    <div class="permanent-discounts-container">
        <?php foreach ($permanentOffers as $offer): ?>
            <div class="permanent-discount-card">
                <h4><?php echo htmlspecialchars($offer['nom']); ?></h4>
                <p>Partenaire : <?php echo htmlspecialchars($offer['partenaire_nom']); ?></p>
                <p class="discount-value"><?php echo htmlspecialchars($offer['valeur_remise']); ?></p>
                <p><?php echo htmlspecialchars($offer['description']); ?></p>
                <button class="offer-btn">Plus d'infos</button>
            </div>
        <?php endforeach; ?>
    </div>
</section>

    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
