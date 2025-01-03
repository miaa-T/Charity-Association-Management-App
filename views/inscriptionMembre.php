<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Registration</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="password"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .radio-group {
            display: flex;
            justify-content: space-around;
            margin-bottom: 15px;
        }

        .file-input {
            border: 1px dashed #ccc;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
        }

        .file-input input[type="file"] {
            display: none;
        }

        .file-label {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #e6e6e6;
            cursor: pointer;
        }

        .checkbox-group {
            margin-bottom: 15px;
        }

        .submit-btn {
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            padding: 20px 0;
            background-color: #333;
            color: white;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

    <div class="container">
        <h1>Member Registration</h1>
        <form action="process_registration.php" method="POST" enctype="multipart/form-data">
            <!-- Section: Personal Information -->
            <h2>Informations Personnelles</h2>
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>

            <div class="form-group">
                <label for="date_naissance">Date de naissance :</label>
                <input type="date" id="date_naissance" name="date_naissance" required>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone :</label>
                <input type="text" id="telephone" name="telephone" required>
            </div>

            <div class="form-group">
                <label for="ville">Ville :</label>
                <input type="text" id="ville" name="ville" required>
            </div>

            <div class="form-group">
                <label for="code_postal">Code postal :</label>
                <input type="text" id="code_postal" name="code_postal" required>
            </div>

            <div class="form-group">
                <label for="adresse_complete">Adresse complète :</label>
                <textarea id="adresse_complete" name="adresse_complete" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <div class="form-group">
                <label for="confirmation_mot_de_passe">Confirmation du mot de passe :</label>
                <input type="password" id="confirmation_mot_de_passe" name="confirmation_mot_de_passe" required>
            </div>

            <!-- Section: Type of Card -->
            <h2>Type de Carte d'Abonnement</h2>
            <div class="radio-group">
                <label>
                    <input type="radio" name="type_carte" value="Classique" required> Classique
                </label>
                <label>
                    <input type="radio" name="type_carte" value="Jeunes"> Jeunes
                </label>
                <label>
                    <input type="radio" name="type_carte" value="Premium"> Premium
                </label>
            </div>

            <!-- Section: File Uploads -->
            <h2>Documents à Télécharger</h2>
            <div class="form-group">
                <label class="file-label" for="photo_profil">Photo de profil :</label>
                <input class="file-input" type="file" id="photo_profil" name="photo_profil" accept="image/*" required>
            </div>

            <div class="form-group">
                <label class="file-label" for="piece_identite">Pièce d'identité :</label>
                <input class="file-input" type="file" id="piece_identite" name="piece_identite" accept=".pdf,.jpg,.png" required>
            </div>

            <div class="form-group">
                <label class="file-label" for="recu_paiement">Reçu de paiement :</label>
                <input class="file-input" type="file" id="recu_paiement" name="recu_paiement" accept=".pdf,.jpg,.png" required>
            </div>

            <!-- Consent and Submit -->
            <div class="checkbox-group">
                <label>
                    <input type="checkbox" name="consentement" required> J'accepte les termes et conditions générales
                </label>
            </div>

            <button type="submit" class="submit-btn">S'inscrire</button>
        </form>
    </div>

    
    <?php include 'footer.php'; ?>
    

</body>
</html>
