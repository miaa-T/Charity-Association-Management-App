<?php
require_once 'config.php';
require_once __DIR__ . '/../../models/Membre.php'; 
$database = new Database();
$db = $database->connect();

$error = '';
$success = '';

// Instancier le modèle Membre
$membreModel = new Membre($db);

// Gestion de l'approbation ou du rejet d'un membre
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    if ($action === 'approve') {
        if ($membreModel->approveMember($id)) {
            $success = "Membre approuvé avec succès!";
        } else {
            $error = "Erreur lors de l'approbation du membre.";
        }
    } elseif ($action === 'reject') {
        if ($membreModel->rejectMember($id)) {
            $success = "Membre rejeté avec succès!";
        } else {
            $error = "Erreur lors du rejet du membre.";
        }
    }
}

// Récupérer tous les membres avec filtrage et tri
$filtre_statut = $_GET['statut'] ?? '';
$filtre_type_abonnement = $_GET['type_abonnement'] ?? '';
$tri = $_GET['tri'] ?? 'date_inscription DESC';

$membres = $membreModel->getAllMembers($filtre_statut, $filtre_type_abonnement, $tri);
?>

<?php require_once 'header.php'; ?>

<div class="container-fluid content">
    <h1 class="h3 mb-4">Gestion des Membres</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <!-- Filtres et tri -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filtres et Tri</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="">
                <div class="form-group">
                    <label for="statut">Statut</label>
                    <select class="form-control" id="statut" name="statut">
                        <option value="">Tous</option>
                        <option value="En attente" <?php echo ($filtre_statut === 'En attente') ? 'selected' : ''; ?>>En attente</option>
                        <option value="Approuvé" <?php echo ($filtre_statut === 'Approuvé') ? 'selected' : ''; ?>>Approuvé</option>
                        <option value="Rejeté" <?php echo ($filtre_statut === 'Rejeté') ? 'selected' : ''; ?>>Rejeté</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="type_abonnement">Type d'abonnement</label>
                    <select class="form-control" id="type_abonnement" name="type_abonnement">
                        <option value="">Tous</option>
                        <?php
                        $typesAbonnement = $membreModel->getAllSubscriptionTypes();
                        foreach ($typesAbonnement as $type) {
                            echo "<option value='{$type['id']}' " . ($filtre_type_abonnement == $type['id'] ? 'selected' : '') . ">{$type['nom']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tri">Trier par</label>
                    <select class="form-control" id="tri" name="tri">
                        <option value="date_inscription DESC" <?php echo ($tri === 'date_inscription DESC') ? 'selected' : ''; ?>>Date d'inscription (récent)</option>
                        <option value="date_inscription ASC" <?php echo ($tri === 'date_inscription ASC') ? 'selected' : ''; ?>>Date d'inscription (ancien)</option>
                        <option value="nom ASC" <?php echo ($tri === 'nom ASC') ? 'selected' : ''; ?>>Nom (A-Z)</option>
                        <option value="nom DESC" <?php echo ($tri === 'nom DESC') ? 'selected' : ''; ?>>Nom (Z-A)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Appliquer</button>
            </form>
        </div>
    </div>

    <!-- Liste des membres -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Liste des Membres</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Type d'abonnement</th>
                            <th>Date d'inscription</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($membres as $membre): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($membre['prenom'] . ' ' . $membre['nom']); ?></td>
                                <td><?php echo htmlspecialchars($membre['email']); ?></td>
                                <td><?php echo htmlspecialchars($membre['telephone']); ?></td>
                                <td><?php echo htmlspecialchars($membre['type_abonnement']); ?></td>
                                <td><?php echo htmlspecialchars($membre['date_inscription']); ?></td>
                                <td><?php echo htmlspecialchars($membre['statut']); ?></td>
                                <td>
                                    <?php if ($membre['statut'] === 'En attente'): ?>
                                        <a href="gestion_membres.php?action=approve&id=<?php echo $membre['id']; ?>" class="btn btn-sm btn-success">Approuver</a>
                                        <a href="gestion_membres.php?action=reject&id=<?php echo $membre['id']; ?>" class="btn btn-sm btn-danger">Rejeter</a>
                                    <?php endif; ?>
                                    <button class="btn btn-sm btn-info btn-details" data-id="<?php echo $membre['id']; ?>">Détails</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Member Details -->
<div class="modal fade" id="memberDetailsModal" tabindex="-1" aria-labelledby="memberDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberDetailsModalLabel">Détails du Membre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="memberDetailsContent">
                <!-- Member details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Handle "Détails" button click
        $('.btn-details').on('click', function() {
            var memberId = $(this).data('id'); // Get member ID from data attribute

            // Send AJAX request to fetch member details
            $.ajax({
                url: 'get_member_details.php', // Endpoint to fetch details
                type: 'GET',
                data: { id: memberId },
                success: function(response) {
                    $('#memberDetailsContent').html(response); // Load response into modal body
                    $('#memberDetailsModal').modal('show'); // Show the modal
                },
                error: function() {
                    alert('Erreur lors du chargement des détails du membre.');
                }
            });
        });
    });
</script>

<?php require_once 'footer.php'; ?>