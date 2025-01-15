<?php
require_once __DIR__ . '/../../controllers/PartenairesController.php';
require_once __DIR__ . '/../../controllers/RemisesController.php'; 

// Instancier le contrôleur
$controller = new PartenaireController();
$remisesController = new RemisesController();

// Gestion des messages d'erreur et de succès
$error = '';
$success = '';

// Gestion des actions (ajout, modification, suppression)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $data = [
                    'nom' => $_POST['nom'],
                    'id_categorie_partenaire' => $_POST['categorie'],
                    'ville' => $_POST['ville'],
                    'remise' => $_POST['remise'],
                    'details' => $_POST['details'],
                    'logo' => '', // Gérer l'upload du logo si nécessaire
                    'description' => $_POST['description'] ?? '' // Ajout du champ description
                ];

                if ($controller->addPartner($data)) {
                    $success = "Partenaire ajouté avec succès!";
                } else {
                    $error = "Erreur lors de l'ajout du partenaire.";
                }
                break;

                case 'edit':
                    $data = [
                        'id' => $_POST['id'],
                        'nom' => $_POST['nom'],
                        'id_categorie_partenaire' => $_POST['categorie'],
                        'ville' => $_POST['ville'],
                        'remise' => $_POST['remise'],
                        'details' => $_POST['details'],
                        'logo' => '', // Gérer l'upload du logo si nécessaire
                        'description' => $_POST['description'] ?? '' // Ajout du champ description
                    ];
                
                    if ($controller->updatePartner($_POST['id'], $data)) {
                        $success = "Partenaire mis à jour avec succès!";
                    } else {
                        $error = "Erreur lors de la mise à jour du partenaire.";
                    }
                    break;

            case 'delete':
                if ($controller->deletePartner($_POST['id'])) {
                    $success = "Partenaire supprimé avec succès!";
                } else {
                    $error = "Erreur lors de la suppression du partenaire.";
                }
                break;
        }
    }
}
// Vérifier si c'est une requête AJAX pour les statistiques
if (isset($_GET['action']) && $_GET['action'] === 'get_statistiques' && isset($_GET['id_partenaire'])) {
    $remisesController = new RemisesController();
    $id_partenaire = $_GET['id_partenaire'];

    // Récupérer les remises et les utilisations
    $remises = $remisesController->getRemisesByPartenaire($id_partenaire);
    $utilisations = $remisesController->getUtilisationsByPartenaire($id_partenaire);

    // Renvoyer les données au format JSON
    header('Content-Type: application/json');
    echo json_encode([
        'remises' => $remises,
        'utilisations' => $utilisations
    ]);
    exit; // Arrêter l'exécution du script après avoir renvoyé les données
}
// Récupérer les filtres
$ville_filter = $_GET['ville'] ?? '';
$categorie_filter = $_GET['categorie'] ?? '';

// Récupérer les partenaires avec filtres
$partenaires = $controller->getAllPartners($ville_filter, $categorie_filter);

// Récupérer les villes et catégories pour les filtres
$villes = $controller->getAllCities();
$categories = $controller->getAllCategories();
?>

<?php require_once 'header.php'; ?>

<div class="container-fluid content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Gestion des Partenaires</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPartenaireModal">
            <i class="fas fa-plus"></i> Ajouter un partenaire
        </button>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <select name="ville" class="form-select">
                        <option value="">Toutes les villes</option>
                        <?php foreach ($villes as $ville): ?>
                            <option value="<?php echo htmlspecialchars($ville); ?>" <?php echo $ville_filter === $ville ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($ville); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="categorie" class="form-select">
                        <option value="">Toutes les catégories</option>
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?php echo $categorie['id']; ?>" <?php echo $categorie_filter == $categorie['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categorie['nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary">Filtrer</button>
                    <a href="gestion_partenaires.php" class="btn btn-outline-secondary">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des partenaires -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="partenairesTable">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Ville</th>
                            <th>Remise</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($partenaires as $partenaire): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($partenaire['nom']); ?></td>
                                <td><?php echo htmlspecialchars($partenaire['categorie_nom']); ?></td>
                                <td><?php echo htmlspecialchars($partenaire['ville']); ?></td>
                                <td><?php echo $partenaire['remise'] . '%'; ?></td>
                                <td>
    <!-- Bouton pour afficher les statistiques -->
    <button class="btn btn-sm btn-info" onclick="viewStats(<?php echo $partenaire['id']; ?>)">
        <i class="fas fa-chart-bar"></i> Statistiques
    </button>

    <!-- Bouton pour éditer -->
    <button class="btn btn-sm btn-primary" onclick="editPartenaire(<?php echo $partenaire['id']; ?>)">
        <i class="fas fa-edit"></i> Éditer
    </button>

    <!-- Bouton pour supprimer -->
    <button class="btn btn-sm btn-danger" onclick="deletePartenaire(<?php echo $partenaire['id']; ?>)">
        <i class="fas fa-trash"></i> Supprimer
    </button>
