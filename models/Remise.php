<?php
class Remise {
    private $conn;
    private $table = 'remises';

    public $id;
    public $id_partenaire;
    public $id_type_abonnement;
    public $valeur_remise;
    public $offre_speciale;
    public $valable_du;
    public $valable_au;
    public $cree_le;
    public $modifie_le;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (id_partenaire, id_type_abonnement, valeur_remise, offre_speciale, valable_du, valable_au) 
                  VALUES (:id_partenaire, :id_type_abonnement, :valeur_remise, :offre_speciale, :valable_du, :valable_au)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_partenaire', $this->id_partenaire);
        $stmt->bindParam(':id_type_abonnement', $this->id_type_abonnement);
        $stmt->bindParam(':valeur_remise', $this->valeur_remise);
        $stmt->bindParam(':offre_speciale', $this->offre_speciale);
        $stmt->bindParam(':valable_du', $this->valable_du);
        $stmt->bindParam(':valable_au', $this->valable_au);

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
                  SET id_partenaire = :id_partenaire, id_type_abonnement = :id_type_abonnement, valeur_remise = :valeur_remise, offre_speciale = :offre_speciale, valable_du = :valable_du, valable_au = :valable_au
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':id_partenaire', $this->id_partenaire);
        $stmt->bindParam(':id_type_abonnement', $this->id_type_abonnement);
        $stmt->bindParam(':valeur_remise', $this->valeur_remise);
        $stmt->bindParam(':offre_speciale', $this->offre_speciale);
        $stmt->bindParam(':valable_du', $this->valable_du);
        $stmt->bindParam(':valable_au', $this->valable_au);

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
