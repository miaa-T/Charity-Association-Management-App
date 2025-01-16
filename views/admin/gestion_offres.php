<?php
session_start();

// Redirection si l'administrateur n'est pas connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: login_kjhsfblzqiuhrqbli.php'); // Rediriger vers la page de connexion
    exit();
}

require_once __DIR__ . '/../../controllers/RemisesController.php';
require_once __DIR__ . '/../../models/HistoriqueAdmin.php';
$database = new Database();
$db = $database->connect();

$remisesController = new RemisesController($db);
$historiqueAdminModel = new HistoriqueAdmin($db);

$error = '';
$success = '';

// Gestion des actions (création, modification, suppression)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $id = $_POST['id'] ?? null;

        switch ($_POST['action']) {
            case 'create':
                $nom = $_POST['nom'];
                $description = $_POST['description'];
                $type_remise = $_POST['type_remise'];
                $valeur_remise = $_POST['valeur_remise'];
                $expire_le = $_POST['expire_le'];
                $id_partenaire = $_POST['id_partenaire'];
                $id_categorie = $_POST['id_categorie'];

                // Ajouter la remise
                if ($remisesController->createRemise($nom, $description, $type_remise, $valeur_remise, $expire_le, $id_partenaire, $id_categorie)) {
                    // Enregistrer l'action dans l'historique
                    $historiqueAdminModel->id_administrateur = $_SESSION['admin_id'];
                    $historiqueAdminModel->type_action = 'Création';
                    $historiqueAdminModel->table_concernee = 'remises';
                    $historiqueAdminModel->id_enregistrement = $id; // ID de la nouvelle remise
                    $historiqueAdminModel->details = "Création de la remise : $nom";
                    $historiqueAdminModel->create();

                    $success = "Remise créée avec succès!";
                } else {
                    $error = "Erreur lors de la création de la remise.";
                }
                break;

            case 'update':
                $nom = $_POST['nom'];
                $description = $_POST['description'];
                $type_remise = $_POST['type_remise'];
                $valeur_remise = $_POST['valeur_remise'];
                $expire_le = $_POST['expire_le'];
                $id_partenaire = $_POST['id_partenaire'];
                $id_categorie = $_POST['id_categorie'];

                // Mettre à jour la remise
                if ($remisesController->updateRemise($id, $nom, $description, $type_remise, $valeur_remise, $expire_le, $id_partenaire, $id_categorie)) {
                    // Enregistrer l'action dans l'historique
                    $historiqueAdminModel->id_administrateur = $_SESSION['admin_id'];
                    $historiqueAdminModel->type_action = 'Modification';
                    $historiqueAdminModel->table_concernee = 'remises';
                    $historiqueAdminModel->id_enregistrement = $id;
                    $historiqueAdminModel->details = "Modification de la remise ID $id : $nom";
                    $historiqueAdminModel->create();

                    $success = "Remise mise à jour avec succès!";
                } else {
                    $error = "Erreur lors de la mise à jour de la remise.";
                }
                break;

            case 'delete':
                // Supprimer la remise
                if ($remisesController->deleteRemise($id)) {
                    // Enregistrer l'action dans l'historique
                    $historiqueAdminModel->id_administrateur = $_SESSION['admin_id'];
                    $historiqueAdminModel->type_action = 'Suppression';
                    $historiqueAdminModel->table_concernee = 'remises';
                    $historiqueAdminModel->id_enregistrement = $id;
                    $historiqueAdminModel->details = "Suppression de la remise ID $id";
                    $historiqueAdminModel->create();

                    $success = "Remise supprimée avec succès!";
                } else {
                    $error = "Erreur lors de la suppression de la remise.";
                }
                break;
        }
    }
}

// Récupérer toutes les remises
$remises = $remisesController->getAllRemises();
 require_once 'header.php'; ?>


    <div class="container mt-5">
        <h1 class="mb-4">Gestion des Offres</h1>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <!-- Formulaire de création berk, -->
      <!-- Formulaire de création -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Ajouter une Offre</h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="type_remise" class="form-label">Type de Remise</label>
                <select class="form-control" id="type_remise" name="type_remise" required>
                    <option value="permanente">Permanente</option>
                    <option value="limitee">Limitée</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="valeur_remise" class="form-label">Valeur de la Remise</label>
                <input type="text" class="form-control" id="valeur_remise" name="valeur_remise" required>
            </div>
            <div class="mb-3">
                <label for="expire_le" class="form-label">Date d'expiration (si limitée)</label>
                <input type="date" class="form-control" id="expire_le" name="expire_le">
            </div>
            <div class="mb-3">
                <label for="id_partenaire" class="form-label">ID Partenaire</label>
                <input type="number" class="form-control" id="id_partenaire" name="id_partenaire" required>
            </div>
            <div class="mb-3">
                <label for="id_categorie" class="form-label">ID Catégorie</label>
                <input type="number" class="form-control" id="id_categorie" name="id_categorie" required>
            </div>
            <button type="submit" name="action" value="create" class="btn btn-primary">Créer</button>
        </form>
    </div>
