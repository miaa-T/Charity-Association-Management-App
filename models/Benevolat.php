<?php
class Benevolat {
    private $conn;
    private $table = 'benevoles';

    public $id;
    public $id_membre;
    public $evenement;
    public $id_statut_benevolat;
    public $cree_le;
    public $modifie_le;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (id_membre, evenement, id_statut_benevolat) 
                  VALUES (:id_membre, :evenement, :id_statut_benevolat)";

        $stmt = $this->conn->prepare($query);

    
        $stmt->bindParam(':id_membre', $this->id_membre);
        $stmt->bindParam(':evenement', $this->evenement);
        $stmt->bindParam(':id_statut_benevolat', $this->id_statut_benevolat);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET id_membre = :id_membre, evenement = :evenement, id_statut_benevolat = :id_statut_benevolat
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':id_membre', $this->id_membre);
        $stmt->bindParam(':evenement', $this->evenement);
        $stmt->bindParam(':id_statut_benevolat', $this->id_statut_benevolat);

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
