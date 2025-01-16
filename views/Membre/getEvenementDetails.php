<?php
require_once __DIR__ . '/../../models/Evenement.php';
require_once __DIR__ . '/../../models/db.php';

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID de l\'événement manquant']);
    exit();
}

$evenementId = $_GET['id'];

$database = new Database();
$conn = $database->connect();

$evenement = new Evenement($conn);
$evenement->id = $evenementId;

$stmt = $evenement->read();
$evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($evenements as $event) {
    if ($event['id'] == $evenementId) {
        echo json_encode($event);
        exit();
    }
}

echo json_encode(['error' => 'Événement non trouvé']);
?>