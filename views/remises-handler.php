<?php
require_once __DIR__ . '/../controllers/RemisesController.php';

// Get the search and filter parameters
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$type = $_GET['type'] ?? '';

// Initialize the controller and fetch the results
$controller = new RemisesController();
$remises = $controller->getFilteredRemises($search, $category, $type);

// Generate the HTML for the results
?>
<div class="results-container">
    <?php if (!empty($remises)): ?>
        <div class="remises-container">
            <?php foreach ($remises as $remise): ?>
                <div class="remise-card">
                    <h4><?= htmlspecialchars($remise['nom']); ?></h4>
                    <p>Partenaire: <?= htmlspecialchars($remise['partenaire_nom'] ?? 'N/A'); ?></p>
                    <p>Type: <?= htmlspecialchars($remise['type_remise']); ?></p>
                    <p>Valeur: <?= htmlspecialchars($remise['valeur_remise']); ?></p>
                    <p>Description: <?= htmlspecialchars($remise['description']); ?></p>
                    <?php if ($remise['type_remise'] === 'limitee'): ?>
                        <p>Expire le: <?= htmlspecialchars($remise['expire_le']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No results found for your search and filter criteria.</p>
    <?php endif; ?>
</div>
