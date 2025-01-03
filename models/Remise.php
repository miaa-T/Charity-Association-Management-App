<?php
class Remise {
    private $conn;
    private $table = 'remises';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch all remises
    public function readAll() {
        $query = "SELECT r.*, p.nom AS partenaire_nom 
                  FROM " . $this->table . " r 
                  JOIN partenaires p ON r.id_partenaire = p.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch limited-time offers
    public function readLimitedOffers() {
        $query = "SELECT r.*, p.nom AS partenaire_nom 
                  FROM " . $this->table . " r 
                  JOIN partenaires p ON r.id_partenaire = p.id
                  WHERE r.type_remise = 'limitee' AND (r.expire_le IS NOT NULL AND r.expire_le >= CURDATE())";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch permanent offers
    public function readPermanentOffers() {
        $query = "SELECT r.*, p.nom AS partenaire_nom 
                  FROM " . $this->table . " r 
                  JOIN partenaires p ON r.id_partenaire = p.id
                  WHERE r.type_remise = 'permanente'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch filtered remises
    public function getFilteredRemises($search = '', $category = '', $type = '') {
        $query = "SELECT r.*, p.nom AS partenaire_nom
                  FROM remises r
                  LEFT JOIN partenaires p ON r.id_partenaire = p.id
                  WHERE 1=1";

        if (!empty($search)) {
            $query .= " AND r.nom LIKE CONCAT('%', :search, '%')";
        }
        if (!empty($category)) {
            $query .= " AND r.id_categorie = :category";
        }
        if (!empty($type)) {
            $query .= " AND r.type_remise = :type";
        }

        $stmt = $this->conn->prepare($query);

        if (!empty($search)) {
            $stmt->bindValue(':search', '%' . $search . '%');
        }
        if (!empty($category)) {
            $stmt->bindValue(':category', $category);
        }
        if (!empty($type)) {
            $stmt->bindValue(':type', $type);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch categories
    public function getCategories() {
        $query = "SELECT id, nom FROM categorie_partenaire";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
