<?php
class Membre {
    private $conn;
    private $table = 'membres';

    public $id;
    public $prenom;
    public $nom;
    public $email;
    public $mot_de_passe;
    public $numero_identite;
    public $telephone;
    public $adresse;
    public $photo;
    public $recu_paiement;
    public $nom_type_abonnement; // Changed from id_type_abonnement to nom_type_abonnement
    public $date_inscription;
    public $date_expiration;
    public $cree_le;
    public $modifie_le;
    public $statut;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Create a new member.
     *
     * @return bool True if successful, otherwise false.
     */
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (prenom, nom, email, mot_de_passe, numero_identite, telephone, adresse, photo, recu_paiement, nom_type_abonnement, date_inscription, date_expiration, statut) 
                  VALUES (:prenom, :nom, :email, :mot_de_passe, :numero_identite, :telephone, :adresse, :photo, :recu_paiement, :nom_type_abonnement, :date_inscription, :date_expiration, :statut)";
    
        $stmt = $this->conn->prepare($query);
    
        // Bind values
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':mot_de_passe', $this->mot_de_passe);
        $stmt->bindParam(':numero_identite', $this->numero_identite);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':adresse', $this->adresse);
        $stmt->bindParam(':photo', $this->photo);
        $stmt->bindParam(':recu_paiement', $this->recu_paiement);
        $stmt->bindParam(':nom_type_abonnement', $this->nom_type_abonnement);
        $stmt->bindParam(':date_inscription', $this->date_inscription);
        $stmt->bindParam(':date_expiration', $this->date_expiration);
        $stmt->bindParam(':statut', $this->statut);
    
        // Execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            // Print error for debugging
            print_r($stmt->errorInfo());
            return false;
        }
    }

    /**
     * Read all members.
     *
     * @return PDOStatement The result set.
     */
    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Update a member's information.
     *
     * @return bool True if successful, otherwise false.
     */
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET prenom = :prenom, nom = :nom, email = :email, mot_de_passe = :mot_de_passe, numero_identite = :numero_identite, telephone = :telephone, adresse = :adresse, photo = :photo, recu_paiement = :recu_paiement, nom_type_abonnement = :nom_type_abonnement, date_inscription = :date_inscription, date_expiration = :date_expiration, statut = :statut
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':mot_de_passe', $this->mot_de_passe);
        $stmt->bindParam(':numero_identite', $this->numero_identite);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':adresse', $this->adresse);
        $stmt->bindParam(':photo', $this->photo);
        $stmt->bindParam(':recu_paiement', $this->recu_paiement);
        $stmt->bindParam(':nom_type_abonnement', $this->nom_type_abonnement);
        $stmt->bindParam(':date_inscription', $this->date_inscription);
        $stmt->bindParam(':date_expiration', $this->date_expiration);
        $stmt->bindParam(':statut', $this->statut);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            // Print error for debugging
            print_r($stmt->errorInfo());
            return false;
        }
    }

    /**
     * Delete a member.
     *
     * @return bool True if successful, otherwise false.
     */
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':id', $this->id);

        // Execute the query
        if ($stmt->execute()) {
            return true;
        } else {
            // Print error for debugging
            print_r($stmt->errorInfo());
            return false;
        }
    }

    /**
     * Approve a member's registration.
     *
     * @param int $id The member's ID.
     * @return bool True if successful, otherwise false.
     */
    public function approveMember($id) {
        $query = "UPDATE " . $this->table . " SET statut = 'Approuvé' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Reject a member's registration.
     *
     * @param int $id The member's ID.
     * @return bool True if successful, otherwise false.
     */
    public function rejectMember($id) {
        $query = "UPDATE " . $this->table . " SET statut = 'Rejeté' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Get all members with optional filtering and sorting.
     *
     * @param string $filtre_statut Filter by status.
     * @param string $filtre_type_abonnement Filter by subscription type.
     * @param string $tri Sorting order.
     * @return array The filtered and sorted members.
     */
    public function getAllMembers($filtre_statut = '', $filtre_type_abonnement = '', $tri = 'date_inscription DESC') {
        $query = "SELECT m.*, t.nom as type_abonnement 
                  FROM " . $this->table . " m 
                  JOIN type_abonnement t ON m.nom_type_abonnement = t.nom 
                  WHERE 1=1";

        if (!empty($filtre_statut)) {
            $query .= " AND m.statut = :statut";
        }
        if (!empty($filtre_type_abonnement)) {
            $query .= " AND m.nom_type_abonnement = :type_abonnement";
        }
        $query .= " ORDER BY " . $tri;

        $stmt = $this->conn->prepare($query);

        if (!empty($filtre_statut)) {
            $stmt->bindParam(':statut', $filtre_statut);
        }
        if (!empty($filtre_type_abonnement)) {
            $stmt->bindParam(':type_abonnement', $filtre_type_abonnement);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all subscription types.
     *
     * @return array The list of subscription types.
     */
    public function getAllSubscriptionTypes() {
        $query = "SELECT * FROM type_abonnement";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        // Debugging: Print the fetched subscription types
        $subscriptionTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>";
        print_r($subscriptionTypes);
        echo "</pre>";
    
        return $subscriptionTypes;
    }

    /**
     * Get subscription type ID by name.
     *
     * @param string $nom The name of the subscription type.
     * @return int|null The subscription type ID if found, otherwise null.
     */
    public function getSubscriptionTypeIdByName($nom) {
        $query = "SELECT nom FROM type_abonnement WHERE nom = :nom";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['nom'] : null;
    }
}
?>