<?php
namespace App\Core;
class Controller {
    protected function view($view, $data = []) {
        extract($data);
        require_once "app/views/{$view}.php";
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit();
    }

    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}
?>