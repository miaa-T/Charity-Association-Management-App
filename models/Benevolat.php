<?php
class Benevolat {
    private $conn;
    private $table = 'benevoles';

    public $id;
    public $id_membre;
    public $evenement_id; // Utiliser evenement_id au lieu de evenement
    public $id_statut_benevolat;
    public $cree_le;
    public $modifie_le;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (id_membre, evenement_id, id_statut_benevolat, cree_le) 
                  VALUES (:id_membre, :evenement_id, :id_statut_benevolat, NOW())";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_membre', $this->id_membre);
        $stmt->bindParam(':evenement_id', $this->evenement_id); // Utiliser evenement_id
        $stmt->bindParam(':id_statut_benevolat', $this->id_statut_benevolat);

        return $stmt->execute();
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

        public function delete($id) {
            $query = "DELETE FROM " . $this->table . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
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
    public function approve($id) {
        $query = "UPDATE " . $this->table . " SET id_statut_benevolat = 2 WHERE id = :id"; // 2 = Confirmé
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function complete($id) {
        $query = "UPDATE " . $this->table . " SET id_statut_benevolat = 3 WHERE id = :id"; // 3 = Terminé
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>