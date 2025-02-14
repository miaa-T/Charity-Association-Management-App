<?php
class MonProfileView {
    public function render($member, $dons, $notifications, $remisesDisponibles, $remisesUtilisees) {
        session_start();
        $current_page = basename($_SERVER['PHP_SELF']);
        $isUserLoggedIn = isset($_SESSION['user_id']);

        if (!$isUserLoggedIn) {
            header("Location: login.php");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prenom = htmlspecialchars($_POST['prenom']);
            $nom = htmlspecialchars($_POST['nom']);
            $email = htmlspecialchars($_POST['email']);
            $telephone = htmlspecialchars($_POST['telephone']);

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

            $updateData = [
                'prenom' => $prenom,
                'nom' => $nom,
                'email' => $email,
                'telephone' => $telephone,
                'photo' => $photo
            ];

            require_once __DIR__ . '/../../controllers/MembresController.php';
            $membreController = new MembreController();
            if ($membreController->updateMember($_SESSION['user_id'], $updateData)) {
                $_SESSION['success_message'] = "Vos informations ont été mises à jour avec succès.";
                header("Location: monprofile.php");
                exit();
            } else {
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
            <?php include 'navbar.php'; ?>
            <main class="profile-page">
                <section class="profile-header">
                    <h1>Mon Profil de Membre</h1>
                    <p>Bienvenue, <?php echo htmlspecialchars($member['prenom'] . ' ' . $member['nom']); ?>!</p>
                </section>

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
                            <?php foreach ($remisesDisponibles as $remise): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($member['nom_type_abonnement']); ?></td>
                                    <td><?php echo htmlspecialchars($remise['valeur_remise']); ?></td>
                                    <td><?php echo htmlspecialchars($remise['partenaire_nom']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="rewards-notification">
                        <p>Vous avez accumulé <strong>150 points de fidélité !</strong></p>
                        <button class="renewal-submit-btn"><a href="remises.php">Voir les Offres Spéciales</a></button>
                    </div>
                </section>

                <div class="history-section">
                    <h2>Historique</h2>
                    <div class="tabs">
                        <button class="tab-link active" data-tab="dons">Dons</button>
                        <button class="tab-link" data-tab="activities">Activités</button>
                        <button class="tab-link" data-tab="paiements">Paiements</button>
                        <button class="tab-link" data-tab="remises">Remises</button>
                    </div>
                    <?php include 'dons_histo.php'; ?>
                </div>

                <section class="notifications-section">
                    <h2>Notifications</h2>
                    <ul class="notifications-list">
                        <?php if (!empty($notifications)): ?>
                            <?php foreach ($notifications as $notification): ?>
                                <li class="notification-item">
                                    <span class="notification-icon <?php echo htmlspecialchars(strtolower($notification['type_notification'])); ?>">
                                        <i class="fa <?php echo $notification['icon']; ?>"></i>
                                    </span>
                                    <div class="notification-content">
                                        <p><?php echo htmlspecialchars($notification['titre']); ?></p>
                                        <p><?php echo htmlspecialchars($notification['contenu']); ?></p>
                                        <span class="notification-time">
                                            <?php echo htmlspecialchars($notification['envoye_le']); ?>
                                        </span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="notification-item">
                                <p>Aucune notification pour le moment.</p>
                            </li>
                        <?php endif; ?>
                    </ul>
                </section>

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
            </main>
            <?php include 'footer.php'; ?>
        </body>
        </html>
        <?php
    }
}
?>