</td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'ajout -->
<div class="modal fade" id="addPartenaireModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un partenaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addPartenaireForm" method="POST">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catégorie</label>
                        <select name="categorie" class="form-select" required>
                            <?php foreach ($categories as $categorie): ?>
                                <option value="<?php echo $categorie['id']; ?>">
                                    <?php echo htmlspecialchars($categorie['nom']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ville</label>
                        <input type="text" name="ville" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Remise (%)</label>
                        <input type="number" name="remise" class="form-control" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Détails</label>
                        <textarea name="details" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="addPartenaireForm" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de modification -->
<div class="modal fade" id="editPartenaireModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier un partenaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editPartenaireForm" method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" id="editPartenaireId">
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" id="editNom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catégorie</label>
                        <select name="categorie" id="editCategorie" class="form-select" required>
                            <?php foreach ($categories as $categorie): ?>
                                <option value="<?php echo $categorie['id']; ?>">
                                    <?php echo htmlspecialchars($categorie['nom']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ville</label>
                        <input type="text" name="ville" id="editVille" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Remise (%)</label>
                        <input type="number" name="remise" id="editRemise" class="form-control" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Détails</label>
                        <textarea name="details" id="editDetails" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editDescription" class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="editPartenaireForm" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
<script>
function viewStats(id) {
    fetch(`gestion_partenaires.php?action=get_statistiques&id_partenaire=${id}`)
        .then(response => response.json())
        .then(data => {
            // Construire le contenu du popup
            let content = '<h5>Statistiques des offres</h5>';

            // Afficher les remises
            content += '<h6>Remises</h6>';
            content += '<ul>';
            data.remises.forEach(remise => {
                content += `<li>${remise.nom} (${remise.valeur_remise}%) - Expire le ${remise.expire_le}</li>`;
            });
            content += '</ul>';

            // Afficher les utilisations
            content += '<h6>Membres ayant bénéficié des offres</h6>';
            content += '<ul>';
            data.utilisations.forEach(utilisation => {
                content += `<li>${utilisation.membre_nom} - Montant avant remise: ${utilisation.montant_avant_remise}, Montant remisé: ${utilisation.montant_remise}</li>`;
            });
            content += '</ul>';

            // Afficher le popup
            const popup = window.open('', 'Statistiques', 'width=600,height=400');
            popup.document.write(`
                <html>
                    <head>
                        <title>Statistiques</title>
                        <style>
                            body { font-family: Arial, sans-serif; padding: 20px; }
                            h5, h6 { color: #333; }
                            ul { list-style-type: none; padding: 0; }
                            li { margin-bottom: 10px; }
                        </style>
                    </head>
                    <body>
                        ${content}
                        <button onclick="window.close()">Fermer</button>
                    </body>
                </html>
            `);
            popup.document.close();
        })
        .catch(error => console.error('Erreur lors de la récupération des statistiques:', error));
}
function editPartenaire(id) {
    // Récupérer les données du partenaire via AJAX
    fetch(`get_partenaire.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            // Remplir les champs du modal avec les données du partenaire
            document.getElementById('editPartenaireId').value = data.id;
            document.getElementById('editNom').value = data.nom;
            document.getElementById('editCategorie').value = data.id_categorie_partenaire;
            document.getElementById('editVille').value = data.ville;
            document.getElementById('editRemise').value = data.remise;
            document.getElementById('editDetails').value = data.details;
            document.getElementById('editDescription').value = data.description;

            // Ouvrir le modal de modification
            const editModal = new bootstrap.Modal(document.getElementById('editPartenaireModal'));
            editModal.show();
        })
        .catch(error => console.error('Erreur lors de la récupération des données du partenaire:', error));
}

function deletePartenaire(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce partenaire ?')) {
        // Supprimer le partenaire
        fetch('gestion_partenaires.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=delete&id=${id}`,
        })
        .then(response => response.text())
        .then(data => {
            location.reload(); // Recharger la page après suppression
        })
        .catch(error => console.error('Error:', error));
    }
}

// Initialisation de DataTables
$(document).ready(function() {
    $('#partenairesTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
        }
    });
});
</script>

<?php require_once 'footer.php'; ?>