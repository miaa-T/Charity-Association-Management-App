<?php
class Partenaire {
    private $conn;
    private $table = 'partenaires';

    public $id;
    public $nom;
    public $id_categorie_partenaire;
    public $ville;
    public $remise;
    public $details;
    public $logo;
    public $cree_le;
    public $modifie_le;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Créer un nouveau partenaire
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (nom, id_categorie_partenaire, ville, remise, details, logo) 
                  VALUES (:nom, :id_categorie_partenaire, :ville, :remise, :details, :logo)";

        $stmt = $this->conn->prepare($query);

        // Liaison des valeurs
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':id_categorie_partenaire', $this->id_categorie_partenaire);
        $stmt->bindParam(':ville', $this->ville);
        $stmt->bindParam(':remise', $this->remise);
        $stmt->bindParam(':details', $this->details);
        $stmt->bindParam(':logo', $this->logo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Lire tous les partenaires
    public function read() {
        $query = "SELECT p.*, cp.nom as categorie_nom 
                  FROM " . $this->table . " p 
                  LEFT JOIN categorie_partenaire cp ON p.id_categorie_partenaire = cp.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Lire un partenaire par ID
    public function readOne($id) {
        $query = "SELECT p.*, cp.nom as categorie_nom 
                  FROM " . $this->table . " p 
                  LEFT JOIN categorie_partenaire cp ON p.id_categorie_partenaire = cp.id 
                  WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mettre à jour un partenaire
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET nom = :nom, id_categorie_partenaire = :id_categorie_partenaire, ville = :ville, remise = :remise, details = :details, logo = :logo 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Liaison des valeurs
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':id_categorie_partenaire', $this->id_categorie_partenaire);
        $stmt->bindParam(':ville', $this->ville);
        $stmt->bindParam(':remise', $this->remise);
        $stmt->bindParam(':details', $this->details);
        $stmt->bindParam(':logo', $this->logo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Supprimer un partenaire
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Récupérer les statistiques d'utilisation des remises
    public function getUsageStats($id) {
        $query = "SELECT COUNT(*) as total_utilisations, COUNT(DISTINCT id_membre) as total_membres 
                  FROM utilisation_remises 
                  WHERE id_partenaire = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>