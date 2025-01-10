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
    $groupedPartners = $partenaireController->getAllPartnersByCategory();
    ?>

    <!-- Partners Page Section -->
    <main class="partners-page-section">
        <h2>Catalogue des Partenaires</h2>

        <?php foreach ($groupedPartners as $category => $partners): ?>
            <!-- Category Section -->
            <div class="partners-page-category">
                <h3><?php echo htmlspecialchars($category); ?></h3>
                <div class="partners-page-scroll">
                    <?php foreach ($partners as $partner): ?>
                        <div class="partners-page-card">
                            <h4><?php echo htmlspecialchars($partner['name']); ?></h4>
                            <p><?php echo htmlspecialchars($partner['city']); ?></p>
                            <p><?php echo htmlspecialchars($partner['discount']) . '%'; ?></p>
                            <p><?php echo htmlspecialchars($partner['details']); ?></p>
                            <button class="partners-page-btn">Plus de détails</button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
