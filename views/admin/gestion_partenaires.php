<?php
require_once 'config.php';
require_once __DIR__ . '/../../models/Partenaire.php';

$database = new Database();
$db = $database->connect();

$error = '';
$success = '';

// Instancier le modèle Partenaire
$partenaireModel = new Partenaire($db);

// Récupérer les villes et catégories pour les filtres
$villes = $db->query("SELECT DISTINCT ville FROM partenaires ORDER BY ville")->fetchAll(PDO::FETCH_COLUMN);
$categories = $db->query("SELECT id, nom FROM categorie_partenaire ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

// Gestion des actions (ajout, modification, suppression)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $partenaireModel->nom = $_POST['nom'];
                $partenaireModel->id_categorie_partenaire = $_POST['categorie'];
                $partenaireModel->ville = $_POST['ville'];
                $partenaireModel->remise = $_POST['remise'];
                $partenaireModel->details = $_POST['details'];
                $partenaireModel->logo = ''; // Gérer l'upload du logo si nécessaire

                if ($partenaireModel->create()) {
                    $success = "Partenaire ajouté avec succès!";
                } else {
                    $error = "Erreur lors de l'ajout du partenaire.";
                }
                break;

            case 'edit':
                $partenaireModel->id = $_POST['id'];
                $partenaireModel->nom = $_POST['nom'];
                $partenaireModel->id_categorie_partenaire = $_POST['categorie'];
                $partenaireModel->ville = $_POST['ville'];
                $partenaireModel->remise = $_POST['remise'];
                $partenaireModel->details = $_POST['details'];
                $partenaireModel->logo = ''; // Gérer l'upload du logo si nécessaire

                if ($partenaireModel->update()) {
                    $success = "Partenaire mis à jour avec succès!";
                } else {
                    $error = "Erreur lors de la mise à jour du partenaire.";
                }
                break;

            case 'delete':
                $partenaireModel->id = $_POST['id'];
                if ($partenaireModel->delete()) {
                    $success = "Partenaire supprimé avec succès!";
                } else {
                    $error = "Erreur lors de la suppression du partenaire.";
                }
                break;
        }
    }
}

// Récupérer les partenaires avec filtres
$ville_filter = $_GET['ville'] ?? '';
$categorie_filter = $_GET['categorie'] ?? '';

$query = "SELECT p.*, cp.nom as categorie_nom 
          FROM partenaires p 
          LEFT JOIN categorie_partenaire cp ON p.id_categorie_partenaire = cp.id 
          WHERE 1=1";

if (!empty($ville_filter)) {
    $query .= " AND p.ville = :ville";
}
if (!empty($categorie_filter)) {
    $query .= " AND p.id_categorie_partenaire = :categorie";
}

$query .= " ORDER BY p.nom";

$stmt = $db->prepare($query);

if (!empty($ville_filter)) {
    $stmt->bindParam(':ville', $ville_filter);
}
if (!empty($categorie_filter)) {
    $stmt->bindParam(':categorie', $categorie_filter);
}

$stmt->execute();
$partenaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                                    <button class="btn btn-sm btn-info" onclick="viewStats(<?php echo $partenaire['id']; ?>)">
                                        <i class="fas fa-chart-bar"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary" onclick="editPartenaire(<?php echo $partenaire['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deletePartenaire(<?php echo $partenaire['id']; ?>)">
                                        <i class="fas fa-trash"></i>
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="addPartenaireForm" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </div>
</div>

<script>
function viewStats(id) {
    // Afficher les statistiques du partenaire
    alert("Statistiques du partenaire ID: " + id);
}

function editPartenaire(id) {
    // Ouvrir le modal d'édition avec les données du partenaire
    alert("Éditer le partenaire ID: " + id);
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