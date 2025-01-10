<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partenaires</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <?php
    require_once __DIR__ . '/../controllers/PartenairesController.php';
    $partenaireController = new PartenaireController();
    $partners = $partenaireController->getAllPartners(); // Use getAllPartners() instead of getAllPartnersByCategory()
    ?>

    <!-- Partners Page Section -->
    <main class="partners-page-section">
        <h2>Catalogue des Partenaires</h2>

        <div class="partners-page-scroll">
            <?php foreach ($partners as $partner): ?>
                <div class="partners-page-card">
                    <!-- Partner Logo -->
                    <?php if (!empty($partner['logo'])): ?>
                        <img src="<?php echo htmlspecialchars($partner['logo']); ?>" alt="<?php echo htmlspecialchars($partner['nom']); ?>" class="partner-logo">
                    <?php endif; ?>

                    <!-- Partner Name -->
                    <h4><?php echo htmlspecialchars($partner['nom']); ?></h4>

                    <!-- Partner City -->
                    <p><strong>Ville:</strong> <?php echo htmlspecialchars($partner['ville']); ?></p>

                    <!-- Partner Discount -->
                    <p><strong>Remise:</strong> <?php echo htmlspecialchars($partner['remise']) . '%'; ?></p>

                    <!-- Partner Details -->
                    <p><strong>Détails:</strong> <?php echo htmlspecialchars($partner['details']); ?></p>

                    <!-- More Details Button -->
                    <button class="partners-page-btn">Plus de détails</button>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>