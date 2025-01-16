<?php
class PartenairesView {
    public function render($groupedPartners) {
        session_start();
        $current_page = basename($_SERVER['PHP_SELF']);
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Partenaires</title>
            <link rel="stylesheet" href="styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        </head>
        <body>
            <!-- Navbar -->
            <?php include 'navbar.php'; ?>

            <!-- Partners Page Section -->
            <main class="partners-page-section">
                <h2>Catalogue des Partenaires</h2>

                <?php foreach ($groupedPartners as $category => $partners): ?>
                    <div class="partners-page-category">
                        <h3><?php echo htmlspecialchars($category); ?></h3>
                        <div class="partners-page-scroll">
                            <?php foreach ($partners as $partner): ?>
                                <div class="partners-page-card">
                                    <h4><?php echo htmlspecialchars($partner['nom']); ?></h4>
                                    <p><?php echo htmlspecialchars($partner['ville']); ?></p>
                                    <p><?php echo htmlspecialchars($partner['remise']) . '%'; ?></p>
                                    <p><?php echo htmlspecialchars($partner['details']); ?></p>
                                    <button class="partners-page-btn" onclick="openPopup(<?php echo htmlspecialchars(json_encode($partner)); ?>)">Plus de détails</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </main>

            <!-- Popup Structure -->
            <div id="partnerPopup" class="popup">
                <div class="popup-content">
                    <span class="close-btn" onclick="closePopup()">&times;</span>
                    <h2 id="popupName"></h2>
                    <p><strong>Ville:</strong> <span id="popupCity"></span></p>
                    <p><strong>Remise:</strong> <span id="popupDiscount"></span></p>
                    <p><strong>Détails:</strong> <span id="popupDetails"></span></p>
                    <p><strong>Description:</strong> <span id="popupDescription"></span></p>
                    <p><strong>Catégorie:</strong> <span id="popupCategory"></span></p>
                    <p><strong>Logo:</strong> <img id="popupLogo" src="" alt="Logo" style="max-width: 100px;"></p>
                    <p><strong>Créé le:</strong> <span id="popupCreatedAt"></span></p>
                    <p><strong>Modifié le:</strong> <span id="popupUpdatedAt"></span></p>
                </div>
            </div>

            <!-- Footer -->
            <?php include 'footer.php'; ?>

            <script>
                function openPopup(partner) {
                    document.getElementById('popupName').innerText = partner.nom;
                    document.getElementById('popupCity').innerText = partner.ville;
                    document.getElementById('popupDiscount').innerText = partner.remise + '%';
                    document.getElementById('popupDetails').innerText = partner.details;
                    document.getElementById('popupDescription').innerText = partner.description;
                    document.getElementById('popupCategory').innerText = (partner.categorie_nom || 'N/A');
                    document.getElementById('popupLogo').src = partner.logo || 'default_logo.png';
                    document.getElementById('popupCreatedAt').innerText = (partner.cree_le || 'N/A');
                    document.getElementById('popupUpdatedAt').innerText = (partner.modifie_le || 'N/A');
                    document.getElementById('partnerPopup').style.display = 'flex';
                }

                function closePopup() {
                    document.getElementById('partnerPopup').style.display = 'none';
                }

                window.onclick = function(event) {
                    var popup = document.getElementById('partnerPopup');
                    if (event.target == popup) {
                        popup.style.display = 'none';
                    }
                }
            </script>

            <style>
                .popup {
                    display: none;
                    position: fixed;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                    justify-content: center;
                    align-items: center;
                    z-index: 1000;
                }

                .popup-content {
                    background-color: white;
                    padding: 20px;
                    border-radius: 10px;
                    width: 50%;
                    max-width: 600px;
                    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
                    position: relative;
                }

                .close-btn {
                    position: absolute;
                    right: 10px;
                    top: 10px;
                    font-size: 24px;
                    cursor: pointer;
                }

                .close-btn:hover {
                    color: #000;
                }
            </style>
        </body>
        </html>
        <?php
    }
}
?>