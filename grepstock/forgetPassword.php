<?php
require_once 'vendor/autoload.php';
use OTPHP\TOTP;

@session_start();
$con = mysqli_connect("localhost", "registeredCustomer", "xKAt*V8y2WRMnkfK", "grepstocks");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_errno());
}

include_once 'rate-limiting.php';



// Function to sanitize user input against common injection attacks and XSS
function sanitizeInput($input) {
    // Remove leading and trailing whitespaces, preventing XSS attacks
    $input = trim($input);

    // Remove HTML and PHP tags, preventing XSS attacks
    $input = strip_tags($input);

    // Convert special characters to HTML entities, preventing XSS attacks
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

    // Checks for SQL injection and escapes the characters
    $input = str_replace(array("\\", "\0", "\n", "\r", "'", '"', "\x1a"), array("\\\\", "\\0", "\\n", "\\r", "\\'", '\\"', "\\Z"), $input);

    return $input; //returns a sanitized string
}

function validatePassword($input){
    $alphanumeric = preg_match('/[a-zA-Z0-9]/', $input); //checks password for alphanumeric characters
    $specialCharacters = preg_match('/[^a-zA-Z0-9]/', $input); //checks password for special characters

    return $alphanumeric && $specialCharacters;
}


//retrieve the secret key for the user from the database
function retrieveSecretForUser($con, $username) {
    
    //get the secretKey that is stored in the database
    $query = "SELECT secretKey FROM grepstocks.users WHERE username = '$username'"; // prepare the statement that will be sent to the database
    $result = mysqli_query($con, $query); // executes the query

    if ($result) {
        $row = mysqli_fetch_assoc($result); //obtain the result from the query and stores it in an array
        if ($row) {
            $storedSecret = $row['secretKey']; // assign the stored secret to a local variable
        }
    }
    return $storedSecret;
}


function changePassword($newPassword, $username, $con){

    $newPassword = sanitizeInput($newPassword);

    $sql=$con->prepare("SELECT * FROM grepstocks.users where username='$username'");

    $sql->execute(); // executes the prepared statement above

    $result = $sql->get_result(); // stores the results from the sql query into a array 

    $row = $result->fetch_assoc(); // gets the results from the array

    $rPassword = $row['password']; // assigns the variable to the data that is returned from the query
        
    if (password_verify($newPassword, $rPassword)){ //verifies that the customer is not reusing the same password

        echo '<script>
        alert("You are not allowed to reuse the same password.");
        window.location.href = "loginCustomer.php"; //informs the customer that they are using the same password and redirects back to the login page
        </script>';
        mysqli_close($con); // closes the connection to the database
        session_unset(); // unset the items stored in the session variable
        session_destroy(); // destroys the session variable
        exit(); // exit the function
        
    } // checks whether the password matches the hashed password found inside the database
            
    else{

        if (validatePassword($newPassword)){ //ensure the the password given follows the format required
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT); // hashes password and salts the hash for additional layer of security

            $query = "UPDATE grepstocks.users SET password = '$hashedPassword' WHERE username = '$username'"; //prepares the statement to allow the customer to update the password
    
            $result = mysqli_query($con, $query); //executes the query
    
            if(!$result){
                echo '<script>
                alert("System error. Please try again.");
                window.location.href = "forgetPasswordForm.php"; // informs the customer that a system error occurred and redirect back to the same page
                </script>';
                mysqli_close($con); // closes the connection to the database
                session_unset(); // unset the items stored in the session variable
                session_destroy(); // destroys the session variable
                exit();
            }
        }
        else{

            echo '<script>
            alert("Please ensure that your password contains at least one special character and contains alphanumeric characters.");
            window.location.href = "loginCustomer.php"; //informs the customer of the required format for the password and redirects back to login page
            </script>';
            mysqli_close($con); // closes the connection to the database
            session_unset(); // unset the items stored in the session variable
            session_destroy(); // destroys the session variable
            exit(); //exits the function

        }
    }
    
}


$isVerified = false; // Variable to track OTP verification status

function authenticateCustomer($isVerified, $con){
    // Handle the OTP verification form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verifyTOTP'])) {
         // check the method is POST and whether the verifyTOTP has been set

        $username = sanitizeInput($_POST['username']); //sanitize the username and stores it in a local variable
        $inputTOTP = sanitizeInput($_POST['otp']); //sanitize the OTP and stores it in a local variable
        $storedSecret = retrieveSecretForUser($con, $username); // initialize the variable storeSecret and assign it the value from the stored secret retrieve from the database

        $totp = TOTP::create($storedSecret); // create the OTP based on the stored secret
        if ($totp->verify($inputTOTP)) { // verify that the OTP matches the OTP generated 
            $isVerified = true; // sets the variable to true
            $_SESSION['isVerified'] = true; // stores the variable into the session variable
            $_SESSION['username'] = $username; // stores the variable into the session variable
            header("Location: forgetPasswordForm.php"); // send the customer to the same page but now allows the customer to change the password
        } else {
            echo '<script>
            alert("Invalid OTP, please try again.");
            window.location.href = "forgetPasswordForm.php"; //informs the customer that the OTP provided is invalid and redirects back to the same page
            </script>';
            mysqli_close($con); // closes the connection to the database
            session_unset(); // unset the items stored in the session variable
            session_destroy(); // destroys the session variable
            exit(); // exits the function
        }
}
} 

authenticateCustomer($isVerified, $con);


function newPassword($con){
    // Handle the password change form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['changePassword'])) { //checks the method is POST and whether changePassword has been set
        $username = $_SESSION['username'] ?? ''; 
        $newPassword = $_POST['newPassword'];

        $ip = getClientIP(); // gets the customer's IP address
        $result = checkRateLimit($ip); // checks whether the customer has reached the rate limit

        changePassword($newPassword, $username, $con); // calls the function

        date_default_timezone_set('Asia/Singapore'); // set default timezone to Singapore timezone
        $_SESSION["changePassword"] = date("Y-m-d H:i:s", time()); // captures the time the user changes password
        $time = $_SESSION["changePassword"];
        $description="Changed Password";
        $query = "INSERT INTO grepstocks.userLog (username, time, description) VALUES ('$username', '$time', '$description')";
        $result=mysqli_query($con, $query); // sends the query to the database
        
        echo '<script>
            alert("Password changed successfully");
            window.location.href = "loginCustomer.php"; // informs the customer that the password has been changed successfully and redirects back to login page
            </script>';
        mysqli_close($con); // closes the connection to the database
        session_unset(); // unset the items stored in the session variable
        session_destroy(); // destroys the session variable
        exit(); // exits the function
    
    }
}

newPassword($con);
?>