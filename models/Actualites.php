<?php
class Actualite {
    private $conn;
    private $table = 'actualites';

    public $id;
    public $titre;
    public $description;
    public $image;
    public $cree_le;
    public $modifie_le;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (titre, description, image) 
                  VALUES (:titre, :description, :image)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image', $this->image);

        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET titre = :titre, 
                      description = :description, 
                      image = :image 
                  WHERE id = :id";
    
        $stmt = $this->conn->prepare($query);
    
        // Bind values
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':titre', $this->titre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
    
        // Execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
    
        $stmt = $this->conn->prepare($query);
    
        // Bind ID
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    
        // Execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
        
}
?>
