<?php

require_once 'vendor/autoload.php'; // include the  libraries needed
include_once 'rate-limiting.php'; // include the rate-limiting.php to access the function

use OTPHP\TOTP;  // import the TOTP class from the OTP package ( look under vendor to find out more)

@session_start(); // resume the session that has been created
$username = $_SESSION['username']; // initialize the $username variable by assigning the stored username within the SESSION

//connect to the database
$con = mysqli_connect("localhost", "registeredCustomer", "xKAt*V8y2WRMnkfK", "grepstocks");
if (!$con) {
    die('Could not connect: ' . mysqli_connect_errno());
}

//get the secretKey that is stored in the database
$query = "SELECT userID, secretKey FROM grepstocks.users WHERE username = '$username'"; // prepare the statement that will be sent to the database
$result = mysqli_query($con, $query); // executes the query

if ($result) {
    $row = mysqli_fetch_assoc($result); //obtain the result from the query and stores it in an array
    if ($row) {
        $storedSecret = $row['secretKey']; // assign the stored secret to a local variable
        $_SESSION['userID'] = $row['userID']; // assign the userID of the particular user to the session variable 
    }
}


//verify the OTP given by the user
function verifyUserInputOTP($userInputOTP, $storedSecret) {
    $totp = TOTP::create($storedSecret); // create new time-based OTP, uses the stored secretKey within the database to ensure that the time-based OTP belongs to that customer only
    return $totp->verify($userInputOTP); // verify that the time-based OTP given matches the generated time-based OTP
}


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

    return $input; // returns a sanitized string
}


function validateOTP($con, $username, $storedSecret){
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['otp'])) {

        $ip = getClientIP(); // gets the customer's IP address
        $result = checkRateLimit($ip); // checks whether the customer has reached the rate limit
        
        $OTP = sanitizeInput($_POST['otp']);
        
        //verify that the OTP is correct
        if (verifyUserInputOTP($OTP, $storedSecret)) {
            date_default_timezone_set('Asia/Singapore'); // set default timezone to Singapore timezone
            $_SESSION["loginTime"] = date("Y-m-d H:i:s", time()); // captures the time the user login
            $time = $_SESSION["loginTime"];
            $description="Login time";


            $query = "INSERT INTO grepstocks.userLog (username, time, description) VALUES ('$username', '$time', '$description')";

            $result=mysqli_query($con, $query); // sends the query to the database

            if(!$result){
                echo '<script>
                alert("System Error. Please try again.");
                window.location.href = "2fa.php";
                </script>'; //informs the customer that there is a system error and redirects back to 2fa page
                mysqli_close($con); // closes the connection to the database
                exit(); // exits the function
            }
            else{
                echo '<script>
                alert("OTP has been verified.");
                window.location.href = "homepage.php";
                </script>'; // informs the customer that the OTP has been verified and redirects back to home page 
                mysqli_close($con); // closes the connection to the database
                exit(); // exits the function
            }
           
        } else {
            echo '<script>
                alert("Invalid OTP. Please try again.");
                window.location.href = "2fa.php";
                </script>'; // informs the customer that the OTP provided is invalid and redirects back to 2fa page
                mysqli_close($con); // closes the connection to the database
                exit(); // exits the function
        }
    }
}

validateOTP($con, $username, $storedSecret); // calls the function





?>