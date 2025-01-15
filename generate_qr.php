<?php
// generate_qr.php

// Inclure la bibliothèque phpQRCode
require_once __DIR__ . '/lib/phpqrcode/qrlib.php';

// Vérifier si l'ID du membre est passé en paramètre
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Récupérer l'ID du membre depuis l'URL

    // Définir le type de contenu comme image PNG
    header('Content-Type: image/png');

    // Générer le QR Code avec les paramètres suivants :
    // 1. $id : Le texte à encoder (ici, l'ID du membre)
    // 2. false : Ne pas enregistrer le fichier, mais l'afficher directement
    // 3. QR_ECLEVEL_L : Niveau de correction d'erreur (L = Low)
    // 4. 10 : Taille du QR Code (1 à 50)
    // 5. 2 : Marge autour du QR Code (0 à 10)
    QRcode::png($id, false, QR_ECLEVEL_L, 10, 2);
} else {
    // Si l'ID n'est pas fourni, retourner une erreur 400
    header('HTTP/1.1 400 Bad Request');
    echo 'Missing ID parameter';
}
?>