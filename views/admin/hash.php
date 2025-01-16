<?php//un script juste pour avoir le mot de pass hashed , a utiliser dans le cas ou on veu t changer le mtps 
$mot_de_passe = 'admin';

$mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);

echo "Mot de passe en clair : " . $mot_de_passe . "\n";
echo "Mot de passe haché : " . $mot_de_passe_hache . "\n";
?>