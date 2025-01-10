<?php
require_once __DIR__ . '/../models/Don.php';
require_once __DIR__ . '/../models/db.php';

class DonController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function createDon() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Instancier la classe Don
            $don = new Don($this->conn);

            // Récupérer les données du formulaire
            $don->id_membre = $_SESSION['user_id'] ?? null; // ID du membre connecté (si applicable)
            $don->montant = $_POST['montant'];
            $don->date_don = date('Y-m-d'); // Date actuelle
            $don->statut = 'En attente'; // Statut par défaut

            // Gérer le fichier téléversé (reçu)
            if (isset($_FILES['recu']) && $_FILES['recu']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../uploads/receipts/';

                // Vérifier si le dossier existe, sinon le créer
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true); // Crée le dossier avec les permissions 0755
                }

                // Générer un nom de fichier unique pour éviter les conflits
                $fileName = uniqid() . '_' . basename($_FILES['recu']['name']);
                $uploadFile = $uploadDir . $fileName;

                // Déplacer le fichier téléversé
                if (move_uploaded_file($_FILES['recu']['tmp_name'], $uploadFile)) {
                    $don->recu = $uploadFile;
                } else {
                    echo "Erreur lors du téléversement du fichier. Veuillez réessayer.";
                    exit;
                }
            } else {
                echo "Veuillez téléverser un reçu valide.";
                exit;
            }

            // Créer le don dans la base de données
            if ($don->create()) {
                echo "Votre don a été enregistré avec succès. Merci pour votre générosité !";
            } else {
                echo "Une erreur s'est produite lors de l'enregistrement de votre don.";
            }
        }
    }

    public function getUserDonations($userId) {
        $query = "SELECT id, montant, date_don, statut, recu 
                  FROM dons 
                  WHERE id_membre = :id_membre 
                  ORDER BY date_don DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_membre', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Traitement de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $donController = new DonController();
    $donController->createDon();
}
?>