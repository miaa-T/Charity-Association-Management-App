<?php
namespace App\Models;

require_once __DIR__ . '/../core/Model.php';

class TypeAbonnement {
    private $conn;
    private $table = 'type_abonnement';

    public $nom;
    public $prix_annuel;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>