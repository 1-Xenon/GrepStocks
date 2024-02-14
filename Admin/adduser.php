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

$username = sanitizeInput($_POST["username"]);
$email = sanitizeInput($_POST["email"]);
$password = sanitizeInput($_POST["password"]);
if (isset($_POST["type"])) {
    $type = $_POST["type"];
} else {
    // Handle the case when type is not set in POST data
}

//Function to check for unique usernames in Users table
function uniqueUsername($username, $con)
{
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        echo '<script> alert("Username is already in use.");
        window.location.href = "addform.php";</script>';
        exit;
    } else {
        return $username;
    }

}
//Function to check for unique usernames in Staff table
function uniqueStaffName($username, $con)
{
    $query = "SELECT * FROM staff WHERE username = '$username'";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        echo '<script> alert("Username is already in use.");
        window.location.href = "addform.php";</script>';
        exit;
    } else {
        return $username;
    }

}
//Function to check for unique usernames in Admin table
function uniqueAdminName($username, $con)
{
    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        echo '<script> alert("Username is already in use.");
        window.location.href = "addform.php";</script>';
        exit;
    } else {
        return $username;
    }

}

//function to check whether password meets the requirements 
function validatePassword($password)
{
    $alphanumeric = preg_match('/[a-zA-Z0-9]/', $password); //checks password for alphanumeric characters
    $specialCharacters = preg_match('/[^a-zA-Z0-9]/', $password); //checks password for special characters


    return $alphanumeric && $specialCharacters;

}

//To register regular user
function registerUser($username, $email, $password, $con)
{
    // Check whether the username is unique
    if (!uniqueUsername($username, $con)) {
        echo '<script> alert("Username is already in use.");
        window.location.href = "addform.php";</script>';
        return false;
    }

    // Validate the password format
    if (!validatePassword($password)) {
        echo '<script> alert("Password does not meet requirements.");
        window.location.href = "addform.php";</script>';
        return false;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // hashes password and salts the hash for additional layer of security

    $query = "INSERT INTO grepstocks.users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')"; //query that will be used to insert the data into the database

    $result = mysqli_query($con, $query); // sends the query to the database

    if (!$result) {
        echo '<script> alert("Registration failed. Please try again.");
        window.location.href = "addform.php";</script>';

    } else {
        echo '<script> alert("User added successfully!")
        window.location.href = "viewAccounts.php";</script>';
    }

}

//To register a staff
function registerStaff($username, $password, $email, $con)
{
    // Check whether the username is unique
    if (!uniqueStaffName($username, $con)) {
        echo '<script> alert("Username is already in use.");
        window.location.href = "addform.php";</script>';
        return false;
    }

    // Validate the password format
    if (!validatePassword($password)) {
        echo '<script> alert("Password does not meet requirements.");
        window.location.href = "addform.php";</script>';
        return false;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // hashes password and salts the hash for additional layer of security

    $query = "INSERT INTO grepstocks.staff (username, password, email) VALUES ('$username', '$hashedPassword', '$email')"; //query that will be used to insert the data into the database

    $result = mysqli_query($con, $query); // sends the query to the database

    if (!$result) {
        echo '<script> alert("Registration failed. Please try again.");
        window.location.href = "addform.php";</script>';

    } else {
        echo '<script> alert("User added successfully!")
        window.location.href = "viewAccounts.php";</script>';
    }

}

//To register a new admin
function registerAdmin($username, $password, $con)
{

    // Check whether the username is unique
    if (!uniqueAdminName($username, $con)) {
        echo '<script> alert("Username is already in use.");
        window.location.href = "addform.php";</script>';
        return false;
    }

    // Validate the password format
    if (!validatePassword($password)) {
        echo '<script> alert("Password does not meet requirements.");
        window.location.href = "addform.php";</script>';
        return false;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // hashes password and salts the hash for additional layer of security

    $query = "INSERT INTO grepstocks.admin (username, password) VALUES ('$username', '$hashedPassword')"; //query that will be used to insert the data into the database

    $result = mysqli_query($con, $query); // sends the query to the database

    if (!$result) {
        echo '<script> alert("Registration failed. Please try again.");
        window.location.href = "addform.php";</script>';

    } else {
        echo '<script> alert("User added successfully!")
        window.location.href = "viewAccounts.php";</script>';
    }

}

switch ($type) {
    case "users":
        registerUser($username, $email, $password, $con);
        break;
    case "staff":
        registerStaff($username, $password, $email, $con);
        break;
    case "admin":
        registerAdmin($username, $password, $con);
        break;
}




?>