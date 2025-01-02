<?php
class Notification {
    private $conn;
    private $table = 'notifications';

    public $id;
    public $id_membre;
    public $id_type_notification;
    public $titre;
    public $contenu;
    public $envoye_le;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (id_membre, id_type_notification, titre, contenu) 
                  VALUES (:id_membre, :id_type_notification, :titre, :contenu)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_membre', $this->id_membre);
        $stmt->bindParam(':id_type_notification', $this->id_type_notification);
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':contenu', $this->contenu);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read all notifications
    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update a notification
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET id_membre = :id_membre, id_type_notification = :id_type_notification, titre = :titre, contenu = :contenu
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':id_membre', $this->id_membre);
        $stmt->bindParam(':id_type_notification', $this->id_type_notification);
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':contenu', $this->contenu);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a notification
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
