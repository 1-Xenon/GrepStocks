<?php
include("connection.php");
session_start();

// Function to sanitize user input against common injection attacks and XSS
function sanitizeInput($input)
{
    // Remove leading and trailing whitespaces, preventing XSS attacks
    $input = trim($input);

    // Remove HTML and PHP tags, preventing XSS attacks
    $input = strip_tags($input);

    // Convert special characters to HTML entities, preventing XSS attacks
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

    // Checks for SQL injection and escapes the characters
    $input = str_replace(array("\\", "\0", "\n", "\r", "'", '"', "\x1a"), array("\\\\", "\\0", "\\n", "\\r", "\\'", '\\"', "\\Z"), $input);

    return $input;
}

// Capture the account type and username from the URL query parameter
$type = isset($_GET['type']) ? $_GET['type'] : 'users';
$username = isset($_GET['username']) ? $_GET['username'] : 'eugene';

// Function to delete user
function deleteUser($username, $con)
{
    // Prepare SQL statement to prevent SQL injection
    $stmt = $con->prepare("DELETE FROM grepstocks.users WHERE username = ?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        echo '<script> alert("User deleted successfully!")
        window.location.href = "manageAccounts.php";</script>';
    } else {
        echo '<script> alert("Unable to delete user, please try again!")
        window.location.href = "manageAccounts.php";</script>';
    }

    $stmt->close();
}

//Function to delete staff
function deleteStaff($username, $con)
{
    // Prepare SQL statement to prevent SQL injection
    $stmt = $con->prepare("DELETE FROM grepstocks.staff WHERE username = ?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        echo '<script> alert("User deleted successfully!")
        window.location.href = "manageAccounts.php";</script>';
    } else {
        echo '<script> alert("Unable to delete user, please try again!")
        window.location.href = "manageAccounts.php";</script>';
    }

    $stmt->close();
}

//Function to delete admin
function deleteAdmin($username, $con)
{
    // Prepare SQL statement to prevent SQL injection
    $stmt = $con->prepare("DELETE FROM grepstocks.admin WHERE username = ?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        echo '<script> alert("User deleted successfully!")
        window.location.href = "manageAccounts.php";</script>';
    } else {
        echo '<script> alert("Unable to delete user, please try again!")
        window.location.href = "manageAccounts.php";</script>';
    }

    $stmt->close();
}

switch ($type) {
    case "users":
        deleteUser($username,$con);
        break;
    case "staff":
        deleteStaff($username,$con);
        break;
    case "admin":
        deleteAdmin($username,$con);
        break;
}

$con->close();
?>