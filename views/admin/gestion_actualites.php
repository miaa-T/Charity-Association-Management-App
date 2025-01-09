<?php
require_once 'config.php';
require_once __DIR__ . '/../../models/Actualites.php';
$database = new Database();
$db = $database->connect();

$error = '';
$success = '';

// Instantiate the Actualite model
$actualiteModel = new Actualite($db);

// Handle form submission for creating a new actualité
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_actualite'])) {
    $titre = $_POST['titre']; // No htmlspecialchars here
    $description = $_POST['description']; // No htmlspecialchars here
    $image = $_FILES['image']['name'];

    // Ensure the upload directory exists
    if (!is_dir(UPLOAD_PATH)) {
        mkdir(UPLOAD_PATH, 0777, true); // Create the directory with full permissions
    }

    // Upload image
    $target_dir = str_replace('\\', '/', UPLOAD_PATH); // Normalize path
    $target_file = $target_dir . basename($_FILES['image']['name']); // Construct full file path

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // Set properties in the Actualite model
        $actualiteModel->titre = $titre;
        $actualiteModel->description = $description;
        $actualiteModel->image = $target_file; // Store the full path

        // Create the actualité
        if ($actualiteModel->create()) {
            $success = "Actualité créée avec succès!";
        } else {
            $error = "Erreur lors de la création de l'actualité.";
        }
    } else {
        $error = "Erreur lors du téléchargement de l'image.";
    }
}

// Handle deletion of an actualité
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Set the ID in the Actualite model
    $actualiteModel->id = $id;

    // Delete the actualité
    if ($actualiteModel->delete()) {
        $success = "Actualité supprimée avec succès!";
    } else {
        $error = "Erreur lors de la suppression de l'actualité.";
    }
}

// Handle updating an actualité
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_actualite'])) {
    $id = $_POST['id'];
    $titre = cleanInput($_POST['titre']);
    $description = cleanInput($_POST['description']);

    // Set properties in the Actualite model
    $actualiteModel->id = $id;
    $actualiteModel->titre = $titre;
    $actualiteModel->description = $description;

    // Update the actualité
    if ($actualiteModel->update()) {
        $success = "Actualité mise à jour avec succès!";
    } else {
        $error = "Erreur lors de la mise à jour de l'actualité.";
    }
}

// Fetch all actualités
try {
    $stmt = $actualiteModel->read();
    $actualites = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Erreur lors de la récupération des actualités: " . $e->getMessage();
}
?>

<?php require_once 'header.php'; ?>

<div class="container-fluid content">
    <h1 class="h3 mb-4">Gestion des Actualités</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <!-- Form to create a new actualité -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Créer une nouvelle actualité</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                </div>
                <button type="submit" name="create_actualite" class="btn btn-primary">Créer</button>
            </form>
        </div>
    </div>

    <!-- List of existing actualités -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Liste des actualités</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($actualites as $actualite): ?>
                            <tr id="row-<?php echo $actualite['id']; ?>">
                                <td><img src="<?php echo UPLOAD_PATH . $actualite['image']; ?>" width="100" alt="Image"></td>
                                <td>
                                    <span class="view-mode" id="titre-<?php echo $actualite['id']; ?>"><?php echo htmlspecialchars($actualite['titre']); ?></span>
                                    <input type="text" class="form-control edit-mode" id="edit-titre-<?php echo $actualite['id']; ?>" value="<?php echo htmlspecialchars($actualite['titre']); ?>" style="display: none;">
                                </td>
                                <td>
                                    <span class="view-mode" id="description-<?php echo $actualite['id']; ?>"><?php echo htmlspecialchars($actualite['description']); ?></span>
                                    <textarea class="form-control edit-mode" id="edit-description-<?php echo $actualite['id']; ?>" style="display: none;"><?php echo htmlspecialchars($actualite['description']); ?></textarea>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($actualite['cree_le'])); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-btn" data-id="<?php echo $actualite['id']; ?>">Modifier</button>
                                    <button class="btn btn-sm btn-success save-btn" data-id="<?php echo $actualite['id']; ?>" style="display: none;">Enregistrer</button>
                                    <a href="gestion_actualites.php?delete=<?php echo $actualite['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette actualité?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-btn');
    const saveButtons = document.querySelectorAll('.save-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const row = document.getElementById(`row-${id}`);

            row.querySelectorAll('.view-mode').forEach(el => el.style.display = 'none');
            row.querySelectorAll('.edit-mode').forEach(el => el.style.display = 'block');

            this.style.display = 'none';
            row.querySelector(`.save-btn[data-id="${id}"]`).style.display = 'inline-block';
        });
    });

    saveButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const row = document.getElementById(`row-${id}`);

            const titre = row.querySelector(`#edit-titre-${id}`).value;
            const description = row.querySelector(`#edit-description-${id}`).value;

            const formData = new FormData();
            formData.append('update_actualite', '1');
            formData.append('id', id);
            formData.append('titre', titre);
            formData.append('description', description);

            fetch('gestion_actualites.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); 
                location.reload(); 
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>

<?php require_once 'footer.php'; ?>