<?php
class DonsView {
    public function render($types_aide, $dons = [], $evenements = []) {
        session_start();
        $current_page = basename($_SERVER['PHP_SELF']);
        $isUserLoggedIn = isset($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['montant'])) {
            // Le contrôleur DonController.php gère la soumission du formulaire
            // Vous pouvez rediriger l'utilisateur ou afficher un message de succès/erreur ici
        }
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Donations</title>
            <link rel="stylesheet" href="styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        </head>
        <body>
            <!-- Navbar -->
            <?php include 'navbar.php'; ?>

            <!-- Donations Section -->
            <main class="donations-page">
                <section class="donations-header">
                    <h1>Faites un Don pour Soutenir Nos Actions</h1>
                    <p>Chaque contribution compte pour faire la différence.</p>
                </section>

                <!-- Make a Donation -->
                <section class="make-donation-section">
                    <h2>Faire un don</h2>
                    <div class="donation-instructions">
                        <p>
                            Pour faire un don, veuillez effectuer un virement bancaire au compte CCP de l'association.
                            Une fois le virement effectué, téléversez le reçu ci-dessous pour finaliser votre don.
                        </p>
                        <p><strong>Numéro de CCP :</strong> 123456789</p>
                        <p><strong>Clé :</strong> 25</p>
                        <p><strong>Titulaire du compte :</strong> Association El Mountada</p>
                    </div>
                    <form class="donation-form" action="" method="POST" enctype="multipart/form-data">
                        <label for="donation-amount">Montant du don</label>
                        <input type="number" id="donation-amount" name="montant" placeholder="Montant du don" required>
                        <label for="donation-document">Reçu de virement</label>
                        <input type="file" id="donation-document" name="recu" accept=".pdf,.jpg,.png" required>
                        <button type="submit" class="donation-submit-btn">Envoyer Mon Don</button>
                    </form>
                </section>

                <!-- Donation History -->
                <h2>Historique des Dons</h2>
                <?php include 'dons_histo.php'; ?>

