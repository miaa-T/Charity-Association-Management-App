<?php

namespace App\Models;

require_once __DIR__ . '/../core/Model.php';
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

    /**
     * Récupère les notifications d'un membre spécifique.
     *
     * @param int $userId L'ID du membre.
     * @return array Les notifications du membre.
     */
    public function getUserNotifications($userId) {
        $query = "SELECT n.id, n.titre, n.contenu, n.envoye_le, tn.nom AS type_notification 
FROM notifications n
JOIN type_notification tn ON n.id_type_notification = tn.id
WHERE n.id_membre = :id_membre
ORDER BY n.envoye_le DESC;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_membre', $userId);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Crée une nouvelle notification.
     *
     * @return bool True si la notification a été créée, sinon False.
     */
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
    /**
     * Met à jour une notification existante.
     *
     * @return bool True si la notification a été mise à jour, sinon False.
     */
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET id_membre = :id_membre, id_type_notification = :id_type_notification, titre = :titre, contenu = :contenu
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

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
    /**
     * Supprime une notification.
     *
     * @return bool True si la notification a été supprimée, sinon False.
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
    public function getAllNotifications() {
        $query = "SELECT n.id, n.id_membre, n.id_type_notification, n.titre, n.contenu, n.envoye_le, tn.nom AS type_notification 
                  FROM notifications n
                  JOIN type_notification tn ON n.id_type_notification = tn.id
                  ORDER BY n.envoye_le DESC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>