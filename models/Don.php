<?php
class Don {
    private $conn;
    private $table = 'dons';

    public $id;
    public $id_membre;
    public $montant;
    public $recu;
    public $date_don;
    public $cree_le;
    public $modifie_le;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new don
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (id_membre, montant, recu, date_don) 
                  VALUES (:id_membre, :montant, :recu, :date_don)";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(':id_membre', $this->id_membre);
        $stmt->bindParam(':montant', $this->montant);
        $stmt->bindParam(':recu', $this->recu);
        $stmt->bindParam(':date_don', $this->date_don);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read all dons
    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update a don
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET id_membre = :id_membre, montant = :montant, recu = :recu, date_don = :date_don
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':id_membre', $this->id_membre);
        $stmt->bindParam(':montant', $this->montant);
        $stmt->bindParam(':recu', $this->recu);
        $stmt->bindParam(':date_don', $this->date_don);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a don
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
