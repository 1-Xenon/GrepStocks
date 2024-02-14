<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect to login page
    header("Location: staff.php");
    exit();
}
?>