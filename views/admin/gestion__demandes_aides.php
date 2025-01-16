<?php
session_start();

// Vérifier si l'utilisateur est un administrateur
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php'); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

require_once __DIR__ . '/../../controllers/AideController.php';

$aideController = new AideController();

// Récupérer toutes les demandes d'aides via le contrôleur
$demandes = $aideController->getDemandesAide();

// Traitement de la suppression d'une demande
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer'])) {
    $id = $_POST['id'];
    if ($aideController->supprimerDemandeAide($id)) {
        $success = "La demande d'aide a été supprimée avec succès.";
    } else {
        $error = "Erreur lors de la suppression de la demande d'aide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Demandes d'Aides</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
</head>

<body>
<?php include 'header.php'; ?>
    <div class="container">
        <h1>Gestion des Demandes d'Aides</h1>

        <?php if (isset($success)): ?>
            <div style="color: green; margin-bottom: 20px;"><?php echo $success; ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 20px;"><?php echo $error; ?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Type d'Aide</th>
                    <th>Date de Création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demandes as $demande): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($demande['id']); ?></td>
                        <td><?php echo htmlspecialchars($demande['nom']); ?></td>
                        <td><?php echo htmlspecialchars($demande['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($demande['type_aide']); ?></td>
                        <td><?php echo htmlspecialchars($demande['cree_le']); ?></td>
                        <td class="actions">
                            <button class="btn btn-view" onclick="openModal(<?php echo htmlspecialchars(json_encode($demande)); ?>)">Voir</button>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $demande['id']; ?>">
                                <button type="submit" name="supprimer" class="btn btn-delete">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal pour afficher les détails -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Détails de la Demande</h2>
            <p><strong>ID:</strong> <span id="modal-id"></span></p>
            <p><strong>Nom:</strong> <span id="modal-nom"></span></p>
            <p><strong>Prénom:</strong> <span id="modal-prenom"></span></p>
            <p><strong>Date de Naissance:</strong> <span id="modal-date-naissance"></span></p>
            <p><strong>Type d'Aide:</strong> <span id="modal-type-aide"></span></p>
            <p><strong>Description:</strong> <span id="modal-description"></span></p>
            <p><strong>Numéro d'Identité:</strong> <span id="modal-numero-identite"></span></p>
            <p><strong>Numéro de Téléphone:</strong> <span id="modal-numero-telephone"></span></p>
            <p><strong>Fichier:</strong> <a id="modal-fichier" href="#" target="_blank">Télécharger</a></p>
            <p><strong>Créé le:</strong> <span id="modal-cree-le"></span></p>
            <p><strong>Modifié le:</strong> <span id="modal-modifie-le"></span></p>
        </div>
    </div>

    <script>
        function openModal(demande) {
            document.getElementById('modal-id').textContent = demande.id;
            document.getElementById('modal-nom').textContent = demande.nom;
            document.getElementById('modal-prenom').textContent = demande.prenom;
            document.getElementById('modal-date-naissance').textContent = demande.date_naissance;
            document.getElementById('modal-type-aide').textContent = demande.type_aide;
            document.getElementById('modal-description').textContent = demande.description;
            document.getElementById('modal-numero-identite').textContent = demande.numero_identite;
            document.getElementById('modal-numero-telephone').textContent = demande.numero_telephone;
            document.getElementById('modal-fichier').href = demande.fichier;
            document.getElementById('modal-cree-le').textContent = demande.cree_le;
            document.getElementById('modal-modifie-le').textContent = demande.modifie_le;

            document.getElementById('modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        // Fermer la modal si l'utilisateur clique en dehors de celle-ci
        window.onclick = function(event) {
            const modal = document.getElementById('modal');
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>
    
    <style>
        /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    color: #333;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 40px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 30px;
    font-size: 2.5rem;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #3498db;
    color: white;
    font-weight: bold;
}

tr:hover {
    background-color: #f1f1f1;
}

/* Button Styles */
.actions {
    display: flex;
    gap: 10px;
}

.btn {
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.btn-view {
    background-color: #3498db;
    color: white;
}

.btn-view:hover {
    background-color: #2980b9;
}

.btn-delete {
    background-color: #e74c3c;
    color: white;
}

.btn-delete:hover {
    background-color: #c0392b;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 10px;
    width: 50%;
    max-width: 600px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    position: relative;
}

.close {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 24px;
    font-weight: bold;
    color: #333;
    cursor: pointer;
}

.close:hover {
    color: #000;
}

.modal-content h2 {
    margin-top: 0;
    color: #2c3e50;
}

.modal-content p {
    margin: 10px 0;
    font-size: 1rem;
    color: #555;
}

.modal-content strong {
    color: #2c3e50;
}

/* Success and Error Messages */
.alert {
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
    text-align: center;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
    </style>
</body>
</html>