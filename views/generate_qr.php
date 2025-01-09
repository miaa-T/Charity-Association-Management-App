<?php
// generate_qr.php

// Include the library
require_once('phpqrcode/qrlib.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    header('Content-Type: image/png');
    
    // Parameters:
    // 1. false = output directly to browser
    // 2. QR_ECLEVEL_L = Error Correction Level (L = Low, M = Medium, Q = Quarter, H = High)
    // 3. 10 = size (1 to 50)
    // 4. 2 = margin (0 to 10)
    QRcode::png($id, false, QR_ECLEVEL_L, 10, 2);
    
} else {
    header('HTTP/1.1 400 Bad Request');
    echo 'Missing ID parameter';
}
?>