<?php
namespace App\Models;
require_once __DIR__ . '/../core/Model.php';



class HistoriqueAdmin {
    private $conn;
    private $table = 'historique_admin';

    public $id;
    public $id_administrateur;
    public $type_action;
    public $table_concernee;
    public $id_enregistrement;
    public $details;
    public $date_action;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Créer un nouvel enregistrement dans l'historique
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (id_administrateur, type_action, table_concernee, id_enregistrement, details) 
                  VALUES (:id_administrateur, :type_action, :table_concernee, :id_enregistrement, :details)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_administrateur', $this->id_administrateur);
        $stmt->bindParam(':type_action', $this->type_action);
        $stmt->bindParam(':table_concernee', $this->table_concernee);
        $stmt->bindParam(':id_enregistrement', $this->id_enregistrement);
        $stmt->bindParam(':details', $this->details);

        return $stmt->execute();
    }

    // Lire tous les enregistrements de l'historique
    public function read() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY date_action DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>