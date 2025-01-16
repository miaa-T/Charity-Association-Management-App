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
        $this->aide = new Aide($db); 
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
            $numero_telephone = $_POST['numero_telephone'];
    
            // Handle file upload
            $fichier = null;
            if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../uploads/'; // Directory to save files
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
                }
                $fileName = basename($_FILES['fichier']['name']);
                $filePath = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['fichier']['tmp_name'], $filePath)) {
                    $fichier = $filePath; // Store the file path
                }
            }
    
            // Set the properties in the DemandeAide model
            $this->demandeAide->nom = $nom;
            $this->demandeAide->prenom = $prenom;
            $this->demandeAide->date_naissance = $date_naissance;
            $this->demandeAide->type_aide = $type_aide;
            $this->demandeAide->description = $description;
            $this->demandeAide->fichier = $fichier;
            $this->demandeAide->numero_identite = $numero_identite;
            $this->demandeAide->numero_telephone = $numero_telephone;
    
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


    // Supprimer une demande d'aide
    public function supprimerDemandeAide($id) {
        return $this->demandeAide->supprimer($id);
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