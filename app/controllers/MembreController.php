<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Membre;
use App\Models\Database;
require_once __DIR__ . '/../models/Membre.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/EvenementsActualitesController.php'; // Include the EvenementsActualitesController
require_once __DIR__ . '/RemisesController.php'; // Include the RemisesController

class MembreController extends Controller {
    private $membreModel;

    public function __construct() {
        // Create a new Database instance and connect
        $database = new Database();
        $db = $database->connect();

        if ($db === null) {
            die("Database connection failed.");
        }

        // Initialize the Membre model with the database connection
        $this->membreModel = new Membre($db);
    }

    /**
     * Handles the homepage (acceuil) logic.
     */
    public function acceuil() {
        // Fetch data using existing controllers
        $evenementsActualitesController = new EvenementsActualitesController();
        $remisesController = new RemisesController();

        // Fetch actualités, événements, and remises
        $actualites = $evenementsActualitesController->getAllActualites();
        $evenements = $evenementsActualitesController->getAllEvenements();
        $remisesDisponibles = $remisesController->getAllRemises();

        // Load the "acceuil" view and pass data to it
        $this->view('membre/acceuil', [
            'actualites' => $actualites,
            'evenements' => $evenements,
            'remisesDisponibles' => $remisesDisponibles,
        ]);
    }

    /**
     * Handles member registration form submission.
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Debugging: Print the contents of $_POST
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";

            // Check if 'type_carte' is set in $_POST
            if (!isset($_POST['type_carte'])) {
                echo "<script>alert('Erreur : Type de carte d\'abonnement non sélectionné.');</script>";
                return;
            }

            // Validate and sanitize form inputs
            $prenom = htmlspecialchars(strip_tags($_POST['prenom'] ?? ''));
            $nom = htmlspecialchars(strip_tags($_POST['nom'] ?? ''));
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $mot_de_passe = password_hash($_POST['mot_de_passe'] ?? '', PASSWORD_DEFAULT);
            $numero_identite = isset($_POST['numero_identite']) ? htmlspecialchars(strip_tags($_POST['numero_identite'])) : '';
            $telephone = htmlspecialchars(strip_tags($_POST['telephone'] ?? ''));
            $adresse = htmlspecialchars(strip_tags($_POST['adresse_complete'] ?? ''));
            $ville = htmlspecialchars(strip_tags($_POST['ville'] ?? ''));
            $code_postal = htmlspecialchars(strip_tags($_POST['code_postal'] ?? ''));
            $type_carte = htmlspecialchars(strip_tags($_POST['type_carte'] ?? ''));
            $date_naissance = htmlspecialchars(strip_tags($_POST['date_naissance'] ?? ''));

            // Handle file uploads
            $photo_profil = $this->uploadFile('photo_profil');
            $recu_paiement = $this->uploadFile('recu_paiement');

            // Check if all files were uploaded successfully
            if ($photo_profil && $recu_paiement) {
                // Set member properties
                $this->membreModel->prenom = $prenom;
                $this->membreModel->nom = $nom;
                $this->membreModel->email = $email;
                $this->membreModel->mot_de_passe = $mot_de_passe;
                $this->membreModel->numero_identite = $numero_identite;
                $this->membreModel->telephone = $telephone;
                $this->membreModel->adresse = $adresse;
                $this->membreModel->photo = $photo_profil;
                $this->membreModel->recu_paiement = $recu_paiement;
                $this->membreModel->nom_type_abonnement = $type_carte; // Use nom_type_abonnement
                $this->membreModel->date_inscription = date('Y-m-d');
                $this->membreModel->date_expiration = date('Y-m-d', strtotime('+1 year'));
                $this->membreModel->statut = 'En attente'; // Default status

                // Create the member in the database
                if ($this->membreModel->create()) {
                    // Success: Show a popup and redirect to acceuil.php
                    echo "<script>
                        alert('Inscription réussie !');
                        window.location.href = '../views/membre/acceuil.php';
                    </script>";
                    exit();
                } else {
                    // Handle database error
                    echo "<script>alert('Erreur lors de l\'inscription. Veuillez réessayer.');</script>";
                }
            } else {
                // Handle file upload error
                echo "<script>alert('Erreur lors du téléchargement des fichiers. Veuillez vérifier les fichiers et réessayer.');</script>";
            }
        }
    }

    /**
     * Handles file uploads and returns the file path.
     *
     * @param string $fileInputName The name of the file input field.
     * @return string|false The file path if successful, otherwise false.
     */
    private function uploadFile($fileInputName) {
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            // Define the target directory based on the file type
            $targetDir = __DIR__ . "/../uploads/"; // Use absolute path
            switch ($fileInputName) {
                case 'photo_profil':
                    $targetDir .= "photos/";
                    break;
                case 'recu_paiement':
                    $targetDir .= "receipts/";
                    break;
                default:
                    $targetDir .= "other/";
                    break;
            }

            // Ensure the target directory exists
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Generate a unique filename to avoid conflicts
            $fileName = uniqid() . '_' . basename($_FILES[$fileInputName]["name"]);
            $targetFile = $targetDir . $fileName;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
                return $targetFile;
            }
        }
        return false;
    }

    public function getMemberById($id) {
        return $this->membreModel->getMemberById($id);
    }

    public function updateMember($id, $data) {
        // Set member properties
        $this->membreModel->id = $id;
        $this->membreModel->prenom = $data['prenom'];
        $this->membreModel->nom = $data['nom'];
        $this->membreModel->email = $data['email'];
        $this->membreModel->telephone = $data['telephone'];
        $this->membreModel->photo = $data['photo'];

        // Call the update method in the model
        if ($this->membreModel->update()) {
            return true;
        } else {
            // Print SQL errors for debugging
            print_r($this->membreModel->getErrors());
            return false;
        }
    }

    public function setBloque($id, $bloque) {
        return $this->membreModel->setBloque($id, $bloque);
    }
}