<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_utilisateur = htmlspecialchars($_POST['nom_utilisateur']);
    $mot_de_passe = htmlspecialchars($_POST['mot_de_passe']);

    // Connexion à la base de données
    require_once __DIR__ . '/../../models/db.php';
    $database = new Database();
    $db = $database->connect();

    // Vérification des informations de connexion
    $query = "SELECT * FROM compte_partenaire WHERE nom_utilisateur = :nom_utilisateur";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':nom_utilisateur', $nom_utilisateur);
    $stmt->execute();
    $compte = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($compte && password_verify($mot_de_passe, $compte['mot_de_passe'])) {
        $_SESSION['partenaire_id'] = $compte['partenaire_id'];
        header("Location: verification_membre.php");
        exit();
    } else {
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Partenaire</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Connexion Partenaire</h2>
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form action="login_partenaire.php" method="POST">
            <label for="nom_utilisateur">Nom d'utilisateur:</label>
            <input type="text" id="nom_utilisateur" name="nom_utilisateur" required>

            <label for="mot_de_passe">Mot de passe:</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>

            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>