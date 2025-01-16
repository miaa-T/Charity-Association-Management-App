<?php
class ActualitesView {
    public function render($actualites, $evenements, $message = '') {
        session_start();
        $current_page = basename($_SERVER['PHP_SELF']);

        require_once __DIR__ . '/../../controllers/EvenementsActualitesController.php';
        require_once __DIR__ . '/../../models/Benevolat.php';
        require_once __DIR__ . '/../../models/db.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['participer'])) {
            $evenement_id = $_POST['evenement_id'];

            $database = new Database();
            $conn = $database->connect();

            $benevole = new Benevolat($conn);
            $benevole->id_membre = $_SESSION['user_id'];
            $benevole->evenement_id = $evenement_id;
            $benevole->id_statut_benevolat = 1;

            if ($benevole->create()) {
                $_SESSION['message'] = "Vous êtes bien inscrit à cet événement. Merci pour votre engagement !";
            } else {
                $_SESSION['message'] = "Une erreur s'est produite lors de l'enregistrement de votre participation.";
            }

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }

        $message = '';
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }

        $controller = new EvenementsActualitesController();
        $actualites = $controller->getAllActualites();
        $evenements = $controller->getAllEvenements();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Actualités et Événements</title>
            <link rel="stylesheet" href="styles.css">
            <style>
                .message {
                    padding: 10px;
                    margin: 20px 0;
                    border-radius: 5px;
                    text-align: center;
                    font-weight: bold;
                }
                .message.success {
                    background-color: #d4edda;
                    color: #155724;
                    border: 1px solid #c3e6cb;
                }
                .message.error {
                    background-color: #f8d7da;
                    color: #721c24;
                    border: 1px solid #f5c6cb;
                }
                .modal {
                    display: none;
                    position: fixed;
                    z-index: 1000;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    overflow: auto;
                    background-color: rgba(0, 0, 0, 0.5);
                }
                .modal-content {
                    background-color: #fff;
                    margin: 10% auto;
                    padding: 20px;
                    border: 1px solid #888;
                    width: 80%;
                    max-width: 600px;
                    border-radius: 10px;
                    position: relative;
                }
                .close {
                    position: absolute;
                    right: 15px;
                    top: 10px;
                    font-size: 24px;
                    font-weight: bold;
                    cursor: pointer;
                }
                .close:hover {
                    color: #f00;
                }
            </style>
        </head>
        <body>
            <?php include 'navbar.php'; ?>
            <main class="news-page">
                <h1>Actualités et Événements</h1>
                <?php if (isset($message)): ?>
                    <div class="message"><?php echo $message; ?></div>
                <?php endif; ?>

                <h2>Actualités</h2>
                <div class="news-container">
                    <?php foreach ($actualites as $actualite): ?>
                        <div class="news-card">
                            <img src="<?php echo htmlspecialchars($actualite['image']); ?>" alt="<?php echo htmlspecialchars($actualite['titre']); ?>">
                            <h3><?php echo htmlspecialchars($actualite['titre']); ?></h3>
                            <p><?php echo htmlspecialchars($actualite['description']); ?></p>
                            <a href="#" class="btn">Lire plus</a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <h2>Événements</h2>
                <div class="news-container">
                    <?php foreach ($evenements as $evenement): ?>
                        <div class="news-card">
                            <img src="<?php echo htmlspecialchars($evenement['image']); ?>" alt="<?php echo htmlspecialchars($evenement['nom']); ?>">
                            <h3><?php echo htmlspecialchars($evenement['nom']); ?></h3>
                            <p><?php echo htmlspecialchars($evenement['description']); ?></p>
                            <p><strong>Date :</strong> <?php echo htmlspecialchars($evenement['date_debut']); ?> - <?php echo htmlspecialchars($evenement['date_fin']); ?></p>
                            <button class="btn lire-plus" data-evenement-id="<?php echo $evenement['id']; ?>">Lire plus</button>
                            <form method="POST" action="">
                                <input type="hidden" name="evenement_id" value="<?php echo $evenement['id']; ?>">
                                <button type="submit" name="participer" class="btn">Participer</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div id="evenementModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2 id="modal-titre"></h2>
                        <img id="modal-image" src="" alt="Image de l'événement">
                        <p id="modal-description"></p>
                        <p><strong>Date de début :</strong> <span id="modal-date-debut"></span></p>
                        <p><strong>Date de fin :</strong> <span id="modal-date-fin"></span></p>
                    </div>
                </div>
            </main>
            <?php include 'footer.php'; ?>
            <script>
                const modal = document.getElementById('evenementModal');
                const modalTitre = document.getElementById('modal-titre');
                const modalImage = document.getElementById('modal-image');
                const modalDescription = document.getElementById('modal-description');
                const modalDateDebut = document.getElementById('modal-date-debut');
                const modalDateFin = document.getElementById('modal-date-fin');

                const lirePlusButtons = document.querySelectorAll('.lire-plus');
                lirePlusButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const evenementId = this.getAttribute('data-evenement-id');
                        fetch(`getEvenementDetails.php?id=${evenementId}`)
                            .then(response => response.json())
                            .then(data => {
                                modalTitre.textContent = data.nom;
                                modalImage.src = data.image;
                                modalDescription.textContent = data.description;
                                modalDateDebut.textContent = data.date_debut;
                                modalDateFin.textContent = data.date_fin;
                                modal.style.display = 'block';
                            })
                            .catch(error => console.error('Erreur :', error));
                    });
                });

                document.querySelector('.close').addEventListener('click', function () {
                    modal.style.display = 'none';
                });

                window.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        modal.style.display = 'none';
                    }
                });
            </script>
        </body>
        </html>
        <?php
    }
}
?>