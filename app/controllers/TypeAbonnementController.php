<?php
namespace App\Controllers;

use App\Core\Controller;
require_once __DIR__ . '/../models/TypeAbonnement.php';
require_once __DIR__ . '/../models/db.php';
require_once __DIR__ . '/../core/Controller.php';
class TypeAbonnementController extends Controller {
    private $typeAbonnementModel;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->typeAbonnementModel = new TypeAbonnement($db);
    }

    /**
     * Get all subscription types.
     *
     * @return array
     */
    public function getAll() {
        return $this->typeAbonnementModel->getAll();
    }
}
?>