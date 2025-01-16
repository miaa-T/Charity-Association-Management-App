<?php
class CarteMembreView {
    public function render($membre) {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }

        require_once __DIR__ . '/../../controllers/MembresController.php';
        $membreController = new MembreController();
        $membre = $membreController->getMemberById($_SESSION['user_id']);

        if (!$membre) {
            die("Erreur : Impossible de charger les informations du membre.");
        }
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>El Mountada - Carte Membre</title>
            <link rel="stylesheet" href="styles.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <style>
                .card-container {
                    width: 800px;
                    padding: 40px;
                    background: white;
                    border-radius: 20px;
                    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                }
                .card {
                    width: 100%;
                    height: 400px;
                    background: linear-gradient(to bottom right, #e8f5e9, #f1f8e9);
                    border-radius: 15px;
                    padding: 30px;
                    position: relative;
                    display: grid;
                    grid-template-columns: 1fr auto;
                    gap: 30px;
                }
                .left-section {
                    display: flex;
                    flex-direction: column;
                    gap: 20px;
                }
                .description {
                    font-size: 1em;
                    color: #333;
                    max-width: 400px;
                    line-height: 1.4;
                }
                .member-info {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 20px;
                    margin-top: 20px;
                }
                .info-item {
                    display: flex;
                    flex-direction: column;
                    gap: 5px;
                }
                .label {
                    color: #666;
                    font-size: 0.9em;
                }
                .value {
                    color: #000;
                    font-weight: bold;
                    font-size: 1.1em;
                }
                .right-section {
                    display: flex;
                    flex-direction: column;
                    gap: 20px;
                    align-items: center;
                }
                .qr-code {
                    width: 150px;
                    height: 150px;
                    padding: 10px;
                    background: white;
                    border-radius: 10px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                }
                .qr-code img {
                    width: 100%;
                    height: 100%;
                }
            </style>
        </head>
        <body>
            <div class="card-container">
                <div class="card">
                    <div class="left-section">
                        <div class="logo">
                            <img src="../Images/logo_elmountada.png" alt="El Mountada">
                        </div>
                        <div class="description">
                            Nous sommes une organisation caritative dédiée à apporter du soutien aux communautés locales et à créer un impact durable.
                        </div>
                        <div class="member-info">
                            <div class="info-item">
                                <div class="label">ID Membre</div>
                                <div class="value"><?php echo htmlspecialchars($membre['id']); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="label">Nom Complet</div>
                                <div class="value"><?php echo htmlspecialchars($membre['prenom'] . ' ' . $membre['nom']); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="label">Type de Carte</div>
                                <div class="value"><?php echo htmlspecialchars($membre['nom_type_abonnement']); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="label">Date d'Expiration</div>
                                <div class="value"><?php echo htmlspecialchars($membre['date_expiration']); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="right-section">
                        <div class="qr-code">
                            <img src="../../generate_qr.php?id=<?php echo htmlspecialchars($membre['id']); ?>" alt="QR Code">
                        </div