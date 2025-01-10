<?php
class Partenaire {
    private $conn;
    private $table = 'partenaires';

    // Properties
    public $id;
    public $nom;
    public $ville;
    public $remise;
    public $details;
    public $logo;
    public $cree_le;
    public $modifie_le;

    /**
     * Constructor.
     * 
     * @param PDO $db Database connection
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Read all partners.
     * 
     * @return array
     */
    public function read() {
        // Fetch all partners
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Read a single partner by ID.
     * 
     * @param int $id Partner ID
     * @return array
     */
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new partner.
     * 
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (nom, ville, remise, details, logo) 
                  VALUES (:nom, :ville, :remise, :details, :logo)";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':ville', $this->ville);
        $stmt->bindParam(':remise', $this->remise);
        $stmt->bindParam(':details', $this->details);
        $stmt->bindParam(':logo', $this->logo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Update an existing partner.
     * 
     * @return bool
     */
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET nom = :nom, ville = :ville, remise = :remise, 
                      details = :details, logo = :logo 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':ville', $this->ville);
        $stmt->bindParam(':remise', $this->remise);
        $stmt->bindParam(':details', $this->details);
        $stmt->bindParam(':logo', $this->logo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Delete a partner.
     * 
     * @return bool
     */
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Get usage statistics for a partner's discounts.
     * 
     * @param int $id Partner ID
     * @return array
     */
    public function getUsageStats($id) {
        $query = "SELECT COUNT(*) as total_utilisations, COUNT(DISTINCT id_membre) as total_membres 
                  FROM utilisation_remises 
                  WHERE id_partenaire = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>