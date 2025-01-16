<?php
require_once __DIR__ . '/../../models/Membre.php';
require_once __DIR__ . '/../../models/db.php';

// Check if ID is provided
if (!isset($_GET['id'])) {
    die('ID du membre non fourni.');
}

$database = new Database();
$db = $database->connect();

$membreModel = new Membre($db);
$memberId = $_GET['id'];

// Fetch member details
$member = $membreModel->getMemberById($memberId);

if ($member) {
    // Display member details
    echo "<p><strong>Prénom:</strong> " . htmlspecialchars($member['prenom']) . "</p>";
    echo "<p><strong>Nom:</strong> " . htmlspecialchars($member['nom']) . "</p>";
    echo "<p><strong>Email:</strong> " . htmlspecialchars($member['email']) . "</p>";
    echo "<p><strong>Téléphone:</strong> " . htmlspecialchars($member['telephone']) . "</p>";
    echo "<p><strong>Adresse:</strong> " . htmlspecialchars($member['adresse']) . "</p>";
    echo "<p><strong>Type d'abonnement:</strong> " . htmlspecialchars($member['nom_type_abonnement']) . "</p>";
    echo "<p><strong>Date d'inscription:</strong> " . htmlspecialchars($member['date_inscription']) . "</p>";
    echo "<p><strong>Date d'expiration:</strong> " . htmlspecialchars($member['date_expiration']) . "</p>";
    echo "<p><strong>Statut:</strong> " . htmlspecialchars($member['statut']) . "</p>";
} else {
    echo "Membre non trouvé.";
}
?>