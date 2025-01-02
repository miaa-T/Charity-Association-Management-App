<?php
require_once __DIR__ . '/../models/db.php';
require_once __DIR__ . '/../models/Remise.php';

class RemisesController {
    private $remise;

    public function __construct() {
        $db = new Database();
        $this->remise = new Remise($db->connect());
    }

    public function getAllRemises() {
        $stmt = $this->remise->readAll();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLimitedOffers() {
        $stmt = $this->remise->readLimitedOffers();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPermanentOffers() {
        $stmt = $this->remise->readPermanentOffers();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
