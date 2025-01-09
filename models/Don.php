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
    public $statut;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Créer un nouveau don
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (id_membre, montant, recu, date_don, statut) 
                  VALUES (:id_membre, :montant, :recu, :date_don, :statut)";

        $stmt = $this->conn->prepare($query);

        // Liaison des valeurs
        $stmt->bindParam(':id_membre', $this->id_membre);
        $stmt->bindParam(':montant', $this->montant);
        $stmt->bindParam(':recu', $this->recu);
        $stmt->bindParam(':date_don', $this->date_don);
        $stmt->bindParam(':statut', $this->statut);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Lire tous les dons
    public function read() {
        $query = "SELECT d.*, m.prenom, m.nom 
                  FROM " . $this->table . " d 
                  JOIN membres m ON d.id_membre = m.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Mettre à jour un don
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET id_membre = :id_membre, montant = :montant, recu = :recu, date_don = :date_don, statut = :statut 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Liaison des valeurs
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':id_membre', $this->id_membre);
        $stmt->bindParam(':montant', $this->montant);
        $stmt->bindParam(':recu', $this->recu);
        $stmt->bindParam(':date_don', $this->date_don);
        $stmt->bindParam(':statut', $this->statut);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Supprimer un don
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Valider un don
    public function validate($id) {
        $query = "UPDATE " . $this->table . " SET statut = 'Validé' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Rejeter un don
    public function reject($id) {
        $query = "UPDATE " . $this->table . " SET statut = 'Rejeté' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Récupérer les statistiques des dons
    public function getStats() {
        $query = "SELECT 
                    COUNT(*) as total_dons, 
                    SUM(montant) as total_montant, 
                    AVG(montant) as moyenne_montant 
                  FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>