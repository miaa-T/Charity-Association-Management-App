<?php
// Include the MembreController and TypeAbonnementController
require_once __DIR__ . '/../../controllers/MembresController.php';
require_once __DIR__ . '/../../controllers/TypeAbonnementController.php';

// Create instances of the controllers
$membreController = new MembreController();
$typeAbonnementController = new TypeAbonnementController();

// Get all subscription types from the database
$subscriptionTypes = $typeAbonnementController->getAll();

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
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container_inscription">
        <h1>Inscription Membre</h1>
     
        <!-- Payment Instructions Section -->
        <div class="payment-instructions">
            <h2>Instructions de Paiement</h2>
            <p>Pour finaliser votre inscription, veuillez effectuer le paiement des frais d'abonnement sur le compte CCP suivant :</p>
            <p><strong>Numéro de CCP :</strong> 123456789</p>
            <p><strong>Clé :</strong> 25</p>
            <p><strong>Titulaire du compte :</strong> Association El Mountada</p>
            <p><strong>Montant :</strong> Selon le type d'abonnement choisi (voir ci-dessous).</p>
            <p>Après avoir effectué le paiement, veuillez télécharger le reçu de paiement dans le formulaire ci-dessous.</p>
        </div>
        
        <!-- Purpose Section -->
        <div class="purpose-section">
            <h2>Pourquoi devenir membre ?</h2>
            <p>En devenant membre de notre association caritative El Mountada, vous bénéficiez des avantages suivants :</p>
            <ul>
                <li>Accès à des <strong>remises exclusives</strong> chez nos partenaires (hôtels, cliniques, écoles, etc.).</li>
                <li>Participation à des <strong>événements spéciaux</strong> réservés aux membres.</li>
                <li>Possibilité de <strong>faire du bénévolat</strong> et de contribuer à des causes importantes.</li>
                <li>Accès à un <strong>historique de vos dons</strong> et de vos contributions.</li>
                <li>Une <strong>carte de membre électronique</strong> avec un code QR pour faciliter l'accès aux avantages.</li>
            </ul>
        </div>



        <br> <h2>Informations Personnelles</h2>
        <form method="POST" enctype="multipart/form-data" class="two-column-form">
 <!-- Subscription Types Section -->
<h2>Type de Carte d'Abonnement</h2>
<div class="subscription-types-grid">
    <?php foreach ($subscriptionTypes as $type): ?>
        <div class="subscription-card">
            <h3><?= htmlspecialchars($type['nom']) ?></h3>
            <p>Prix annuel : <?= htmlspecialchars($type['prix_annuel']) ?> DZD</p>
            <label>
                <input type="radio" name="type_carte" value="<?= htmlspecialchars($type['nom']) ?>" required> Choisir
            </label>
        </div>
    <?php endforeach; ?>
</div>
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
            <div class="form-group_inscription">
                <label for="numero_identite">Numéro d'identité :</label>
                <input type="text" id="numero_identite" name="numero_identite" required>
            </div>

            <!-- File Uploads Section -->
            <h2 class="full-width">Documents à Télécharger</h2>
            <div class="form-group_inscription full-width">
                <label class="file-label_inscription" for="photo_profil">
                    <i class="fa fa-upload"></i> Photo de profil
                </label>
                <input class="file-input_inscription" type="file" id="photo_profil" name="photo_profil" accept="image/*" required>
            </div>
            <div class="form-group_inscription full-width">
                <label class="file-label_inscription" for="piece_identite">
                    <i class="fa fa-upload"></i> Pièce d'identité
                </label>
                <input class="file-input_inscription" type="file" id="piece_identite" name="piece_identite" accept=".pdf,.jpg,.png" required>
            </div>
            <div class="form-group_inscription full-width">
                <label class="file-label_inscription" for="recu_paiement">
                    <i class="fa fa-upload"></i> Reçu de paiement
                </label>
                <input class="file-input_inscription" type="file" id="recu_paiement" name="recu_paiement" accept=".pdf,.jpg,.png" required>
            </div>

            <!-- Terms and Conditions Section -->
            <div class="checkbox-group_inscription full-width">
                <label>
                    <input type="checkbox" name="consentement" required> J'accepte les termes et conditions générales
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="submit-btn_inscription full-width">S'inscrire</button>        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>