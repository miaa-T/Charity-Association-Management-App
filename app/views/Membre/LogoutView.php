<?php
class LogoutView {
    public function render() {
        session_start();
        session_destroy();
        header('Location: index.php');
    }
}
?>