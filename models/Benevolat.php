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

    // Créer un nouveau bénévolat
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (id_membre, evenement, id_statut_benevolat) 
                  VALUES (:id_membre, :evenement, :id_statut_benevolat)";

        $stmt = $this->conn->prepare($query);

        // Liaison des valeurs
        $stmt->bindParam(':id_membre', $this->id_membre);
        $stmt->bindParam(':evenement', $this->evenement);
        $stmt->bindParam(':id_statut_benevolat', $this->id_statut_benevolat);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Lire tous les bénévolats
    public function read() {
        $query = "SELECT b.*, m.prenom, m.nom, s.nom as statut 
                  FROM " . $this->table . " b 
                  JOIN membres m ON b.id_membre = m.id 
                  JOIN statut_benevolat s ON b.id_statut_benevolat = s.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Mettre à jour un bénévolat
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET id_membre = :id_membre, evenement = :evenement, id_statut_benevolat = :id_statut_benevolat 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Liaison des valeurs
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':id_membre', $this->id_membre);
        $stmt->bindParam(':evenement', $this->evenement);
        $stmt->bindParam(':id_statut_benevolat', $this->id_statut_benevolat);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Supprimer un bénévolat
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Récupérer les statistiques des bénévolats
    public function getStats() {
        $query = "SELECT 
                    COUNT(*) as total_benevoles, 
                    COUNT(DISTINCT id_membre) as total_membres 
                  FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>