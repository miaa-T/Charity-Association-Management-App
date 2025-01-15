<?php
require_once __DIR__ . '/../../controllers/PartenairesController.php';

if (isset($_GET['id'])) {
    $controller = new PartenaireController();
    $partenaire = $controller->getPartnerById($_GET['id']);

    if ($partenaire) {
        header('Content-Type: application/json');
        echo json_encode($partenaire);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Partenaire non trouvé']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID du partenaire manquant']);
}
?>