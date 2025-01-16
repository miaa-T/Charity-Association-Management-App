<?php
session_start(); // Démarrer la session
require_once __DIR__ . '/../models/Benevolat.php';
require_once __DIR__ . '/../models/db.php';

class BenevoleController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function createBenevole() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $id_membre = $_SESSION['user_id']; // ID du membre connecté
            $evenement_id = $_POST['evenement']; // ID de l'événement
            $id_statut_benevolat = 1; // Statut par défaut (1 = Inscrit)

            // Insérer les données dans la table `benevoles`
            $benevole = new Benevolat($this->conn);
            $benevole->id_membre = $id_membre;
            $benevole->evenement_id = $evenement_id;
            $benevole->id_statut_benevolat = $id_statut_benevolat;

            if ($benevole->create()) {
                echo "Votre inscription a été enregistrée avec succès. Merci pour votre engagement !";
            } else {
                echo "Une erreur s'est produite lors de l'enregistrement de votre inscription.";
            }
        }
    }
}

// Traitement de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $benevoleController = new BenevoleController();
    $benevoleController->createBenevole();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $id = $_POST['id'];

        switch ($_POST['action']) {
            // ... autres cas existants ...

            case 'approve_benevolat':
                if ($benevolatModel->approve($id)) {
                    $success = "Bénévolat approuvé avec succès!";
                } else {
                    $error = "Erreur lors de l'approbation du bénévolat.";
                }
                break;

            case 'complete_benevolat':
                if ($benevolatModel->complete($id)) {
                    $success = "Bénévolat marqué comme terminé avec succès!";
                } else {
                    $error = "Erreur lors de la mise à jour du statut du bénévolat.";
                }
                break;
        }
    }
}
?>