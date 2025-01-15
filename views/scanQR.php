<?php
// Récupérer l'ID du membre depuis le QR Code scanné
$memberId = $_GET['member_id']; // Supposons que l'ID est passé en paramètre

// Inclure le contrôleur Membre
require_once __DIR__ . '/../controllers/MembreController.php';
$membreController = new MembreController();

// Récupérer les informations du membre
$membre = $membreController->getMemberById($memberId);

if ($membre) {
    echo "Nom du membre : " . htmlspecialchars($membre['prenom'] . ' ' . $membre['nom']);
    echo "Type d'abonnement : " . htmlspecialchars($membre['nom_type_abonnement']);
    echo "Date d'expiration : " . htmlspecialchars($membre['date_expiration']);
} else {
    echo "Membre non trouvé.";
}
?>