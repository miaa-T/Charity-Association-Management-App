<?php
session_start(); // Start the session
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name

// Include the controllers
require_once __DIR__ . '/../../controllers/EvenementsActualitesController.php';
require_once __DIR__ . '/../../controllers/RemisesController.php';
require_once __DIR__ . '/../../controllers/MembresController.php'; // Utilisez le bon contrôleur

$controller = new EvenementsActualitesController();
$remisesController = new RemisesController();
$membresController = new MembreController(); // Utilisez le bon contrôleur

// Fetch actualités and événements
$actualites = $controller->getAllActualites();
$evenements = $controller->getAllEvenements();

// Fetch available remises for the logged-in member
$remisesDisponibles = [];
// Récupérer toutes les offres disponibles
$remisesDisponibles = $remisesController->getAllRemises();
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
        <div class="main-content">
       
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

    <section class="news-page">
        <!-- Display Actualités -->
        <h2>Actualités</h2>
        <div class="news-container">
            <?php foreach ($actualites as $actualite): ?>
                <div class="news-card">
                    <img src="<?php echo htmlspecialchars($actualite['image'] ?? ''); ?>" alt="<?php echo htmlspecialchars($actualite['titre'] ?? ''); ?>">
                    <h3><?php echo htmlspecialchars($actualite['titre'] ?? ''); ?></h3>
                    <p><?php echo htmlspecialchars($actualite['description'] ?? ''); ?></p>
                    <!-- Bouton "Lire plus" supprimé -->
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Remises Disponibles Section -->
    <section class="remises-disponibles-section">
        <?php if (!empty($remisesDisponibles)): ?>
            <h2>Offres Disponibles</h2>
            <div class="remises-container">
                <?php foreach ($remisesDisponibles as $remise): ?>
                    <div class="remise-card">
                        <h3><?php echo htmlspecialchars($remise['nom'] ?? ''); ?></h3>
                        <p><strong>Partenaire:</strong> <?php echo htmlspecialchars($remise['partenaire_nom'] ?? ''); ?></p>
                        <p><strong>Valeur de la remise:</strong> <?php echo htmlspecialchars($remise['valeur_remise'] ?? ''); ?></p>
                        <p><strong>Type de remise:</strong> <?php echo htmlspecialchars($remise['type_remise'] ?? ''); ?></p>
                        <!-- Bouton "Plus d’infos" supprimé -->
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucune offre disponible pour le moment.</p>
        <?php endif; ?>

        <!-- Message pour les utilisateurs non connectés -->
        <?php if (!isset($_SESSION['user_id'])): ?>
            <p class="login-prompt">
                <a href="login.php">Connectez-vous</a> pour bénéficier de ces offres et avantages exclusifs !
            </p>
        <?php endif; ?>
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
 </div>
    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>