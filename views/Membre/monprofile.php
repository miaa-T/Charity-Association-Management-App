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
            <p>Bienvenue !</p>
        </section>

        <!-- Personal Information Section -->
        <section class="personal-info-section">
            <div class="personal-info-card">
                <div class="info-text">
                    <p><strong>Nom complet:</strong> HADDAD Amina</p>
                    <p><strong>Identifiant:</strong> MEM123456</p>
                    <p><strong>Email:</strong> amina.haddad@email.com</p>
                    <p><strong>Téléphone:</strong> +213 6 12 34 56 78</p>
                    <p><strong>Type de carte:</strong> Premium</p>
                    <p><strong>Expiration:</strong> 31/12/2025</p>
                </div>
                <div class="profile-photo">
                    <img src="../Images/userPic.jpg" alt="Profile Picture">
                </div>
            </div>
            <button class="edit-info-btn">Modifier mes informations</button>
        </section>
        <?php include 'carteMembre.php'; ?>
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
                        <td>Premium</td>
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
    <div class="tab-content" id="activities">
        <table class="history-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type d’Activité</th>
                    <th>Détails</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>10/12/2024</td>
                    <td>Bénévolat</td>
                    <td>Participation à une collecte</td>
                    <td class="status validated">Terminé</td>
                </tr>
                <tr>
                    <td>15/11/2024</td>
                    <td>Demande d’aide</td>
                    <td>Assistance pour frais médicaux</td>
                    <td class="status pending">En cours</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-content" id="paiements">
        <table class="history-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type de Paiement</th>
                    <th>Montant</th>
                    <th>Détails</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01/09/2024</td>
                    <td>Renouvellement d’adhésion</td>
                    <td>4000 DA</td>
                    <td>Abonnement premium</td>
                    <td class="status validated">Confirmé</td>
                </tr>
                <tr>
                    <td>25/01/2024</td>
                    <td>Frais d’inscription initial</td>
                    <td>2000 DA</td>
                    <td>Abonnement classique</td>
                    <td class="status validated">Confirmé</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="tab-content" id="remises">
        <table class="history-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Partenaire</th>
                    <th>Type de Remise</th>
                    <th>Valeur</th>
                    <th>Détails</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>12/12/2024</td>
                    <td>Hôtel AZ</td>
                    <td>Réduction sur séjour</td>
                    <td>30%</td>
                    <td>Séjour de 3 nuits</td>
                </tr>
                <tr>
                    <td>10/11/2024</td>
                    <td>Clinique Santé+</td>
                    <td>Consultation à moitié prix</td>
                    <td>50%</td>
                    <td>Consultation généraliste offerte</td>
                </tr>
            </tbody>
        </table>
    </div>
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
<script>function openTab(evt, tabName) {
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
});</script>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
