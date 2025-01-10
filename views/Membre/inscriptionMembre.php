<?php
// Include the MembreController
require_once __DIR__ . '/../../controllers/MembresController.php';

// Create an instance of MembreController
$membreController = new MembreController();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $membreController->register();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Membre</title>
    <link rel="stylesheet" href="../styles.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?> <!-- Include the navigation bar -->

    <div class="container_inscription">
        <h1>Inscription Membre</h1>
        <form method="POST" enctype="multipart/form-data">
            <!-- Section: Personal Information -->
            <h2>Informations Personnelles</h2>
            <div class="form-group_inscription">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="form-group_inscription">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group_inscription">
                <label for="date_naissance">Date de naissance :</label>
                <input type="date" id="date_naissance" name="date_naissance" required>
            </div>
            <div class="form-group_inscription">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group_inscription">
                <label for="telephone">Téléphone :</label>
                <input type="text" id="telephone" name="telephone" required>
            </div>
            <div class="form-group_inscription">
                <label for="ville">Ville :</label>
                <input type="text" id="ville" name="ville" required>
            </div>
            <div class="form-group_inscription">
                <label for="code_postal">Code postal :</label>
                <input type="text" id="code_postal" name="code_postal" required>
            </div>
            <div class="form-group_inscription">
                <label for="adresse_complete">Adresse complète :</label>
                <textarea id="adresse_complete" name="adresse_complete" rows="3" required></textarea>
            </div>
            <div class="form-group_inscription">
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>
            <div class="form-group_inscription">
                <label for="confirmation_mot_de_passe">Confirmation du mot de passe :</label>
                <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" required>
            </div>
            <label for="numero_identite">Numéro d'identité :</label>
            <input type="text" id="numero_identite" name="numero_identite" required>
            <!-- Section: Type of Card -->
            <h2>Type de Carte d'Abonnement</h2>
            <div class="radio-group_inscription">
                <label>
                    <input type="radio" name="type_carte" value="Classique" required> Classique
                </label>
                <label>
                    <input type="radio" name="type_carte" value="Jeunes"> Jeunes
                </label>
                <label>
                    <input type="radio" name="type_carte" value="Premium"> Premium
                </label>
            </div>

            <!-- Section: File Uploads -->
            <h2>Documents à Télécharger</h2>
            <div class="form-group_inscription">
                <label class="file-label_inscription" for="photo_profil">
                    <i class="fa fa-upload"></i> Photo de profil
                </label>
                <input class="file-input_inscription" type="file" id="photo_profil" name="photo_profil" accept="image/*" required>
            </div>
            <div class="form-group_inscription">
                <label class="file-label_inscription" for="piece_identite">
                    <i class="fa fa-upload"></i> Pièce d'identité
                </label>
                <input class="file-input_inscription" type="file" id="piece_identite" name="piece_identite" accept=".pdf,.jpg,.png" required>
            </div>
            <div class="form-group_inscription">
                <label class="file-label_inscription" for="recu_paiement">
                    <i class="fa fa-upload"></i> Reçu de paiement
                </label>
                <input class="file-input_inscription" type="file" id="recu_paiement" name="recu_paiement" accept=".pdf,.jpg,.png" required>
            </div>

            <!-- Section: Terms and Conditions -->
            <div class="checkbox-group_inscription">
                <label>
                    <input type="checkbox" name="consentement" required> J'accepte les termes et conditions générales
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn_inscription">S'inscrire</button>
        </form>
    </div>

    <?php include 'footer.php'; ?> <!-- Include the footer -->
</body>
</html>