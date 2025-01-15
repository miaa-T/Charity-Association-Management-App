<?php
class Partenaire {
    private $conn;
    private $table = 'partenaires';

    // Propriétés du partenaire
    public $id;
    public $nom;
    public $id_categorie_partenaire;
    public $ville;
    public $remise;
    public $details;
    public $logo;
    public $cree_le;
    public $modifie_le;
    public $description;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Créer un nouveau partenaire
     */
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (nom, id_categorie_partenaire, ville, remise, details, logo, description) 
                  VALUES (:nom, :id_categorie_partenaire, :ville, :remise, :details, :logo, :description)";

        $stmt = $this->conn->prepare($query);

        // Liaison des valeurs
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':id_categorie_partenaire', $this->id_categorie_partenaire);
        $stmt->bindParam(':ville', $this->ville);
        $stmt->bindParam(':remise', $this->remise);
        $stmt->bindParam(':details', $this->details);
        $stmt->bindParam(':logo', $this->logo);
        $stmt->bindParam(':description', $this->description);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Lire tous les partenaires
     */
    public function read() {
        $query = "SELECT p.*, cp.nom as categorie_nom 
                  FROM " . $this->table . " p 
                  LEFT JOIN categorie_partenaire cp ON p.id_categorie_partenaire = cp.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Lire un partenaire par ID
     */
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

    /**
     * Mettre à jour un partenaire
     */
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET nom = :nom, id_categorie_partenaire = :id_categorie_partenaire, ville = :ville, 
                      remise = :remise, details = :details, logo = :logo, description = :description 
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
        $stmt->bindParam(':description', $this->description);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Supprimer un partenaire
     */
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Récupérer tous les partenaires avec filtres
     */
    public function getAllWithFilters($ville_filter = '', $categorie_filter = '') {
        $query = "SELECT p.*, cp.nom as categorie_nom 
                  FROM " . $this->table . " p 
                  LEFT JOIN categorie_partenaire cp ON p.id_categorie_partenaire = cp.id 
                  WHERE 1=1";

        if (!empty($ville_filter)) {
            $query .= " AND p.ville = :ville";
        }
        if (!empty($categorie_filter)) {
            $query .= " AND p.id_categorie_partenaire = :categorie";
        }

        $query .= " ORDER BY p.nom";

        $stmt = $this->conn->prepare($query);

        if (!empty($ville_filter)) {
            $stmt->bindParam(':ville', $ville_filter);
        }
        if (!empty($categorie_filter)) {
            $stmt->bindParam(':categorie', $categorie_filter);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer toutes les villes distinctes des partenaires
     */
    public function getAllCities() {
        $query = "SELECT DISTINCT ville FROM " . $this->table . " ORDER BY ville";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Récupérer toutes les catégories de partenaires
     */
    public function getAllCategories() {
        $query = "SELECT id, nom FROM categorie_partenaire ORDER BY nom";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getRemisesByPartenaire($id_partenaire) {
        $query = "SELECT * FROM remises WHERE id_partenaire = :id_partenaire";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_partenaire', $id_partenaire);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer les utilisations des remises d'un partenaire
     */
    public function getUtilisationsByPartenaire($id_partenaire) {
        $query = "SELECT ur.*, m.nom as membre_nom 
                  FROM utilisation_remises ur
                  JOIN membres m ON ur.id_membre = m.id
                  WHERE ur.id_partenaire = :id_partenaire";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_partenaire', $id_partenaire);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>