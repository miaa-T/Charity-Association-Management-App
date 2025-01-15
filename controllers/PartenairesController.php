<?php
require_once __DIR__ . '/../models/db.php';
require_once __DIR__ . '/../models/Partenaire.php';

class PartenaireController {
    private $partenaire;

    public function __construct() {
        $db = new Database();
        $this->partenaire = new Partenaire($db->connect());
    }

    /**
     * Get all partners grouped by categories.
     * 
     * @return array
     */
    public function getAllPartners($ville_filter = '', $categorie_filter = '') {
        return $this->partenaire->getAllWithFilters($ville_filter, $categorie_filter);
    }
    public function getPartnerById($id) {
        return $this->partenaire->readOne($id);
    }
    public function addPartner($data) {
        $this->partenaire->nom = $data['nom'];
        $this->partenaire->id_categorie_partenaire = $data['id_categorie_partenaire'];
        $this->partenaire->ville = $data['ville'];
        $this->partenaire->remise = $data['remise'];
        $this->partenaire->details = $data['details'];
        $this->partenaire->logo = $data['logo'];
        $this->partenaire->description = $data['description'];

        if ($this->partenaire->create()) {
            return true;
        }
        return false;
    }
    public function updatePartner($id, $data) {
        $this->partenaire->id = $id;
        $this->partenaire->nom = $data['nom'];
        $this->partenaire->id_categorie_partenaire = $data['id_categorie_partenaire'];
        $this->partenaire->ville = $data['ville'];
        $this->partenaire->remise = $data['remise'];
        $this->partenaire->details = $data['details'];
        $this->partenaire->logo = $data['logo'];
        $this->partenaire->description = $data['description'];

        if ($this->partenaire->update()) {
            return true;
        }
        return false;
    }
    public function getAllCities() {
        return $this->partenaire->getAllCities();
    }

    /**
     * Récupérer toutes les catégories
     */
    public function getAllCategories() {
        return $this->partenaire->getAllCategories();
    }
    public function deletePartner($id) {
        $this->partenaire->id = $id;
        if ($this->partenaire->delete()) {
            return true;
        }
        return false;
    }
    public function getAllPartnersByCategory() {
        $partners = $this->partenaire->read()->fetchAll(PDO::FETCH_ASSOC);
    
        $groupedPartners = [];
        foreach ($partners as $partner) {
            $categoryId = $partner['id_categorie_partenaire'];
    
            // Fetch category name for grouping
            $categoryName = $this->getCategoryName($categoryId);
    
            // Initialize the category group if it doesn't exist
            if (!isset($groupedPartners[$categoryName])) {
                $groupedPartners[$categoryName] = [];
            }
    
            // Add partner to the category group with all necessary fields
            $groupedPartners[$categoryName][] = [
                'id' => $partner['id'],
                'nom' => $partner['nom'],
                'ville' => $partner['ville'],
                'remise' => $partner['remise'],
                'details' => $partner['details'],
                'logo' => $partner['logo'],
                'categorie_nom' => $categoryName,
                'cree_le' => $partner['cree_le'],
                'modifie_le' => $partner['modifie_le'],
                'description' => $partner['description']
            ];
        }
    
        return $groupedPartners;
    }

    /**
     * Get the name of a category by its ID.
     * 
     * @param int $categoryId
     * @return string
     */
    private function getCategoryName($categoryId) {
        $db = new Database();
        $conn = $db->connect();

        $query = "SELECT nom FROM categorie_partenaire WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $categoryId);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['nom'] : 'Unknown';
    }
}
