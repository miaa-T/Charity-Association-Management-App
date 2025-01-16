<?php
session_start();

require_once 'config.php';
$database = new Database();
$conn = $database->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_utilisateur = cleanInput($_POST['nom_utilisateur']);
    $mot_de_passe = cleanInput($_POST['mot_de_passe']);

    $query = "SELECT * FROM administrateurs WHERE nom_utilisateur = :nom_utilisateur";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nom_utilisateur', $nom_utilisateur);
    $stmt->execute();

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($mot_de_passe, $admin['mot_de_passe'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['nom_utilisateur'] = $admin['nom_utilisateur'];
        $_SESSION['role'] = $admin['role'];

        header('Location: dashboard.php');
        exit();
    } else {
        $_SESSION['error'] = "Nom d'utilisateur ou mot de passe incorrect. Veuillez réessayer.";
        header('Location: login_kjhsfblzqiuhrqbli.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
</head>
<body>
    <h2>Connexion Administrateur</h2>

    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);
    }
    ?>

    <form action="login_kjhsfblzqiuhrqbli.php" method="post">
        <label for="nom_utilisateur">Nom d'utilisateur:</label>
        <input type="text" id="nom_utilisateur" name="nom_utilisateur" required>
        <br>
        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        <br>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>