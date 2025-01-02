<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualités et Événements</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <?php
    require_once __DIR__ . '/../controllers/EvenementsActualitesController.php';
    $controller = new EvenementsActualitesController();
    $actualites = $controller->getAllActualites();
    $evenements = $controller->getAllEvenements();
    ?>

    <main class="news-page">
        <h1>Actualités et Événements</h1>

        <!-- Actualités Section -->
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

        <!-- Événements Section -->
        <h2>Événements</h2>
        <div class="news-container">
            <?php foreach ($evenements as $evenement): ?>
                <div class="news-card">
                    <img src="<?php echo htmlspecialchars($evenement['image']); ?>" alt="<?php echo htmlspecialchars($evenement['nom']); ?>">
                    <h3><?php echo htmlspecialchars($evenement['nom']); ?></h3>
                    <p><?php echo htmlspecialchars($evenement['description']); ?></p>
                    <p><strong>Date :</strong> <?php echo htmlspecialchars($evenement['date_debut']); ?> - <?php echo htmlspecialchars($evenement['date_fin']); ?></p>
                    <a href="#" class="btn">Participer</a>
                    <a href="#" class="btn">Lire plus</a>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
