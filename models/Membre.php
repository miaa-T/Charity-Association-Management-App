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

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new membre
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (prenom, nom, email, mot_de_passe, numero_identite, telephone, adresse, photo, carte_identite, recu_paiement, id_type_abonnement, date_inscription, date_expiration) 
                  VALUES (:prenom, :nom, :email, :mot_de_passe, :numero_identite, :telephone, :adresse, :photo, :carte_identite, :recu_paiement, :id_type_abonnement, :date_inscription, :date_expiration)";

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
                  SET prenom = :prenom, nom = :nom, email = :email, mot_de_passe = :mot_de_passe, numero_identite = :numero_identite, telephone = :telephone, adresse = :adresse, photo = :photo, carte_identite = :carte_identite, recu_paiement = :recu_paiement, id_type_abonnement = :id_type_abonnement, date_inscription = :date_inscription, date_expiration = :date_expiration
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
}
?>
