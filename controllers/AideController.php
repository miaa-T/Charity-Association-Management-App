<?php
require_once __DIR__ . '/../models/Aide.php';
require_once __DIR__ . '/../models/DemandeAide.php';
require_once __DIR__ . '/../models/db.php';

class AideController {
    private $aide;
    private $demandeAide;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->aide = new Aide($db); // For types_aide
        $this->demandeAide = new DemandeAide($db); // For demandes_aides
    }

    // Get all types of aid (from types_aide table)
    public function getTypesAide() {
        $result = $this->aide->lire();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Handle assistance request submission (for demandes_aides table)
    public function handleAssistanceRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve form data
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $date_naissance = $_POST['date_naissance'];
            $type_aide = $_POST['type_aide'];
            $description = $_POST['description'];
            $numero_identite = $_POST['numero_identite'];

            // Handle file upload
            $fichier = null;
            if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
                $fichier = file_get_contents($_FILES['fichier']['tmp_name']);
            }

            // Set the properties in the DemandeAide model
            $this->demandeAide->nom = $nom;
            $this->demandeAide->prenom = $prenom;
            $this->demandeAide->date_naissance = $date_naissance;
            $this->demandeAide->type_aide = $type_aide;
            $this->demandeAide->description = $description;
            $this->demandeAide->fichier = $fichier;
            $this->demandeAide->numero_identite = $numero_identite;

            // Create the assistance request
            if ($this->demandeAide->creer()) {
                echo json_encode(['success' => true, 'message' => 'Demande d\'aide soumise avec succès!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la soumission de la demande d\'aide.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Méthode de requête non valide.']);
        }
    }

    // Get all assistance requests (from demandes_aides table)
    public function getDemandesAide() {
        $result = $this->demandeAide->lire();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Handle the action
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $controller = new AideController();

    if ($action === 'handleAssistanceRequest') {
        $controller->handleAssistanceRequest();
    } elseif ($action === 'getTypesAide') {
        $typesAide = $controller->getTypesAide();
        echo json_encode($typesAide);
    } elseif ($action === 'getDemandesAide') {
        $demandesAide = $controller->getDemandesAide();
        echo json_encode($demandesAide);
    }
}
?>