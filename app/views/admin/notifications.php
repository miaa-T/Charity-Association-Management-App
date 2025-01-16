<?php
require_once __DIR__ . '/../../controllers/NotificationController.php';

$database = new Database();
$db = $database->connect();

$notificationController = new NotificationController($db);

// Traitement du formulaire de création de notification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_notification'])) {
    $id_membre = $_POST['id_membre'];
    $id_type_notification = $_POST['id_type_notification'];
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];

    if ($notificationController->createNotification($id_membre, $id_type_notification, $titre, $contenu)) {
        echo "<div class='alert alert-success'>Notification créée avec succès !</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la création de la notification.</div>";
    }
}

// Traitement de la suppression d'une notification
if (isset($_GET['delete_id'])) {
    if ($notificationController->deleteNotification($_GET['delete_id'])) {
        echo "<div class='alert alert-success'>Notification supprimée avec succès !</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la suppression de la notification.</div>";
    }
}

// Récupérer les détails de la notification à éditer
// Récupérer les détails de la notification à éditer
$notificationToEdit = null;
if (isset($_GET['id'])) {
    $notificationId = $_GET['id'];
    $notifications = $notificationController->getAllNotifications();
    foreach ($notifications as $notification) {
        if ($notification['id'] == $notificationId) {
            $notificationToEdit = $notification;
            break;
        }
    }
}

// Traitement de la mise à jour d'une notification
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_notification'])) {
    $id = $_POST['id'];
    $id_membre = $_POST['id_membre'];
    $id_type_notification = $_POST['id_type_notification'];
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];

    if ($notificationController->editNotification($id, $id_membre, $id_type_notification, $titre, $contenu)) {
        echo "<div class='alert alert-success'>Notification mise à jour avec succès !</div>";
        // Clear the edit form after successful update
        $notificationToEdit = null;
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la mise à jour de la notification.</div>";
    }
}

// Récupérer toutes les notifications
$notifications = $notificationController->getAllNotifications();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Notifications</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<?php require_once 'header.php'; ?>
<body>
 <div class="container mt-5">
        <h1 class="mb-4">Gestion des Notifications</h1>

        <!-- Formulaire de création de notification -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Créer une Notification</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="id_membre" class="form-label">ID Membre</label>
                        <input type="number" class="form-control" id="id_membre" name="id_membre" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_type_notification" class="form-label">Type de Notification</label>
                        <select class="form-select" id="id_type_notification" name="id_type_notification" required>
                            <option value="1">Événement</option>
                            <option value="2">Promotion</option>
                            <option value="3">Renouvellement</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>
                    <div class="mb-3">
                        <label for="contenu" class="form-label">Contenu</label>
                        <textarea class="form-control" id="contenu" name="contenu" rows="3" required></textarea>
                    </div>
                    <button type="submit" name="create_notification" class="btn btn-primary">Créer</button>
                </form>
            </div>
        </div>

        <!-- Formulaire de modification de notification -->
        <?php if ($notificationToEdit) : ?>
    <div class="card mb-4">
        <div class="card-header">
            <h5>Modifier la Notification</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <input type="hidden" name="id" value="<?= $notificationToEdit['id'] ?>">
                <div class="mb-3">
                    <label for="edit_id_membre" class="form-label">ID Membre</label>
                    <input type="number" class="form-control" id="edit_id_membre" name="id_membre" value="<?= $notificationToEdit['id_membre'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="edit_id_type_notification" class="form-label">Type de Notification</label>
                    <select class="form-select" id="edit_id_type_notification" name="id_type_notification" required>
                        <option value="1" <?= $notificationToEdit['id_type_notification'] == 1 ? 'selected' : '' ?>>Événement</option>
                        <option value="2" <?= $notificationToEdit['id_type_notification'] == 2 ? 'selected' : '' ?>>Promotion</option>
                        <option value="3" <?= $notificationToEdit['id_type_notification'] == 3 ? 'selected' : '' ?>>Renouvellement</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="edit_titre" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="edit_titre" name="titre" value="<?= $notificationToEdit['titre'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="edit_contenu" class="form-label">Contenu</label>
                    <textarea class="form-control" id="edit_contenu" name="contenu" rows="3" required><?= $notificationToEdit['contenu'] ?></textarea>
                </div>
                <button type="submit" name="update_notification" class="btn btn-warning">Mettre à jour</button>
                <a href="admin_notifications.php" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
<?php endif; ?>

        <!-- Liste des notifications -->
        <div class="card">
            <div class="card-header">
                <h5>Liste des Notifications</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Membre</th>
                            <th>Type</th>
                            <th>Titre</th>
                            <th>Contenu</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($notifications)) : ?>
                            <?php foreach ($notifications as $notification) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($notification['id']) ?></td>
                                    <td><?= htmlspecialchars($notification['id_membre']) ?></td>
                                    <td><?= htmlspecialchars($notification['type_notification']) ?></td>
                                    <td><?= htmlspecialchars($notification['titre']) ?></td>
                                    <td><?= htmlspecialchars($notification['contenu']) ?></td>
                                    <td><?= $notificationController->formatNotificationTime($notification['envoye_le']) ?></td>
                                    <td>
                                        <a href="?id=<?= $notification['id'] ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?delete_id=<?= $notification['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette notification ?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="7" class="text-center">Aucune notification trouvée.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>