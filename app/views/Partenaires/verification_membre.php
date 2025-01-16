<?php
session_start();

if (!isset($_SESSION['partenaire_id'])) {
    header("Location: login_partenaire.php");
    exit();
}

require_once __DIR__ . '/../../controllers/MembresController.php';
require_once __DIR__ . '/../../controllers/RemisesController.php';
require_once __DIR__ . '/../../controllers/TypeAbonnementController.php';

$database = new Database();
$db = $database->connect();
$membresController = new MembreController();
$remisesController = new RemisesController();
$typeAbonnementController = new TypeAbonnementController();
$membre = null;
$remisesDisponibles = [];
$message = '';
// Vérifier si un identifiant de membre a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['membre_id'])) {
    $membreId = htmlspecialchars($_POST['membre_id']);

    // Récupérer les informations du membre
    $membre = $membresController->getMemberById($membreId);

    if ($membre) {
        // Récupérer les offres disponibles pour le type de carte du membre
        $typeCarte = $membre['nom_type_abonnement'];
        $remisesDisponibles = $remisesController->getRemisesByTypeCarte($typeCarte);
    } else {
        $message = "Aucun membre trouvé avec cet identifiant.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification Membre</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="verification-container">
        <h2>Vérification des Membres</h2>
        <form action="verification_membre.php" method="POST">
            <label for="membre_id">Identifiant du Membre:</label>
            <input type="text" id="membre_id" name="membre_id" required>
            <button type="submit">Vérifier</button>
        </form>

        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <?php if ($message): ?>
            <p class="error"><?php echo $message; ?></p>
        <?php endif; ?>

        <!-- Afficher les informations du membre et les offres disponibles -->
        <?php if ($membre): ?>
            <div class="membre-info">
                <h2>Informations du membre</h2>
                <p><strong>Nom complet :</strong> <?php echo htmlspecialchars($membre['prenom'] . ' ' . $membre['nom']); ?></p>
                <p><strong>Identifiant :</strong> <?php echo htmlspecialchars($membre['id']); ?></p>
                <p><strong>Type de carte :</strong> <?php echo htmlspecialchars($membre['nom_type_abonnement']); ?></p>
                <p><strong>Date d'expiration :</strong> <?php echo htmlspecialchars($membre['date_expiration']); ?></p>
            </div>

            <div class="remises-disponibles">
                <h2>Offres disponibles pour ce type de carte</h2>
                <?php if (!empty($remisesDisponibles)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom de l'offre</th>
                                <th>Partenaire</th>
                                <th>Valeur de la remise</th>
                                <th>Type de remise</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($remisesDisponibles as $remise): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($remise['nom']); ?></td>
                                    <td><?php echo htmlspecialchars($remise['partenaire_nom']); ?></td>
                                    <td><?php echo htmlspecialchars($remise['valeur_remise']); ?></td>
                                    <td><?php echo htmlspecialchars($remise['type_remise']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucune offre disponible pour ce type de carte.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>