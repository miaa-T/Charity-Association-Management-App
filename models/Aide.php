<?php
class Aide {
    private $conn;
    private $table = 'types_aide';

    public $id;
    public $type_aide;
    public $description;
    public $documents_necessaires;
    public $cree_le;
    public $modifie_le;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function lire() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>