<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<header class="navbar">
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="logo">
        <a href="index.php"><img src="Images/logo_elmountada.png" alt="Logo"></a>
    </div>
    <nav>
        <ul class="nav-links">
              <li><a href="index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">Acceuil</a></li>
            <li><a href="Actualites.php" class="<?= $current_page == 'Actualites.php' ? 'active' : '' ?>">Actualités</a></li>
            <li><a href="partenaires.php" class="<?= $current_page == 'partenaires.php' ? 'active' : '' ?>">Partenaires</a></li>
            <li><a href="remises.php" class="<?= $current_page == 'remises.php' ? 'active' : '' ?>">Remises et Avantages</a></li>
            <li><a href="dons.php" class="<?= $current_page == 'dons.php' ? 'active' : '' ?>">Donations</a></li>
        </ul>
    </nav>
    <div class="social-icons">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-instagram"></i></a>
    </div>
    <div class="profile-pic">
        <a href="monprofile.php">
            <img src="Images/userPic.jpg" alt="Profile Picture">
        </a>
    </div>
</header>
