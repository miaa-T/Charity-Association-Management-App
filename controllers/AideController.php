<?php
require_once __DIR__ . '/../models/Aide.php';
require_once __DIR__ . '/../models/db.php';

class AideController {
    private $aide;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->aide = new Aide($db);
    }

    public function getTypesAide() {
        $result = $this->aide->lire();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>