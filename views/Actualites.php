<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualités et Événements</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
     <!-- Navbar -->
     <?php include 'navbar.php'; ?>

    <main class="news-page">
        <h1>Actualités et Événements</h1>
        <div class="news-container">
            <div class="news-card">
                <img src="image1.jpg" alt="Une Histoire de Réussite">
                <h3>Une Histoire de Réussite</h3>
                <p>Comment notre communauté a transformé la vie de Marie...</p>
                <a href="#" class="btn">Lire plus</a>
            </div>
            <div class="news-card">
                <img src="image2.jpg" alt="Impact Communautaire">
                <h3>Impact Communautaire</h3>
                <p>Découvrez comment nos bénévoles ont créé un changement...</p>
                <a href="#" class="btn">Lire plus</a>
            </div>
            <div class="news-card">
                <img src="image3.jpg" alt="Projet Réussi">
                <h3>Projet Réussi</h3>
                <p>Le projet de rénovation du centre communautaire est terminé...</p>
                <a href="#" class="btn">Lire plus</a>
            </div>
            <div class="news-card">
                <img src="image4.jpg" alt="Une Histoire Inspirante">
                <h3>Une Histoire Inspirante</h3>
                <p>Marie, 8 ans, a pu bénéficier d'une opération grâce à vos dons...</p>
                <a href="#" class="btn">Lire plus</a>
            </div>
        </div>
    </main>

   <!-- Footer -->
   <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>
