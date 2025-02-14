<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Database; 
use App\Models\Evenement; 
use App\Models\Actualite; 
use App\Models\Remise; 

require_once __DIR__ . '/../models/db.php';
require_once __DIR__ . '/../models/Remise.php';
require_once __DIR__ . '/../core/Controller.php';
class RemisesController extends Controller{
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
    public function createRemise($nom, $description, $type_remise, $valeur_remise, $expire_le, $id_partenaire, $id_categorie) {
        return $this->remise->createRemise($nom, $description, $type_remise, $valeur_remise, $expire_le, $id_partenaire, $id_categorie);
    }

    // Mettre à jour une remise
    public function updateRemise($id, $nom, $description, $type_remise, $valeur_remise, $expire_le, $id_partenaire, $id_categorie) {
        return $this->remise->updateRemise($id, $nom, $description, $type_remise, $valeur_remise, $expire_le, $id_partenaire, $id_categorie);
    }

    // Supprimer une remise
    public function deleteRemise($id) {
        return $this->remise->deleteRemise($id);
    }
}