                <!-- Volunteer Section -->
                <?php if ($isUserLoggedIn): ?>
                    <section class="volunteer-section">
                        <h2>Devenir Bénévole</h2>
                        <form class="volunteer-form" id="volunteerForm">
                            <div class="form-group">
                                <input type="text" name="nom" placeholder="Nom" required>
                                <input type="text" name="prenom" placeholder="Prénom" required>
                            </div>
                            <label for="activity">Activité souhaitée</label>
                            <select id="activity" name="evenement" required>
                                <option value="" disabled selected>Choisir une activité</option>
                                <?php if (!empty($evenements)): ?>
                                    <?php foreach ($evenements as $evenement): ?>
                                        <option value="<?php echo htmlspecialchars($evenement['id']); ?>">
                                            <?php echo htmlspecialchars($evenement['nom']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <label for="availability">Disponibilités</label>
                            <input type="date" id="availability" name="date_disponibilite" required>
                            <button type="submit" class="volunteer-submit-btn">S'inscrire comme Bénévole</button>
                        </form>
                        <div id="volunteerMessage" style="display: none;"></div>
                    </section>
                <?php endif; ?>

                <!-- Request Assistance Section -->
                <section class="assistance-request-section">
                    <h2>Demande d'Aide</h2>
                    <p class="remarque">Remarque : Veuillez combiner tous vos documents dans un seul fichier PDF à soumettre.</p>
                    <form id="assistanceForm" class="assistance-form" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="text" name="nom" placeholder="Nom du bénéficiaire" required>
                            <input type="text" name="prenom" placeholder="Prénom du bénéficiaire" required>
                        </div>
                        <label for="birth-date">Date de naissance</label>
                        <input type="date" id="birth-date" name="date_naissance" required>
                        <label for="aid-type">Type d'aide</label>
                        <select id="aid-type" name="type_aide" required>
                            <option value="" disabled selected>Choisir un type</option>
                            <?php foreach ($types_aide as $aide): ?>
                                <option value="<?php echo $aide['type_aide']; ?>"><?php echo $aide['type_aide']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="needs-description">Description des besoins</label>
                        <textarea id="needs-description" name="description" rows="4" placeholder="Décrivez les besoins" required></textarea>
                        <label for="numero-identite">Numéro d'identité</label>
                        <input type="text" id="numero-identite" name="numero_identite" placeholder="Numéro d'identité" required>
                        <label for="numero-telephone">Numéro de téléphone</label>
                        <input type="text" id="numero-telephone" name="numero_telephone" placeholder="Numéro de téléphone" required>
                        <label for="assistance-document">Documents justificatifs</label>
                        <input type="file" id="assistance-document" name="fichier" required>
                        <button type="submit" class="assistance-submit-btn">Soumettre la Demande</button>
                    </form>
                    <div id="assistanceMessage" style="display: none;"></div>
                </section>

                <!-- Available Aid Section -->
                <section class="aid-types-section">
                    <h2>Types d'Aide Disponibles</h2>
                    <div class="aid-types-grid">
                        <?php if (!empty($types_aide)): ?>
                            <?php foreach ($types_aide as $aide): ?>
                                <div class="aid-card">
                                    <h3><i class="fa fa-home"></i> <?php echo htmlspecialchars($aide['type_aide']); ?></h3>
                                    <p><?php echo htmlspecialchars($aide['description']); ?></p>
                                    <p><strong>Documents requis:</strong> <?php echo htmlspecialchars($aide['documents_necessaires']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucun type d'aide disponible pour le moment.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </main>

            <!-- Footer -->
            <?php include 'footer.php'; ?>

            <style>
                .make-donation-section {
                    background-color: #ffffff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    margin-bottom: 20px;
                }

                .make-donation-section h2 {
                    font-size: 2rem;
                    color: #2c3e50;
                    margin-bottom: 20px;
                }

                .donation-instructions {
                    background-color: #f8f8f8;
                    padding: 15px;
                    border-radius: 8px;
                    margin-bottom: 20px;
                    border: 1px solid #e0e0e0;
                }

                .donation-instructions p {
                    font-size: 1rem;
                    color: #34495e;
                    line-height: 1.6;
                    margin-bottom: 10px;
                }

                .donation-instructions strong {
                    color: #2c3e50;
                }

                .donation-form {
                    display: flex;
                    flex-direction: column;
                    gap: 15px;
                }

                .donation-form label {
                    font-size: 1rem;
                    color: #2c3e50;
                    font-weight: bold;
                }

                .donation-form input[type="number"],
                .donation-form input[type="file"] {
                    padding: 10px;
                    border: 1px solid #e0e0e0;
                    border-radius: 5px;
                    font-size: 1rem;
                    color: #34495e;
                    background-color: #ffffff;
                }

                .donation-form input[type="number"]:focus,
                .donation-form input[type="file"]:focus {
                    border-color: #3498db;
                    outline: none;
                }

                .donation-submit-btn {
                    padding: 12px 20px;
                    background-color: #3498db;
                    color: #ffffff;
                    border: none;
                    border-radius: 5px;
                    font-size: 1rem;
                    cursor: pointer;
                    transition: background-color 0.3s ease;
                }

                .donation-submit-btn:hover {
                    background-color: #2980b9;
                }

                .remarque {
                    font-size: 0.9rem;
                    color: #555;
                    background-color: #f9f9f9;
                    padding: 10px;
                    border-left: 4px solid #3498db;
                    margin-bottom: 20px;
                    border-radius: 4px;
                }
            </style>

            <script>
                document.getElementById('assistanceForm').addEventListener('submit', function (e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    fetch('../../controllers/AideController.php?action=handleAssistanceRequest', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        const messageDiv = document.getElementById('assistanceMessage');
                        messageDiv.style.display = 'block';
                        messageDiv.textContent = data.message;
                        messageDiv.style.color = data.success ? 'green' : 'red';
                        if (data.success) {
                            setTimeout(() => {
                                messageDiv.style.display = 'none';
                                document.getElementById('assistanceForm').reset();
                            }, 3000);
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
                });

                document.getElementById('volunteerForm').addEventListener('submit', function (e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    fetch("../../controllers/BenevoleController.php", {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        const messageDiv = document.getElementById('volunteerMessage');
                        messageDiv.style.display = 'block';
                        messageDiv.textContent = data;
                        setTimeout(() => {
                            messageDiv.style.display = 'none';
                            document.getElementById('volunteerForm').reset();
                        }, 3000);
                    })
                    .catch(error => console.error('Erreur:', error));
                });
            </script>
        </body>
        </html>
        <?php
    }
}
?>