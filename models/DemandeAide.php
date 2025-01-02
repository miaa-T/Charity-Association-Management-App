<?php
class DemandeAide {
    private $conn;
    private $table = 'demandes_aides';

    public $id;
    public $nom;
    public $prenom;
    public $date_naissance;
    public $type_aide;
    public $description;
    public $fichier;
    public $numero_identite;
    public $cree_le;
    public $modifie_le;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (nom, prenom, date_naissance, type_aide, description, fichier, numero_identite) 
                  VALUES (:nom, :prenom, :date_naissance, :type_aide, :description, :fichier, :numero_identite)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':date_naissance', $this->date_naissance);
        $stmt->bindParam(':type_aide', $this->type_aide);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':fichier', $this->fichier);
        $stmt->bindParam(':numero_identite', $this->numero_identite);

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
                  SET nom = :nom, prenom = :prenom, date_naissance = :date_naissance, type_aide = :type_aide, description = :description, fichier = :fichier, numero_identite = :numero_identite
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':date_naissance', $this->date_naissance);
        $stmt->bindParam(':type_aide', $this->type_aide);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':fichier', $this->fichier);
        $stmt->bindParam(':numero_identite', $this->numero_identite);

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
