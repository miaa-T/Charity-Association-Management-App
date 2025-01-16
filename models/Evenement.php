<?php
class Evenement {
    private $conn;
    private $table = 'evenements';

    public $id;
    public $nom;
    public $description;
    public $date_debut;
    public $date_fin;
    public $image;
    public $cree_le;
    public $modifie_le;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (nom, description, date_debut, date_fin, image) 
                  VALUES (:nom, :description, :date_debut, :date_fin, :image)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':date_debut', $this->date_debut);
        $stmt->bindParam(':date_fin', $this->date_fin);
        $stmt->bindParam(':image', $this->image);

        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    public function readById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

public function update() {
    $query = "UPDATE " . $this->table . " 
              SET nom = :nom, 
                  description = :description, 
                  date_debut = :date_debut, 
                  date_fin = :date_fin, 
                  image = :image
              WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    // Bind values
    $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    $stmt->bindParam(':nom', $this->nom, PDO::PARAM_STR);
    $stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
    $stmt->bindParam(':date_debut', $this->date_debut, PDO::PARAM_STR);
    $stmt->bindParam(':date_fin', $this->date_fin, PDO::PARAM_STR);
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

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
