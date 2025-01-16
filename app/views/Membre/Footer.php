<?php
class FooterView {
    public function render() {
        ?>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <footer class="footer-section">
            <div class="footer-container">
                <div class="footer-column">
                    <h4>À propos de l’association</h4>
                    <p>
                        Nous sommes une organisation caritative dédiée à apporter du soutien aux communautés locales et à créer un impact durable.
                    </p>
                </div>
                <div class="footer-column">
                    <h4>Nous contacter</h4>
                    <p>
                        <a href="mailto:contact@association.org">contact@association.org</a><br>
                        <a href="tel:+213123456789">+213 123 456 789</a><br>
                        123 Rue, Beb Ezzouar, Algérie
                    </p>
                </div>
                <div class="footer-column">
                    <h4>Suivez-nous</h4>
                    <div class="social-icons">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-linkedin"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 El Mountada. Tous droits réservés.</p>
            </div>
        </footer>
        <?php
    }
}
?>