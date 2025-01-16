<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Association</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="admin-style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Interface Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarAdmin">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_partenaires.php">Partenaires</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_actualites.php">Actualites</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_membres.php">Membres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_dons.php">Dons</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="notifications.php">Notifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion__demandes_aides.php">Demandes d'Aides</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="gestion_offres.php">Offres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="parametres.php">Paramètres</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="login_kjhsfblzqiuhrqbli.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

 
    <!-- Ajouter ce code dans la section <head> ou avant la fermeture de </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Gérer le clic sur le bouton "Détails"
    $('.btn-details').on('click', function(e) {
        e.preventDefault(); // Empêcher le comportement par défaut du lien

        var memberId = $(this).data('id'); // Récupérer l'ID du membre

        // Faire une requête AJAX pour récupérer les détails du membre
        $.ajax({
            url: 'MembreController.php',
            type: 'GET',
            data: {
                action: 'get_member_details_json',
                id: memberId
            },
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    // Afficher les détails dans un popup
                    var details = `
                        <p><strong>Prénom:</strong> ${response.prenom}</p>
                        <p><strong>Nom:</strong> ${response.nom}</p>
                        <p><strong>Email:</strong> ${response.email}</p>
                        <p><strong>Téléphone:</strong> ${response.telephone}</p>
                        <p><strong>Adresse:</strong> ${response.adresse}</p>
                        <p><strong>Type d'abonnement:</strong> ${response.nom_type_abonnement}</p>
                        <p><strong>Date d'inscription:</strong> ${response.date_inscription}</p>
                        <p><strong>Date d'expiration:</strong> ${response.date_expiration}</p>
                        <p><strong>Statut:</strong> ${response.statut}</p>
                    `;
                    $('#memberDetailsPopup .modal-body').html(details);
                    $('#memberDetailsPopup').modal('show');
                }
            },
           
        });
    });
});
</script>

<!-- Ajouter ce code pour le popup -->
<div class="modal fade" id="memberDetailsPopup" tabindex="-1" role="dialog" aria-labelledby="memberDetailsPopupLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberDetailsPopupLabel">Détails du Membre</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Les détails du membre seront insérés ici -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
