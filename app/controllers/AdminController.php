<?php
namespace App\Controllers;

use App\Core\Controller;
require_once __DIR__ . '/../models/Don.php';
require_once __DIR__ . '/../models/Benevolat.php';
require_once __DIR__ . '/../models/HistoriqueAdmin.php';
require_once __DIR__ . '/../models/db.php';
require_once __DIR__ . '/../core/Controller.php';

class AdminController extends Controller {
    private $donModel;
    private $benevolatModel;
    private $historiqueAdminModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();

        $this->donModel = new Don($db);
        $this->benevolatModel = new Benevolat($db);
        $this->historiqueAdminModel = new HistoriqueAdmin($db);
    }

    public function index() {
        session_start();

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                $id = $_POST['id'];

                switch ($_POST['action']) {
                    case 'validate_don':
                        if ($this->donModel->validate($id)) {
                            $this->logAdminAction('Modification', 'dons', $id, "Validation du don ID $id");
                            $success = "Don validé avec succès!";
                        } else {
                            $error = "Erreur lors de la validation du don.";
                        }
                        break;

                    case 'reject_don':
                        if ($this->donModel->reject($id)) {
                            $this->logAdminAction('Modification', 'dons', $id, "Rejet du don ID $id");
                            $success = "Don rejeté avec succès!";
                        } else {
                            $error = "Erreur lors du rejet du don.";
                        }
                        break;

                    case 'delete_don':
                        if ($this->donModel->delete($id)) {
                            $this->logAdminAction('Suppression', 'dons', $id, "Suppression du don ID $id");
                            $success = "Don supprimé avec succès!";
                        } else {
                            $error = "Erreur lors de la suppression du don.";
                        }
                        break;

                    case 'delete_benevolat':
                        if ($this->benevolatModel->delete($id)) {
                            $this->logAdminAction('Suppression', 'benevoles', $id, "Suppression du bénévolat ID $id");
                            $success = "Bénévolat supprimé avec succès!";
                        } else {
                            $error = "Erreur lors de la suppression du bénévolat.";
                        }
                        break;

                    case 'approve_benevolat':
                        if ($this->benevolatModel->approve($id)) {
                            $this->logAdminAction('Modification', 'benevoles', $id, "Approbation du bénévolat ID $id");
                            $success = "Bénévolat approuvé avec succès!";
                        } else {
                            $error = "Erreur lors de l'approbation du bénévolat.";
                        }
                        break;

                    case 'complete_benevolat':
                        if ($this->benevolatModel->complete($id)) {
                            $this->logAdminAction('Modification', 'benevoles', $id, "Finalisation du bénévolat ID $id");
                            $success = "Bénévolat marqué comme terminé avec succès!";
                        } else {
                            $error = "Erreur lors de la mise à jour du statut du bénévolat.";
                        }
                        break;
                }
            }
        }

        // Récupérer les dons, bénévolats et l'historique
        $dons = $this->donModel->read()->fetchAll(PDO::FETCH_ASSOC);
        $benevoles = $this->benevolatModel->read()->fetchAll(PDO::FETCH_ASSOC);
        $historique = $this->historiqueAdminModel->read()->fetchAll(PDO::FETCH_ASSOC);

        // Passer les données à la vue
        $this->view('admin/index', [
            'dons' => $dons,
            'benevoles' => $benevoles,
            'historique' => $historique,
            'error' => $error,
            'success' => $success
        ]);
    }

    private function logAdminAction($typeAction, $tableConcernee, $idEnregistrement, $details) {
        $this->historiqueAdminModel->id_administrateur = $_SESSION['admin_id'];
        $this->historiqueAdminModel->type_action = $typeAction;
        $this->historiqueAdminModel->table_concernee = $tableConcernee;
        $this->historiqueAdminModel->id_enregistrement = $idEnregistrement;
        $this->historiqueAdminModel->details = $details;
        $this->historiqueAdminModel->create();
    }
}
?>