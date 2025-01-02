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

        // Add partner to the category group
        $groupedPartners[$categoryName][] = [
            'name' => $partner['nom'],
            'city' => $partner['ville'],
            'discount' => $partner['remise'],
            'details' => $partner['details'],
            'logo' => $partner['logo']
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
