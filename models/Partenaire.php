<?php
class Partenaire {
    private $conn;
    private $table = 'partenaires';

    public $id;
    public $nom;
    public $id_categorie_partenaire;
    public $ville;
    public $remise;
    public $details;
    public $logo;
    public $cree_le;
    public $modifie_le;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new partenaire
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (nom, id_categorie_partenaire, ville, remise, details, logo) 
                  VALUES (:nom, :id_categorie_partenaire, :ville, :remise, :details, :logo)";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':id_categorie_partenaire', $this->id_categorie_partenaire);
        $stmt->bindParam(':ville', $this->ville);
        $stmt->bindParam(':remise', $this->remise);
        $stmt->bindParam(':details', $this->details);
        $stmt->bindParam(':logo', $this->logo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read all partenaires
    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update a partenaire
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET nom = :nom, id_categorie_partenaire = :id_categorie_partenaire, ville = :ville, remise = :remise, details = :details, logo = :logo
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':id_categorie_partenaire', $this->id_categorie_partenaire);
        $stmt->bindParam(':ville', $this->ville);
        $stmt->bindParam(':remise', $this->remise);
        $stmt->bindParam(':details', $this->details);
        $stmt->bindParam(':logo', $this->logo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a partenaire
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
