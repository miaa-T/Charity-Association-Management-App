<?php
class LoginView {
    public function render() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once __DIR__ . '/../../models/Membre.php';
            require_once __DIR__ . '/../../models/db.php';

            $database = new Database();
            $db = $database->connect();
            $membre = new Membre($db);

            $email = $_POST['email'];
            $mot_de_passe = $_POST['mot_de_passe'];

            $query = "SELECT * FROM membres WHERE email = :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['photo'] = $user['photo'];
                header('Location: index.php');
            } else {
                echo "<script>alert('Email ou mot de passe incorrect.');</script>";
            }
        }
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Connexion</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <div class="login-container">
                <h2>Connexion</h2>
                <form method="post" action="login.php">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <label for="mot_de_passe">Mot de passe:</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" required>
                    <button type="submit">Connexion</button>
                </form>
                <div class="register-link">
                    <span>Pas encore de compte? </span>
                    <a href="inscriptionMembre.php">S'inscrire</a>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}
?>