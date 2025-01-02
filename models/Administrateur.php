<?php
class Administrateur {
    private $conn;
    private $table = 'administrateurs';

    // Administrateur properties
    public $id;
    public $nom_utilisateur;
    public $mot_de_passe;
    public $role;
    public $cree_le;
    public $modifie_le;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new administrateur
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (nom_utilisateur, mot_de_passe, role) 
                  VALUES (:nom_utilisateur, :mot_de_passe, :role)";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(':nom_utilisateur', $this->nom_utilisateur);
        $stmt->bindParam(':mot_de_passe', $this->mot_de_passe);
        $stmt->bindParam(':role', $this->role);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read all administrateurs
    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update an existing administrateur
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET nom_utilisateur = :nom_utilisateur, mot_de_passe = :mot_de_passe, role = :role
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nom_utilisateur', $this->nom_utilisateur);
        $stmt->bindParam(':mot_de_passe', $this->mot_de_passe);
        $stmt->bindParam(':role', $this->role);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete an administrateur
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

    // Authenticate administrateur by username and password
    public function authenticate() {
        $query = "SELECT * FROM " . $this->table . " WHERE nom_utilisateur = :nom_utilisateur";
        $stmt = $this->conn->prepare($query);

        // Bind username
        $stmt->bindParam(':nom_utilisateur', $this->nom_utilisateur);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Verify password
            if (password_verify($this->mot_de_passe, $row['mot_de_passe'])) {
                // Set object properties
                $this->id = $row['id'];
                $this->role = $row['role'];
                $this->cree_le = $row['cree_le'];
                $this->modifie_le = $row['modifie_le'];
                return true;
            }
        }
        return false;
    }
}
?>
