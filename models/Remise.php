
<?php
class Remise {
    private $conn;
    private $table = 'remises';

    public $id;
    public $nom;
    public $description;
    public $type_remise;
    public $valeur_remise;
    public $expire_le;
    public $categorie;
    public $id_partenaire;
    public $cree_le;
    public $modifie_le;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (nom, description, type_remise, valeur_remise, expire_le, categorie, id_partenaire) 
                  VALUES 
                  (:nom, :description, :type_remise, :valeur_remise, :expire_le, :categorie, :id_partenaire)";
    
        $stmt = $this->conn->prepare($query);
    
        // Bind values
        $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':type_remise', $this->type_remise, PDO::PARAM_STR);
        $stmt->bindParam(':valeur_remise', $this->valeur_remise, PDO::PARAM_STR);
        $stmt->bindParam(':expire_le', $this->expire_le, PDO::PARAM_STR);
        $stmt->bindParam(':categorie', $this->categorie, PDO::PARAM_STR);
        $stmt->bindParam(':id_partenaire', $this->id_partenaire, PDO::PARAM_INT);
    
        // Execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET nom = :nom, 
                      description = :description, 
                      type_remise = :type_remise, 
                      valeur_remise = :valeur_remise, 
                      expire_le = :expire_le, 
                      categorie = :categorie, 
                      id_partenaire = :id_partenaire 
                  WHERE id = :id";
    
        $stmt = $this->conn->prepare($query);
    
        // Bind values
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':type_remise', $this->type_remise, PDO::PARAM_STR);
        $stmt->bindParam(':valeur_remise', $this->valeur_remise, PDO::PARAM_STR);
        $stmt->bindParam(':expire_le', $this->expire_le, PDO::PARAM_STR);
        $stmt->bindParam(':categorie', $this->categorie, PDO::PARAM_STR);
        $stmt->bindParam(':id_partenaire', $this->id_partenaire, PDO::PARAM_INT);
    
        // Execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
        
    public function readAll() {
        $query = "SELECT r.*, p.nom AS partenaire_nom 
                  FROM " . $this->table . " r 
                  JOIN partenaires p ON r.id_partenaire = p.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readLimitedOffers() {
        $query = "SELECT r.*, p.nom AS partenaire_nom 
                  FROM " . $this->table . " r 
                  JOIN partenaires p ON r.id_partenaire = p.id
                  WHERE r.type_remise = 'limitee' AND (r.expire_le IS NOT NULL AND r.expire_le >= CURDATE())";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readPermanentOffers() {
        $query = "SELECT r.*, p.nom AS partenaire_nom 
                  FROM " . $this->table . " r 
                  JOIN partenaires p ON r.id_partenaire = p.id
                  WHERE r.type_remise = 'permanente'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
