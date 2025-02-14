<?php
namespace App\Models;

require_once __DIR__ . '/../core/Model.php';

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
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Fetch limited-time offers
    public function readLimitedOffers() {
        $query = "SELECT r.*, p.nom AS partenaire_nom 
                  FROM " . $this->table . " r 
                  JOIN partenaires p ON r.id_partenaire = p.id
                  WHERE r.type_remise = 'limitee' AND (r.expire_le IS NOT NULL AND r.expire_le >= CURDATE())";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Fetch permanent offers
    public function readPermanentOffers() {
        $query = "SELECT r.*, p.nom AS partenaire_nom 
                  FROM " . $this->table . " r 
                  JOIN partenaires p ON r.id_partenaire = p.id
                  WHERE r.type_remise = 'permanente'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Fetch categories
    public function getCategories() {
        $query = "SELECT id, nom FROM categorie_partenaire";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getRemisesByTypeCarte($typeCarte) {
        $query = "SELECT r.*, p.nom AS partenaire_nom 
                  FROM remises r
                  JOIN partenaires p ON r.id_partenaire = p.id
                  JOIN remise_type_abonnement rta ON r.id = rta.id_remise
                  WHERE rta.nom_type_abonnement = :typeCarte";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':typeCarte', $typeCarte);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getRemisesUtilisees($idMembre) {
    $query = "SELECT r.*, p.nom AS partenaire_nom 
              FROM utilisation_remises ur
              JOIN remises r ON ur.id_remise = r.id
              JOIN partenaires p ON r.id_partenaire = p.id
              WHERE ur.id_membre = :idMembre";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':idMembre', $idMembre);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function getRemisesByPartenaire($id_partenaire) {
    $query = "SELECT * FROM remises WHERE id_partenaire = :id_partenaire";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id_partenaire', $id_partenaire);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
public function getRemiseDetails($remiseId) {
    $query = "SELECT r.*, p.nom AS partenaire_nom 
              FROM remises r 
              JOIN partenaires p ON r.id_partenaire = p.id
              WHERE r.id = :remiseId";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':remiseId', $remiseId);
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}


    // Créer une nouvelle remise
    public function createRemise($nom, $description, $type_remise, $valeur_remise, $expire_le, $id_partenaire, $id_categorie) {
        $query = "INSERT INTO " . $this->table . " 
                  (nom, description, type_remise, valeur_remise, expire_le, id_partenaire, id_categorie) 
                  VALUES (:nom, :description, :type_remise, :valeur_remise, :expire_le, :id_partenaire, :id_categorie)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':type_remise', $type_remise);
        $stmt->bindParam(':valeur_remise', $valeur_remise);
        $stmt->bindParam(':expire_le', $expire_le);
        $stmt->bindParam(':id_partenaire', $id_partenaire);
        $stmt->bindParam(':id_categorie', $id_categorie);

        return $stmt->execute();
    }

    // Mettre à jour une remise existante
    public function updateRemise($id, $nom, $description, $type_remise, $valeur_remise, $expire_le, $id_partenaire, $id_categorie) {
        $query = "UPDATE " . $this->table . " 
                  SET nom = :nom, description = :description, type_remise = :type_remise, valeur_remise = :valeur_remise, expire_le = :expire_le, id_partenaire = :id_partenaire, id_categorie = :id_categorie 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':type_remise', $type_remise);
        $stmt->bindParam(':valeur_remise', $valeur_remise);
        $stmt->bindParam(':expire_le', $expire_le);
        $stmt->bindParam(':id_partenaire', $id_partenaire);
        $stmt->bindParam(':id_categorie', $id_categorie);

        return $stmt->execute();
    }

    // Supprimer une remise
    public function deleteRemise($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

