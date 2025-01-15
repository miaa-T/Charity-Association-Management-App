<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Inclure les fichiers nécessaires
require_once __DIR__ . '/../controllers/MembreController.php';

// Initialiser le contrôleur
$membreController = new MembreController();

// Récupérer l'ID de l'utilisateur connecté
$userId = $_SESSION['user_id'];

// Récupérer les données du formulaire
$prenom = htmlspecialchars($_POST['prenom']);
$nom = htmlspecialchars($_POST['nom']);
$email = htmlspecialchars($_POST['email']);
$telephone = htmlspecialchars($_POST['telephone']);

// Gérer le téléchargement de la photo de profil
$photo = null;
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $targetDir = __DIR__ . "/../uploads/photos/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
    $targetFile = $targetDir . $fileName;
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
        $photo = $targetFile;
    }
}

// Préparer les données à mettre à jour
$updateData = [
    'prenom' => $prenom,
    'nom' => $nom,
    'email' => $email,
    'telephone' => $telephone,
    'photo' => $photo
];

// Mettre à jour les informations du membre
if ($membreController->updateMember($userId, $updateData)) {
    // Rediriger vers la page de profil avec un message de succès
    $_SESSION['success_message'] = "Vos informations ont été mises à jour avec succès.";
    header("Location: monprofile.php");
    exit();
} else {
    // Rediriger vers la page de profil avec un message d'erreur
    $_SESSION['error_message'] = "Une erreur s'est produite lors de la mise à jour de vos informations.";
    header("Location: monprofile.php");
    exit();
}