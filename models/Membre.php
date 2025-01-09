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
    public $carte_identite;
    public $recu_paiement;
    public $id_type_abonnement;
    public $date_inscription;
    public $date_expiration;
    public $cree_le;
    public $modifie_le;
    public $statut; // Nouvelle propriété pour le statut

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new membre
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (prenom, nom, email, mot_de_passe, numero_identite, telephone, adresse, photo, carte_identite, recu_paiement, id_type_abonnement, date_inscription, date_expiration, statut) 
                  VALUES (:prenom, :nom, :email, :mot_de_passe, :numero_identite, :telephone, :adresse, :photo, :carte_identite, :recu_paiement, :id_type_abonnement, :date_inscription, :date_expiration, :statut)";

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
        $stmt->bindParam(':carte_identite', $this->carte_identite);
        $stmt->bindParam(':recu_paiement', $this->recu_paiement);
        $stmt->bindParam(':id_type_abonnement', $this->id_type_abonnement);
        $stmt->bindParam(':date_inscription', $this->date_inscription);
        $stmt->bindParam(':date_expiration', $this->date_expiration);
        $stmt->bindParam(':statut', $this->statut); // Ajout du statut

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read all membres
    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update a membre
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET prenom = :prenom, nom = :nom, email = :email, mot_de_passe = :mot_de_passe, numero_identite = :numero_identite, telephone = :telephone, adresse = :adresse, photo = :photo, carte_identite = :carte_identite, recu_paiement = :recu_paiement, id_type_abonnement = :id_type_abonnement, date_inscription = :date_inscription, date_expiration = :date_expiration, statut = :statut
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
        $stmt->bindParam(':carte_identite', $this->carte_identite);
        $stmt->bindParam(':recu_paiement', $this->recu_paiement);
        $stmt->bindParam(':id_type_abonnement', $this->id_type_abonnement);
        $stmt->bindParam(':date_inscription', $this->date_inscription);
        $stmt->bindParam(':date_expiration', $this->date_expiration);
        $stmt->bindParam(':statut', $this->statut); // Ajout du statut

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a membre
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Approuver un membre
    public function approveMember($id) {
        $query = "UPDATE " . $this->table . " SET statut = 'Approuvé' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Rejeter un membre
    public function rejectMember($id) {
        $query = "UPDATE " . $this->table . " SET statut = 'Rejeté' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Récupérer tous les membres avec filtrage et tri
    public function getAllMembers($filtre_statut = '', $filtre_type_abonnement = '', $tri = 'date_inscription DESC') {
        $query = "SELECT m.*, t.nom as type_abonnement 
                  FROM " . $this->table . " m 
                  JOIN type_abonnement t ON m.id_type_abonnement = t.id 
                  WHERE 1=1";

        if (!empty($filtre_statut)) {
            $query .= " AND m.statut = :statut";
        }
        if (!empty($filtre_type_abonnement)) {
            $query .= " AND m.id_type_abonnement = :type_abonnement";
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

    // Récupérer tous les types d'abonnement
    public function getAllSubscriptionTypes() {
        $query = "SELECT * FROM type_abonnement";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>