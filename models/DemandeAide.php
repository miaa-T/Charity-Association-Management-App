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
    public $numero_telephone;
    public $cree_le;
    public $modifie_le;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new assistance request
    public function creer() {
        $query = 'INSERT INTO ' . $this->table . ' 
                  (nom, prenom, date_naissance, type_aide, description, fichier, numero_identite, numero_telephone) 
                  VALUES (:nom, :prenom, :date_naissance, :type_aide, :description, :fichier, :numero_identite, :numero_telephone)';

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':date_naissance', $this->date_naissance);
        $stmt->bindParam(':type_aide', $this->type_aide);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':fichier', $this->fichier);
        $stmt->bindParam(':numero_identite', $this->numero_identite);
        $stmt->bindParam(':numero_telephone', $this->numero_telephone); 

        // Execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read all assistance requests
    public function lire() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update an assistance request
    public function modifier() {
        $query = 'UPDATE ' . $this->table . ' 
                  SET nom = :nom, prenom = :prenom, date_naissance = :date_naissance, type_aide = :type_aide, 
                      description = :description, fichier = :fichier, numero_identite = :numero_identite, 
                      numero_telephone = :numero_telephone 
                  WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':date_naissance', $this->date_naissance);
        $stmt->bindParam(':type_aide', $this->type_aide);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':fichier', $this->fichier);
        $stmt->bindParam(':numero_identite', $this->numero_identite);
        $stmt->bindParam(':numero_telephone', $this->numero_telephone); // Add this line

        // Execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    // Delete an assistance request
    public function supprimer() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>