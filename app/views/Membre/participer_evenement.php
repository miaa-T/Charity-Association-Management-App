<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

require_once __DIR__ . '/../models/Benevolat.php';
require_once __DIR__ . '/../models/db.php';

// Récupérer l'ID de l'événement depuis l'URL
if (!isset($_GET['evenement_id'])) {
    die("ID de l'événement manquant.");
}
$evenement_id = $_GET['evenement_id'];

// Connexion à la base de données
$database = new Database();
$conn = $database->connect();

// Créer une instance de Benevolat
$benevole = new Benevolat($conn);
$benevole->id_membre = $_SESSION['user_id']; // ID du membre connecté
$benevole->evenement_id = $evenement_id; // ID de l'événement
$benevole->id_statut_benevolat = 1; // Statut par défaut (1 = Inscrit)

// Enregistrer la participation
if ($benevole->create()) {
    echo "Votre participation à l'événement a été enregistrée avec succès. Merci pour votre engagement !";
} else {
    echo "Une erreur s'est produite lors de l'enregistrement de votre participation.";
}
?>