<?php
session_start(); // Start the session
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
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
            <form class="donation-form">
                <label for="donation-amount">Montant du don</label>
                <input type="number" id="donation-amount" placeholder="Montant du don" required>

                <label for="donation-document">Documents justificatifs</label>
                <input type="file" id="donation-document">

                <button type="submit" class="donation-submit-btn">Envoyer Mon Don</button>
            </form>
        </section>

        <!-- Donation History -->
        <section class="donation-history-section">
            <h2>Historique des Dons</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Montant</th>
                        <th>Référence</th>
                        <th>État</th>
                        <th>Reçu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01/01/2025</td>
                        <td>5000 DA</td>
                        <td>#REF001</td>
                        <td><span class="status validated">Validé</span></td>
                        <td><a href="#" class="download-receipt"><i class="fa fa-download"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Volunteer Section -->
        <section class="volunteer-section">
            <h2>Devenir Bénévole</h2>
            <form class="volunteer-form">
                <div class="form-group">
                    <input type="text" placeholder="Nom" required>
                    <input type="text" placeholder="Prénom" required>
                </div>

                <label for="activity">Activité souhaitée</label>
                <select id="activity">
                    <option value="" disabled selected>Choisir une activité</option>
                    <option value="distribution">Distribution</option>
                    <option value="logistics">Logistique</option>
                </select>

                <label for="availability">Disponibilités</label>
                <input type="date" id="availability" required>

                <button type="submit" class="volunteer-submit-btn">S'inscrire comme Bénévole</button>
            </form>
        </section>

        <!-- Request Assistance Section -->
        <section class="assistance-request-section">
            <h2>Demande d'Aide</h2>
            <form class="assistance-form">
                <div class="form-group">
                    <input type="text" placeholder="Nom du bénéficiaire" required>
                    <input type="text" placeholder="Prénom du bénéficiaire" required>
                </div>

                <label for="birth-date">Date de naissance</label>
                <input type="date" id="birth-date" required>

                <label for="aid-type">Type d'aide</label>
                <select id="aid-type">
                    <option value="" disabled selected>Choisir un type</option>
                    <option value="food">Aide Alimentaire</option>
                    <option value="financial">Aide Financière</option>
                </select>

                <label for="needs-description">Description des besoins</label>
                <textarea id="needs-description" rows="4" placeholder="Décrivez les besoins"></textarea>

                <label for="assistance-document">Documents justificatifs</label>
                <input type="file" id="assistance-document">

                <button type="submit" class="assistance-submit-btn">Soumettre la Demande</button>
            </form>
        </section>

       <!-- Available Aid Section -->
<section class="aid-types-section">
    <h2>Types d'Aide Disponibles</h2>
    <div class="aid-types-grid">
        <div class="aid-card">
            <h3><i class="fa fa-home"></i> Logement</h3>
            <p>Aide à l'hébergement temporaire et accompagnement dans la recherche de logement.</p>
            <p><strong>Documents requis:</strong> Pièce d'identité, justificatif de situation.</p>
        </div>
        <div class="aid-card">
            <h3><i class="fa fa-heart"></i> Soins</h3>
            <p>Accès aux soins médicaux et aide à l'obtention de couverture santé.</p>
            <p><strong>Documents requis:</strong> Carte vitale, ordonnances médicales.</p>
        </div>
        <div class="aid-card">
            <h3><i class="fa fa-cutlery"></i> Aide Alimentaire</h3>
            <p>Fournit des colis alimentaires ou des bons d'achat pour les familles et individus dans le besoin.</p>
            <p><strong>Documents requis:</strong> Pièce d'identité.</p>
        </div>
        <div class="aid-card">
            <h3><i class="fa fa-graduation-cap"></i> Éducation</h3>
            <p>Soutien scolaire et aide à la formation professionnelle.</p>
            <p><strong>Documents requis:</strong> Certificat de scolarité, bulletins scolaires.</p>
        </div>
        <div class="aid-card">
            <h3><i class="fa fa-shopping-bag"></i> Aide Vestimentaire</h3>
            <p>Distribue des vêtements et chaussures aux individus et familles, notamment durant l'hiver ou en période de crise.</p>
            <p><strong>Documents requis:</strong> Pièce d'identité.</p>
        </div>
        <div class="aid-card">
            <h3><i class="fa fa-money"></i> Aide Financière</h3>
            <p>Offre un soutien financier temporaire pour les situations urgentes ou les besoins essentiels.</p>
            <p><strong>Documents requis:</strong> Pièce d'identité, justificatif de situation financière, devis ou facture liée à la demande.</p>
        </div>
    </div>
</section>

    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
