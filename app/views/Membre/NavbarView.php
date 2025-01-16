<?php
class NavbarView {
    public function render() {
        $current_page = basename($_SERVER['PHP_SELF']);
        ?>
        <head><link rel="stylesheet" href="styles.css"></head>
        <header class="navbar">
            <div class="logo">
                <a href="index.php"><img src="../Images/logo_elmountada.png" alt="Logo"></a>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">Accueil</a></li>
                    <li><a href="Actualites.php" class="<?= $current_page == 'Actualites.php' ? 'active' : '' ?>">Actualités et Evenements</a></li>
                    <li><a href="partenaires.php" class="<?= $current_page == 'partenaires.php' ? 'active' : '' ?>">Partenaires</a></li>
                    <li><a href="remises.php" class="<?= $current_page == 'remises.php' ? 'active' : '' ?>">Remises et Avantages</a></li>
                    <li><a href="dons.php" class="<?= $current_page == 'dons.php' ? 'active' : '' ?>">Dons</a></li>
                </ul>
            </nav>
            <div class="social-icons">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
            </div>
            <div class="profile-pic">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="profile-container">
                        <img src="<?= $_SESSION['photo'] ?>" alt="Profile Picture" id="profile-pic">
                        <div class="profile-popup" id="profile-popup">
                            <a href="monprofile.php">Mon profil</a>
                            <a href="carteMembre.php">Ma carte membre</a> 
                            <a href="logout.php">Déconnexion</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="connexion-btn">Connexion</a>
                <?php endif; ?>
            </div>
        </header>
        <script>
            document.getElementById('profile-pic').addEventListener('click', function(event) {
                event.stopPropagation();
                const popup = document.getElementById('profile-popup');
                popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', function(event) {
                const popup = document.getElementById('profile-popup');
                if (event.target !== popup && !popup.contains(event.target)) {
                    popup.style.display = 'none';
                }
            });
        </script>
        <?php
    }
}
?>