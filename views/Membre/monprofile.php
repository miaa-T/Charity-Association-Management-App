<?php
session_start(); // Start the session
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
$isUserLoggedIn = isset($_SESSION['user_id']); // Check if the user is logged in

// Include the necessary files
require_once __DIR__ . '/../../controllers/MembresController.php';

// Initialize the MembreController
$membreController = new MembreController();

// Check if the user is logged in
if ($isUserLoggedIn) {
    $userId = $_SESSION['user_id']; // Use 'user_id' from the session
    $member = $membreController->getMemberById($userId); // Fetch member data via the controller

    if (!$member) {
        // Handle the case where the member data is not found
        die("Member data not found.");
    }
} else {
    // Redirect to login or handle the case where the user is not logged in
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);

    // Gérer le téléchargement de la photo de profil
    $photo = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $targetDir = __DIR__ . "/../../uploads/photos/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
        $targetFile = $targetDir . $fileName;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
            $photo = $targetFile;
        }
    }

    // Préparer les données à mettre à jour
    $updateData = [
        'prenom' => $prenom,
        'nom' => $nom,
        'email' => $email,
        'telephone' => $telephone,
        'photo' => $photo
    ];

    // Mettre à jour les informations du membre
    if ($membreController->updateMember($userId, $updateData)) {
        // Rediriger vers la page de profil avec un message de succès
        $_SESSION['success_message'] = "Vos informations ont été mises à jour avec succès.";
        header("Location: monprofile.php");
        exit();
    } else {
        // Rediriger vers la page de profil avec un message d'erreur
        $_SESSION['error_message'] = "Une erreur s'est produite lors de la mise à jour de vos informations.";
        header("Location: monprofile.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil de Membre</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Profile Page Content -->
    <main class="profile-page">
        <section class="profile-header">
            <h1>Mon Profil de Membre</h1>
            <p>Bienvenue, <?php echo htmlspecialchars($member['prenom'] . ' ' . $member['nom']); ?>!</p>
        </section>

        <!-- Personal Information Section -->
        <section class="personal-info-section">
            <div class="personal-info-card">
                <div class="info-text">
                    <p><strong>Nom complet:</strong> <?php echo htmlspecialchars($member['prenom'] . ' ' . $member['nom']); ?></p>
                    <p><strong>Identifiant:</strong> <?php echo htmlspecialchars($member['id']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($member['email']); ?></p>
                    <p><strong>Téléphone:</strong> <?php echo htmlspecialchars($member['telephone']); ?></p>
                    <p><strong>Type de carte:</strong> <?php echo htmlspecialchars($member['nom_type_abonnement']); ?></p>
                    <p><strong>Expiration:</strong> <?php echo htmlspecialchars($member['date_expiration']); ?></p>
                </div>
                <div class="profile-photo">
                 <img src="<?php echo htmlspecialchars($member['photo'] ?? ''); ?>" alt="Profile Picture">
                </div>
            </div>
            <button class="edit-info-btn" onclick="toggleEditForm()">Modifier mes informations</button>
        </section>

        <!-- Edit Information Form (Hidden by Default) -->
        <div id="edit-form" style="display: none;">
            <h2>Modifier mes informations</h2>
            <form action="monprofile.php" method="POST" enctype="multipart/form-data">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($member['prenom']); ?>" required>

                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($member['nom']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($member['email']); ?>" required>

                <label for="telephone">Téléphone:</label>
                <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($member['telephone']); ?>">

                <label for="photo">Photo de profil:</label>
                <input type="file" id="photo" name="photo">

                <button type="submit">Enregistrer les modifications</button>
            </form>
        </div>

       
   
        <!-- Renewal Section -->
        <section class="renewal-section">
            <div class="renewal-alert">
                <p>Votre abonnement expire bientôt. Renouvelez dès maintenant !</p>
            </div>
            <div class="renewal-form">
                <div class="file-upload">
                    <label for="payment-proof">Reçu de paiement</label>
                    <input type="file" id="payment-proof">
                </div>
                <div class="file-upload">
                    <label for="identity-proof">Document d'identité</label>
                    <input type="file" id="identity-proof">
                </div>
                <button class="renewal-submit-btn">Soumettre le renouvellement</button>
            </div>
        </section>

        <!-- Advantages and Rewards Section -->
        <section class="advantages-section">
            <h2>Avantages et Récompenses</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Type de Carte</th>
                        <th>Remises Disponibles</th>
                        <th>Partenaires des remises obtenues</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($member['nom_type_abonnement']); ?></td>
                        <td>Jusqu'à 50%</td>
                        <td>Hôtel AZ, Clinique Santé+</td>
                    </tr>
                </tbody>
            </table>
            <div class="rewards-notification">
                <p>Vous avez accumulé <strong>150 points de fidélité !</strong></p>
                <button class="special-offers-btn">Voir les Offres Spéciales</button>
            </div>
        </section>

        <!-- History Section -->
        <div class="history-section">
            <h2>Historique</h2>
            <div class="tabs">
                <button class="tab-link active" data-tab="dons">Dons</button>
                <button class="tab-link" data-tab="activities">Activités</button>
                <button class="tab-link" data-tab="paiements">Paiements</button>
                <button class="tab-link" data-tab="remises">Remises</button>
            </div>
            <div class="tab-content active" id="dons">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Campagne/Objet</th>
                            <th>Référence</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>15/12/2024</td>
                            <td>35000 DA</td>
                            <td>Un hiver au chaud</td>
                            <td>REF123456</td>
                            <td class="status validated">Confirmé</td>
                        </tr>
                        <tr>
                            <td>01/10/2024</td>
                            <td>10000 DA</td>
                            <td>Don libre</td>
                            <td>REF987654</td>
                            <td class="status validated">Confirmé</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Other tab contents -->
        </div>

        <!-- Notifications Section -->
        <section class="notifications-section">
            <h2>Notifications</h2>
            <ul class="notifications-list">
                <li class="notification-item">
                    <span class="notification-icon blue">
                        <i class="fa fa-tag"></i>
                    </span>
                    <div class="notification-content">
                        <p>Nouvelle remise disponible chez Hôtel Marriot</p>
                        <span class="notification-time">Il y a 2 heures</span>
                    </div>
                </li>
                <li class="notification-item">
                    <span class="notification-icon yellow">
                        <i class="fa fa-exclamation-circle"></i>
                    </span>
                    <div class="notification-content">
                        <p>Rappel : Votre abonnement expire dans 15 jours</p>
                        <span class="notification-time">Il y a 1 jour</span>
                    </div>
                </li>
                <li class="notification-item">
                    <span class="notification-icon green">
                        <i class="fa fa-calendar-check-o"></i>
                    </span>
                    <div class="notification-content">
                        <p>Invitation à l'événement de bénévolat "Nettoyage des Plages à Aïn Taya"</p>
                        <span class="notification-time">Il y a 2 jours</span>
                    </div>
                </li>
            </ul>
        </section>
        <script>
            function openTab(evt, tabName) {
                const tabContents = document.querySelectorAll('.tab-content');
                const tabLinks = document.querySelectorAll('.tab-link');

                // Hide all tab contents
                tabContents.forEach((content) => content.classList.remove('active'));

                // Remove active class from all tab links
                tabLinks.forEach((link) => link.classList.remove('active'));

                // Show the current tab content and add active class to clicked tab
                document.getElementById(tabName).classList.add('active');
                evt.currentTarget.classList.add('active');
            }

            document.addEventListener("DOMContentLoaded", () => {
                const tabs = document.querySelectorAll(".tab-link");
                const tabContents = document.querySelectorAll(".tab-content");

                tabs.forEach((tab) => {
                    tab.addEventListener("click", () => {
                        // Remove active class from all tabs and contents
                        tabs.forEach((t) => t.classList.remove("active"));
                        tabContents.forEach((content) => content.classList.remove("active"));

                        // Add active class to the clicked tab and the corresponding content
                        tab.classList.add("active");
                        document.getElementById(tab.getAttribute("data-tab")).classList.add("active");
                    });
                });
            });
        </script>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
    <script>
        function toggleEditForm() {
            const editForm = document.getElementById('edit-form');
            if (editForm.style.display === 'none') {
                editForm.style.display = 'block';
            } else {
                editForm.style.display = 'none';
            }
        }
    </script>
</body>
</html>