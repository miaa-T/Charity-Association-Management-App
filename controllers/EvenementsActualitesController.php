<?php
require_once __DIR__ . '/../models/db.php';
require_once __DIR__ . '/../models/Evenement.php';
require_once __DIR__ . '/../models/Actualites.php';

class EvenementsActualitesController {
    private $evenement;
    private $actualite;

    public function __construct() {
        $db = new Database();
        $this->evenement = new Evenement($db->connect());
        $this->actualite = new Actualite($db->connect());
    }

    public function getAllEvenements() {
        $stmt = $this->evenement->read();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllActualites() {
        $stmt = $this->actualite->read();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
