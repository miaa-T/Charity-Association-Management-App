<!-- Donation History -->
<?php if ($isUserLoggedIn): ?>
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
                <?php if (!empty($dons)): ?>
                    <?php foreach ($dons as $don): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($don['date_don']); ?></td>
                            <td><?php echo htmlspecialchars($don['montant']); ?> DA</td>
                            <td><?php echo htmlspecialchars($don['id']); ?></td>
                            <td>
                                <!-- Afficher le statut avec une classe CSS dynamique -->
                                <span class="status <?php echo htmlspecialchars(strtolower(str_replace(' ', '-', $don['statut']))); ?>">
                                    <?php echo htmlspecialchars($don['statut']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($don['recu'])): ?>
                                    <a href="<?php echo htmlspecialchars($don['recu']); ?>" class="download-receipt" download>
                                        <i class="fa fa-download"></i> Télécharger
                                    </a>
                                <?php else: ?>
                                    <span class="no-receipt">Aucun reçu</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Aucun don enregistré pour le moment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
    <style>/* Styles pour la section Historique des Dons */
.donation-history-section {
    margin-top: 20px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.donation-history-section h2 {
    font-size: 1.5rem;
    color: #2c3e50;
    margin-bottom: 20px;
}

/* Styles pour le tableau */
.table {
    width: 100%;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.table th {
    background-color: #3498db;
    color: white;
}

.table tbody tr:hover {
    background-color: #f1f1f1;
}

/* Styles pour les statuts */
.status {
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.9rem;
    font-weight: bold;
    text-transform: capitalize;
}

.status.validé {
    background-color: #d4edda;
    color: #155724;
}

.status.en-attente {
    background-color: #fff3cd;
    color: #856404;
}

.status.rejeté {
    background-color: #f8d7da;
    color: #721c24;
}

/* Styles pour le lien de téléchargement */
.download-receipt {
    color: #3498db;
    text-decoration: none;
}

.download-receipt:hover {
    text-decoration: underline;
}

/* Styles pour les cas où il n'y a pas de reçu */
.no-receipt {
    color: #888;
    font-style: italic;
}</style>
<?php endif; ?>