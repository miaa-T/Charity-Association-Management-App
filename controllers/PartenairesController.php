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
     * Get all partners.
     * 
     * @return array
     */
    public function getAllPartners() {
        return $this->partenaire->read();
    }

    /**
     * Get a single partner by ID.
     * 
     * @param int $id
     * @return array
     */
    public function getPartnerById($id) {
        return $this->partenaire->readOne($id);
    }

    /**
     * Create a new partner.
     * 
     * @param array $data
     * @return bool
     */
    public function createPartner($data) {
        $this->partenaire->nom = $data['nom'];
        $this->partenaire->ville = $data['ville'];
        $this->partenaire->remise = $data['remise'];
        $this->partenaire->details = $data['details'];
        $this->partenaire->logo = $data['logo'];

        if ($this->partenaire->create()) {
            return true;
        }
        return false;
    }

    /**
     * Update an existing partner.
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updatePartner($id, $data) {
        $this->partenaire->id = $id;
        $this->partenaire->nom = $data['nom'];
        $this->partenaire->ville = $data['ville'];
        $this->partenaire->remise = $data['remise'];
        $this->partenaire->details = $data['details'];
        $this->partenaire->logo = $data['logo'];

        if ($this->partenaire->update()) {
            return true;
        }
        return false;
    }

    /**
     * Delete a partner.
     * 
     * @param int $id
     * @return bool
     */
    public function deletePartner($id) {
        $this->partenaire->id = $id;

        if ($this->partenaire->delete()) {
            return true;
        }
        return false;
    }
}
?>