<?php
namespace App\Models;

class Database {
    private $host = 'localhost';
    private $db_name = 'elmountada';
    private $username = 'root'; 
    private $password = ''; 
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            // Use \PDO to reference the global PDO class
            $this->conn = new \PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}