</div>
        <!-- Liste des offres -->
  <!-- Liste des offres -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Liste des Offres</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Valeur</th>
                        <th>Expiration</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($remises as $remise): ?>
                        <tr>
                            <td><?php echo $remise['id']; ?></td>
                            <td><?php echo $remise['nom']; ?></td>
                            <td><?php echo $remise['description']; ?></td>
                            <td><?php echo $remise['type_remise']; ?></td>
                            <td><?php echo $remise['valeur_remise']; ?></td>
                            <td><?php echo $remise['expire_le']; ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $remise['id']; ?>">
                                    <button type="submit" name="action" value="delete" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                                <button class="btn btn-sm btn-warning" onclick="showUpdateForm(
                                    <?php echo $remise['id']; ?>,
                                    '<?php echo $remise['nom']; ?>',
                                    '<?php echo $remise['description']; ?>',
                                    '<?php echo $remise['type_remise']; ?>',
                                    '<?php echo $remise['valeur_remise']; ?>',
                                    '<?php echo $remise['expire_le']; ?>',
                                    <?php echo $remise['id_partenaire']; ?>,
                                    <?php echo $remise['id_categorie']; ?>
                                )">Modifier</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Formulaire de modification (caché par défaut ghir whenn i click on modifier ) -->
<div class="card mb-4" id="updateForm" style="display: none;">
    <div class="card-header">
        <h5 class="mb-0">Modifier une Offre</h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="id" id="update_id">
            <div class="mb-3">
                <label for="update_nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="update_nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="update_description" class="form-label">Description</label>
                <textarea class="form-control" id="update_description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="update_type_remise" class="form-label">Type de Remise</label>
                <select class="form-control" id="update_type_remise" name="type_remise" required>
                    <option value="permanente">Permanente</option>
                    <option value="limitee">Limitée</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="update_valeur_remise" class="form-label">Valeur de la Remise</label>
                <input type="text" class="form-control" id="update_valeur_remise" name="valeur_remise" required>
            </div>
            <div class="mb-3">
                <label for="update_expire_le" class="form-label">Date d'expiration (si limitée)</label>
                <input type="date" class="form-control" id="update_expire_le" name="expire_le">
            </div>
            <div class="mb-3">
                <label for="update_id_partenaire" class="form-label">ID Partenaire</label>
                <input type="number" class="form-control" id="update_id_partenaire" name="id_partenaire" required>
            </div>
            <div class="mb-3">
                <label for="update_id_categorie" class="form-label">ID Catégorie</label>
                <input type="number" class="form-control" id="update_id_categorie" name="id_categorie" required>
            </div>
            <button type="submit" name="action" value="update" class="btn btn-warning">Mettre à jour</button>
            <button type="button" onclick="hideUpdateForm()" class="btn btn-secondary">Annuler</button>
        </form>
    </div>
</div>
    <script>
        // Fonction pour remplir le formulaire avec les données de la remise à modifier
        function editRemise(id, nom, description, type_remise, valeur_remise, expire_le, id_partenaire, id_categorie) {
            document.getElementById('remise_id').value = id;
            document.getElementById('nom').value = nom;
            document.getElementById('description').value = description;
            document.getElementById('type_remise').value = type_remise;
            document.getElementById('valeur_remise').value = valeur_remise;
            document.getElementById('expire_le').value = expire_le;
            document.getElementById('id_partenaire').value = id_partenaire;
            document.getElementById('id_categorie').value = id_categorie;
        }
        function showUpdateForm(id, nom, description, type_remise, valeur_remise, expire_le, id_partenaire, id_categorie) {
        document.getElementById('updateForm').style.display = 'block';
        document.getElementById('update_id').value = id;
        document.getElementById('update_nom').value = nom;
        document.getElementById('update_description').value = description;
        document.getElementById('update_type_remise').value = type_remise;
        document.getElementById('update_valeur_remise').value = valeur_remise;
        document.getElementById('update_expire_le').value = expire_le;
        document.getElementById('update_id_partenaire').value = id_partenaire;
        document.getElementById('update_id_categorie').value = id_categorie;
    }

    // Masquer le formulaire de modification
    function hideUpdateForm() {
        document.getElementById('updateForm').style.display = 'none';
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
