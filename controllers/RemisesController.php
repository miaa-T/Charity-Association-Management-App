<?php
require_once __DIR__ . '/../models/db.php';
require_once __DIR__ . '/../models/Remise.php';

class RemisesController {
    private $remise;

    public function __construct() {
        $db = new Database();
        $this->remise = new Remise($db->connect());
    }

    // Fetch all remises
    public function getAllRemises() {
        return $this->remise->readAll();
    }

    // Fetch limited-time offers
    public function getLimitedOffers() {
        return $this->remise->readLimitedOffers();
    }

    // Fetch permanent offers
    public function getPermanentOffers() {
        return $this->remise->readPermanentOffers();
    }

    // Fetch categories
    public function getCategories() {
        return $this->remise->getCategories();
    }

    // Fetch filtered remises
    public function getFilteredRemises($search = '', $category = '', $type = '') {
        return $this->remise->getFilteredRemises($search, $category, $type);
    }
    public function getRemisesByTypeCarte($typeCarte) {
        return $this->remise->getRemisesByTypeCarte($typeCarte);
    }
    public function getRemisesUtilisees($idMembre) {
        return $this->remise->getRemisesUtilisees($idMembre);
    }
    public function getRemisesByPartenaire($id_partenaire) {
        return $this->remise->getRemisesByPartenaire($id_partenaire);
    }

    /**
     * Récupérer les utilisations des remises d'un partenaire
     */
    public function getUtilisationsByPartenaire($id_partenaire) {
        return $this->remise->getUtilisationsByPartenaire($id_partenaire);
    }
}
