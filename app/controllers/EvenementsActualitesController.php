<?php
namespace App\Controllers;


use App\Core\Controller;
use App\Models\Database; 
use App\Models\Evenement; 
use App\Models\Actualite; 

class EvenementsActualitesController extends Controller{
    private $evenement;
    private $actualite;

    public function __construct() {
        $db = new Database();
        $this->evenement = new Evenement($db->connect());
        $this->actualite = new Actualite($db->connect());
    }

    public function getAllEvenements() {
        $stmt = $this->evenement->read();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllActualites() {
        $stmt = $this->actualite->read();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
?>
