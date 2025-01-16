<?php
require_once __DIR__ . '/../models/Don.php';
require_once __DIR__ . '/../models/Benevolat.php';
require_once __DIR__ . '/../models/HistoriqueAdmin.php';
require_once __DIR__ . '/../models/db.php';

session_start();

$database = new Database();
$db = $database->connect();

$donModel = new Don($db);
$benevolatModel = new Benevolat($db);
$historiqueAdminModel = new HistoriqueAdmin($db);

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $id = $_POST['id'];

        switch ($_POST['action']) {
            case 'validate_don':
                if ($donModel->validate($id)) {
                    // Enregistrer l'action dans l'historique
                    $historiqueAdminModel->id_administrateur = $_SESSION['admin_id'];
                    $historiqueAdminModel->type_action = 'Modification';
                    $historiqueAdminModel->table_concernee = 'dons';
                    $historiqueAdminModel->id_enregistrement = $id;
                    $historiqueAdminModel->details = "Validation du don ID $id";
                    $historiqueAdminModel->create();

                    $success = "Don validé avec succès!";
                } else {
                    $error = "Erreur lors de la validation du don.";
                }
                break;

            case 'reject_don':
                if ($donModel->reject($id)) {
                    // Enregistrer l'action dans l'historique
                    $historiqueAdminModel->id_administrateur = $_SESSION['admin_id'];
                    $historiqueAdminModel->type_action = 'Modification';
                    $historiqueAdminModel->table_concernee = 'dons';
                    $historiqueAdminModel->id_enregistrement = $id;
                    $historiqueAdminModel->details = "Rejet du don ID $id";
                    $historiqueAdminModel->create();

                    $success = "Don rejeté avec succès!";
                } else {
                    $error = "Erreur lors du rejet du don.";
                }
                break;

            case 'delete_don':
                if ($donModel->delete($id)) {
                    // Enregistrer l'action dans l'historique
                    $historiqueAdminModel->id_administrateur = $_SESSION['admin_id'];
                    $historiqueAdminModel->type_action = 'Suppression';
                    $historiqueAdminModel->table_concernee = 'dons';
                    $historiqueAdminModel->id_enregistrement = $id;
                    $historiqueAdminModel->details = "Suppression du don ID $id";
                    $historiqueAdminModel->create();

                    $success = "Don supprimé avec succès!";
                } else {
                    $error = "Erreur lors de la suppression du don.";
                }
                break;

            case 'delete_benevolat':
                if ($benevolatModel->delete($id)) {
                    // Enregistrer l'action dans l'historique
                    $historiqueAdminModel->id_administrateur = $_SESSION['admin_id'];
                    $historiqueAdminModel->type_action = 'Suppression';
                    $historiqueAdminModel->table_concernee = 'benevoles';
                    $historiqueAdminModel->id_enregistrement = $id;
                    $historiqueAdminModel->details = "Suppression du bénévolat ID $id";
                    $historiqueAdminModel->create();

                    $success = "Bénévolat supprimé avec succès!";
                } else {
                    $error = "Erreur lors de la suppression du bénévolat.";
                }
                break;

            case 'approve_benevolat':
                if ($benevolatModel->approve($id)) {
                    // Enregistrer l'action dans l'historique
                    $historiqueAdminModel->id_administrateur = $_SESSION['admin_id'];
                    $historiqueAdminModel->type_action = 'Modification';
                    $historiqueAdminModel->table_concernee = 'benevoles';
                    $historiqueAdminModel->id_enregistrement = $id;
                    $historiqueAdminModel->details = "Approbation du bénévolat ID $id";
                    $historiqueAdminModel->create();

                    $success = "Bénévolat approuvé avec succès!";
                } else {
                    $error = "Erreur lors de l'approbation du bénévolat.";
                }
                break;

            case 'complete_benevolat':
                if ($benevolatModel->complete($id)) {
                    // Enregistrer l'action dans l'historique
                    $historiqueAdminModel->id_administrateur = $_SESSION['admin_id'];
                    $historiqueAdminModel->type_action = 'Modification';
                    $historiqueAdminModel->table_concernee = 'benevoles';
                    $historiqueAdminModel->id_enregistrement = $id;
                    $historiqueAdminModel->details = "Finalisation du bénévolat ID $id";
                    $historiqueAdminModel->create();

                    $success = "Bénévolat marqué comme terminé avec succès!";
                } else {
                    $error = "Erreur lors de la mise à jour du statut du bénévolat.";
                }
                break;
        }
    }
}

// Récupérer les dons, bénévolats et l'historique
$dons = $donModel->read()->fetchAll(PDO::FETCH_ASSOC);
$benevoles = $benevolatModel->read()->fetchAll(PDO::FETCH_ASSOC);
$historique = $historiqueAdminModel->read()->fetchAll(PDO::FETCH_ASSOC);
?>