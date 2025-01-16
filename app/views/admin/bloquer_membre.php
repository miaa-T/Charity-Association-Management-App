<?php
require_once __DIR__ . '/../../models/Membre.php';
require_once __DIR__ . '/../../models/db.php';

// Vérifier si l'ID et le statut sont fournis
if (!isset($_POST['id']) || !isset($_POST['statut'])) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes.']);
    exit;
}

$database = new Database();
$db = $database->connect();

$membreModel = new Membre($db);
$memberId = $_POST['id'];
$statut = $_POST['statut'];

// Si on débloque un membre, définir son statut sur "En attente"
if ($statut === 'Approuvé' || $statut === 'Rejeté') {
    $statut = 'En attente';
}

// Mettre à jour le statut du membre
$query = "UPDATE membres SET statut = :statut WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $memberId);
$stmt->bindParam(':statut', $statut);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour.']);
}
?>