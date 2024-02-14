<?php
@session_start(); // Start the session
include("connection.php"); // Include connection.php file

// Check if the user's ID is stored in the session upon login
$userLoggedIn = isset($_SESSION['userID']);

?>

