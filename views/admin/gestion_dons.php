<?php
require_once 'config.php';
require_once __DIR__ . '/../../models/Don.php';
require_once __DIR__ . '/../../models/Benevolat.php';

$database = new Database();
$db = $database->connect();

$error = '';
$success = '';

// Instancier les modèles
$donModel = new Don($db);
$benevolatModel = new Benevolat($db);

// Gestion des actions (validation, rejet, suppression)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $id = $_POST['id'];

        switch ($_POST['action']) {
            case 'validate_don':
                if ($donModel->validate($id)) {
                    $success = "Don validé avec succès!";
                } else {
                    $error = "Erreur lors de la validation du don.";
                }
                break;

            case 'reject_don':
                if ($donModel->reject($id)) {
                    $success = "Don rejeté avec succès!";
                } else {
                    $error = "Erreur lors du rejet du don.";
                }
                break;

            case 'delete_don':
                if ($donModel->delete($id)) {
                    $success = "Don supprimé avec succès!";
                } else {
                    $error = "Erreur lors de la suppression du don.";
                }
                break;

            case 'delete_benevolat':
                if ($benevolatModel->delete($id)) {
                    $success = "Bénévolat supprimé avec succès!";
                } else {
                    $error = "Erreur lors de la suppression du bénévolat.";
                }
                break;
        }
    }
}

// Récupérer les dons et bénévolats
$dons = $donModel->read()->fetchAll(PDO::FETCH_ASSOC);
$benevoles = $benevolatModel->read()->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les statistiques
$donStats = $donModel->getStats();
$benevolatStats = $benevolatModel->getStats();
?>

<?php require_once 'header.php'; ?>

<div class="container-fluid content">
    <h1 class="h3 mb-4">Gestion des Dons et Bénévolats</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistiques des Dons</h5>
                </div>
                <div class="card-body">
                    <p>Total des dons : <?php echo $donStats['total_dons']; ?></p>
                    <p>Montant total : <?php echo $donStats['total_montant']; ?> €</p>
                    <p>Moyenne des dons : <?php echo $donStats['moyenne_montant']; ?> €</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistiques des Bénévolats</h5>
                </div>
                <div class="card-body">
                    <p>Total des bénévolats : <?php echo $benevolatStats['total_benevoles']; ?></p>
                    <p>Total des membres impliqués : <?php echo $benevolatStats['total_membres']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des dons -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Liste des Dons</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Membre</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dons as $don): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($don['prenom'] . ' ' . $don['nom']); ?></td>
                                <td><?php echo $don['montant']; ?> €</td>
                                <td><?php echo $don['date_don']; ?></td>
                                <td><?php echo $don['statut']; ?></td>
                                <td>
                                    <?php if ($don['statut'] === 'En attente'): ?>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?php echo $don['id']; ?>">
                                            <button type="submit" name="action" value="validate_don" class="btn btn-sm btn-success">Valider</button>
                                            <button type="submit" name="action" value="reject_don" class="btn btn-sm btn-danger">Rejeter</button>
                                        </form>
                                    <?php endif; ?>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $don['id']; ?>">
                                        <button type="submit" name="action" value="delete_don" class="btn btn-sm btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Liste des bénévolats -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Liste des Bénévolats</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Membre</th>
                            <th>Événement</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($benevoles as $benevole): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($benevole['prenom'] . ' ' . $benevole['nom']); ?></td>
                                <td><?php echo htmlspecialchars($benevole['evenement']); ?></td>
                                <td><?php echo htmlspecialchars($benevole['statut']); ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $benevole['id']; ?>">
                                        <button type="submit" name="action" value="delete_benevolat" class="btn btn-sm btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>