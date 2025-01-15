<?php
session_start(); // Start the session

// Include the controller
require_once __DIR__ . '/controllers/MembresController.php';

// Instantiate the controller
$membreController = new MembreController();

// Call the method to display the member card
$membreController->displayMemberCard();
?>