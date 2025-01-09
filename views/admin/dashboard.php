<?php
require_once 'config.php';

// Récupération des statistiques
$stats = array(
    'membres' => 0,
    'partenaires' => 0,
    'dons' => 0,
    'demandes' => 0
);

try {
    $database = new Database();
    $db = $database->connect();

    // Nombre total de membres
    $query = "SELECT COUNT(*) as total FROM membres";
    $stmt = $db->query($query);
    $stats['membres'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Nombre de partenaires
    $query = "SELECT COUNT(*) as total FROM partenaires";
    $stmt = $db->query($query);
    $stats['partenaires'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Total des dons
    $query = "SELECT COUNT(*) as total FROM dons";
    $stmt = $db->query($query);
    $stats['dons'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Nombre de demandes d'aide en attente
    $query = "SELECT COUNT(*) as total FROM demandes_aides WHERE statut = 'En attente'";
    $stmt = $db->query($query);
    $stats['demandes'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];


} catch(PDOException $e) {
    error_log($e->getMessage());
    $error = "Une erreur est survenue lors de la récupération des statistiques.";
}
?>

<?php require_once 'header.php'; ?>

<div class="container-fluid content">
    <h1 class="h3 mb-4">Tableau de bord</h1>

    <div class="dashboard-stats">
        <div class="card stats-card">
            <div class="card-body">
                <h5 class="card-title">Membres</h5>
                <p class="card-text display-4"><?php echo $stats['membres']; ?></p>
                <a href="gestion_membres.php" class="btn btn-primary">Gérer les membres</a>
            </div>
        </div>

        <div class="card stats-card">
            <div class="card-body">
                <h5 class="card-title">Partenaires</h5>
                <p class="card-text display-4"><?php echo $stats['partenaires']; ?></p>
                <a href="gestion_partenaires.php" class="btn btn-primary">Gérer les partenaires</a>
            </div>
        </div>

        <div class="card stats-card">
            <div class="card-body">
                <h5 class="card-title">Dons</h5>
                <p class="card-text display-4"><?php echo $stats['dons']; ?></p>
                <a href="gestion_dons.php" class="btn btn-primary">Voir les dons</a>
            </div>
        </div>

        <div class="card stats-card">
            <div class="card-body">
                <h5 class="card-title">Demandes d'aide</h5>
                <p class="card-text display-4"><?php echo $stats['demandes']; ?></p>
                <a href="demandes_aide.php" class="btn btn-primary">Voir les demandes</a>
            </div>
        </div>
    </div>

    <!-- Dernières activités -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Dernières activités</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Action</th>
                            <th>Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $query = "SELECT * FROM historique_admin 
                                    ORDER BY date_action DESC LIMIT 20";
                            $stmt = $db->query($query);
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . date('d/m/Y H:i', strtotime($row['date_action'])) . "</td>";
                                echo "<td>" . htmlspecialchars($row['type_action']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['details']) . "</td>";
                                echo "</tr>";
                            }
                        } catch(PDOException $e) {
                            error_log($e->getMessage());
                            echo "<tr><td colspan='3'>Erreur lors de la récupération de l'historique</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>