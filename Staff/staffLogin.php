<?php
include("connection.php");

function userExist($input, $con)
{ // To check whether username is already in use 

    $query = "SELECT * FROM staff WHERE username = '$input'";
    $result = $con->query($query);

    if ($result->num_rows > 0) {
        return $input;
    } else {
        echo '<script> alert("Username is not valid. Please try again.");
        window.location.href = "staff.php";</script>';
        exit();
    }
}

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

function validatePassword($password)
{
    $alphanumeric = preg_match('/[a-zA-Z0-9]/', $password); //checks password for alphanumeric characters
    $specialCharacters = preg_match('/[^a-zA-Z0-9]/', $password); //checks password for special characters


    return $alphanumeric && $specialCharacters;


}
function attemptLogin($con) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = sanitizeInput($_POST["username"]); // sanitize the username and initialize the variable
        $password = sanitizeInput($_POST["password"]); // sanitize the password and initialize the variable
        userExist($username, $con); // checks whether the username exists in the database

        if (validatePassword($password)){
            $sql=$con->prepare("SELECT * FROM grepstocks.staff where username='$username'"); //prepare the statement that will be sent to the database to retrieve the data needed

            $sql->execute(); // executes the prepared statement above

            $result = $sql->get_result(); // stores the results from the sql query into a array 

            $row = $result->fetch_assoc(); // gets the results from the array

            $rPassword = $row['password']; // assigns the variable to the data that is returned from the query

            if (password_verify($password, $rPassword)){ // checks whether the password matches the hashed password found inside the database
                
                if (session_status() !== PHP_SESSION_ACTIVE){ // checks to see if there is an active session
                    session_start(); // starts the session
                    $_SESSION["username"] = $username; // stores the username in the session variable
                }
                header("Location: staffHome.php");
                mysqli_close($con); // closes the connection to the database
                exit(); // exits the function
            }
            else{
                echo '<script>
                alert("Password given is wrong. Please try again");
                window.location.href = "staff.php";
                </script>'; 
                mysqli_close($con); // closes the connection to the database
                exit(); // exits the function here 
            }
        }
        else{
            echo '<script>
            alert("Password is invalid. Please try again. Password needs to contain alphanumeric characters and special characters.");
            window.location.href = "staff.php";
            </script>'; 
            mysqli_close($con); // closes the connection to the database
            exit(); // exits the function here 
        }
        
    }
}
    

attemptLogin($con);  


?>