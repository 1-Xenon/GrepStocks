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

$email = sanitizeInput($_POST["email"]);
$password = sanitizeInput($_POST["password"]);


//function to check whether password meets the requirements 
function validatePassword($password)
{
    $alphanumeric = preg_match('/[a-zA-Z0-9]/', $password); //checks password for alphanumeric characters
    $specialCharacters = preg_match('/[^a-zA-Z0-9]/', $password); //checks password for special characters


    return $alphanumeric && $specialCharacters;


}

//To update a user
function updateUser($username, $email, $password, $con)
{
    // Validate the password format
    if (!validatePassword($password)) {
        echo '<script> alert("Password does not meet requirements.");
        window.location.href = "updateform.php";</script>';
        return false;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // hashes password and salts the hash for additional layer of security

    // SQL query to update the user's email and password
    $query = "UPDATE grepstocks.users SET email = '$email', password = '$hashedPassword' WHERE username = '$username'";

    $result = mysqli_query($con, $query); // sends the query to the database

    if (!$result) {
        echo '<script> alert("Update failed. Please try again.");
        window.location.href = "updateform.php";</script>';
    } else {
        echo '<script> alert("User updated successfully!")
        window.location.href = "manageAccounts.php";</script>';
    }
}
//To update a staff
function updateStaff($username, $password, $email, $con)
{
    // Validate the password format
    if (!validatePassword($password)) {
        echo '<script> alert("Password does not meet requirements.");
        window.location.href = "updateform.php";</script>';
        return false;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // hashes password and salts the hash for additional layer of security

    $query = "UPDATE grepstocks.staff SET password='$hashedPassword',email='$email' WHERE username = '$username'"; //query that will be used to insert the data into the database

    $result = mysqli_query($con, $query); // sends the query to the database

    if (!$result) {
        echo '<script> alert("Update failed. Please try again.");
        window.location.href = "updateform.php";</script>';

    } else {
        echo '<script> alert("User updated successfully!")
        window.location.href = "manageAccounts.php";</script>';
    }

}

//To update an admin
function updateAdmin($username, $password, $con)
{
    // Validate the password format
    if (!validatePassword($password)) {
        echo '<script> alert("Password does not meet requirements.");
        window.location.href = "updateform.php";</script>';
        return false;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // hashes password and salts the hash for additional layer of security

    $query = "UPDATE grepstocks.admin SET password='$hashedPassword' where username = '$username'"; //query that will be used to insert the data into the database

    $result = mysqli_query($con, $query); // sends the query to the database

    if (!$result) {
        echo '<script> alert("Update failed. Please try again.");
        window.location.href = "updateform.php";</script>';

    } else {
        echo '<script> alert("User updated successfully!")
        window.location.href = "manageAccounts.php";</script>';
    }

}

switch ($type) {
    case "users":
        updateUser($username, $email, $password, $con);
        break;
    case "staff":
        updateStaff($username, $password, $email, $con);
        break;
    case "admin":
        updateAdmin($username, $password, $con);
        break;
}
?>
