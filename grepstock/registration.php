<?php


$con = mysqli_connect("localhost","registeredCustomer","xKAt*V8y2WRMnkfK","grepstocks"); //connect to database
if (!$con){
	die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}

include_once 'rate-limiting.php';


function uniqueUsername($input, $con){ // To check whether username is already in use 

    $query = "SELECT * FROM users WHERE username = '$input'"; 
    $result = $con->query($query);

    if ($result->num_rows > 0){ // if the result does not return empty then it shows that the username is already in use.
        echo '<script>
            alert("Username is already in use. Please try again with a different username.");
            window.location.href = "registerUser.php";
            </script>'; // alert the customer that the username is already in use and redirects the customer back to the registration page.
        mysqli_close($con); // closes the connection to the database
        exit(); // exits the function here 
    }
    else{
        return $input; // returns the username 
    }

}


function uniqueEmailAddress($input, $con){
    $query = "SELECT * FROM users WHERE email = '$input'"; 
    $result = $con->query($query);

    if ($result->num_rows > 0){ // if the result does not return empty then it shows that the username is already in use.
        echo '<script>
            alert("Email is already in used. Please use another email.");
            window.location.href = "registerUser.php";
            </script>'; // alert the customer that the email is already in use and redirects the customer back to the registration page.
        mysqli_close($con); // closes the connection to the database
        exit(); // exits the function here 
    }
    else{
        return $input; // returns the username 
    }

}

//function to check whether password meets the requirements 
function validatePassword($input){
    $alphanumeric = preg_match('/[a-zA-Z0-9]/', $input); //checks password for alphanumeric characters
    $specialCharacters = preg_match('/[^a-zA-Z0-9]/', $input); //checks password for special characters


    return $alphanumeric && $specialCharacters; 
        
        
}


function generateCartId($con){

    $isUnique = false;
    $input = rand(1, 100); // generates a random cartID
    while (!$isUnique){ // check whether cartID is unique
        
        $query = "SELECT * FROM grepstocks.users WHERE cartID = '$input'";  //prepare query to be sent to database

        $result = mysqli_query($con, $query); // send the query to database

        if($result->num_rows == 0){ // if there is no result the function will stop and make $isUnique true 
            $isUnique = true;
        }
    }

    return $input; // return the number generated 
    exit(); // exits the function

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

    return $input; // returns the sanitized string
}

function uploadProfilePicture($input, $con){ // will allow customer to upload profile picture

    $targetDirectory = "profilePictures/"; // where the pictures will be stored
    $targetFile = $targetDirectory . basename($_FILES["profilePicture"]["name"]); // mergers the target directory with the filename together 
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION)); // checks the file extension and then lowers the characters 

    $allowedTypes = array("jpg", "png", "jpeg"); // initialize an array that contains the allowed file extension for the images
    if (in_array($imageFileType, $allowedTypes)){ // checks whether the file extension is allowed
    if(move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFile)){ // checks to ensure that the file uploaded has been moved to the $targetDirectory
        $input = sanitizeInput($targetFile); // sanitizes the input before it will be send to the server
        return $input;
    }else{
        echo '<script>
            alert("Failed to upload picture. Please try again");
            window.location.href = "registerUser.php";
            </script>'; // alerts the customer that the picture was not uploaded successfully, and redirects back to the registration page
            mysqli_close($con); // closes the connection to the database
            exit(); // exits the function
    }
    }else{
        echo '<script>
            alert("File type is not allowed. Please try again with the file types: jpg, png, jpeg");
            window.location.href = "registerUser.php";
            </script>'; // alerts the customer that the file type is not allowed and redirects back to the registration page
            mysqli_close($con); // closes the connection to the database
            exit(); // exits the function

    }
}
   
function registerUser($username, $email, $password, $confirmPassword, $profilePicture, $con){ // allows the customer to register for an account

    $username = uniqueUsername($username, $con); // checks whether username given is in use within the database
    $email = uniqueEmailAddress($email, $con); // checks whether email given is in use within the database

    $ip = getClientIP(); // gets the customer's IP address
    $result = checkRateLimit($ip); // checks whether the customer has reached the rate limit

    //ensure the passwords are valid and that the user keys in the same password for both input

    if (validatePassword($password) && validatePassword($confirmPassword)){
        if ($password == $confirmPassword){
        
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // hashes password and salts the hash for additional layer of security
            $cartID = generateCartId($con); // generates a random cartId that will be assigned to the customer
            $query="INSERT INTO grepstocks.users (username, email, password, profilePicture, cartID) VALUES ('$username', '$email', '$hashedPassword', '$profilePicture', '$cartID')"; //query that will be used to insert the data into the database
        
            $result=mysqli_query($con, $query); // sends the query to the database
    
            if(!$result){
                echo '<script>
                    alert("System Error, please try again");
                    window.location.href = "registerUser.php";
                    </script>'; // informs the customer that there has been an internal error within the system and redirects the customer back to the registration page
                mysqli_close($con); // closes the connection to the database
                exit(); // exits the function
    
            }
            else{
                
                if (session_status() !== PHP_SESSION_ACTIVE){ // checks to see if there is an active session
                    session_start(); // starts the session
                    $_SESSION["username"] = $username; // stores the customer's username within the SESSION variable
                    date_default_timezone_set('Asia/Singapore'); // sets the default timezone to Singapore timezone
                    $_SESSION["registrationTime"] = date("Y-m-d H:i:s", time()); // stores the registration time within the SESSION variable
                    $time = $_SESSION["registrationTime"]; // initializes the the local variable time 
                    $description = "Registration"; // initializes the description

                    $query = "INSERT INTO grepstocks.userLog (username, time, description) VALUES ('$username', '$time', '$description')"; // prepares the the statement to insert into the database

                    $result=mysqli_query($con, $query); // sends the query to the database
                    
                    if(!$result){
                        echo '<script>
                        alert("System Error, please try again");
                        window.location.href = "registerUser.php";
                        </script>'; // informs the customer that there has been an internal error within the system and redirects the customer back to the registration page
                        session_unset(); // removes the data stored in session variable
                        session_destroy(); // destroys the session variable
                        mysqli_close($con); // closes the connection to the database
                        exit(); // exits the function
                    }
                }
                session_unset();
                session_destroy();
                echo '<script>
                alert("Account has been successfully registered. Please login to your account.");
                window.location.href = "loginCustomer.php";
                </script>'; // informs the customer the account has been successfully registered, and redirects the user to the login page
                mysqli_close($con); // closes the connection to the database
                exit(); // exits the function
            }
    
        }
        else{
            echo '<script>
            alert("Password and Confirm Password do not match. Please try again.");
            window.location.href = "registerUser.php";
            </script>'; // informs the customer that the password and confirm password do not match and redirects the customer back to the registration page
            mysqli_close($con); // closes the connection to the database
            exit(); // exits the function
        }
    
    }else{
        echo '<script>
        alert("Passwords are invalid. Please try again. Password needs to contain alphanumeric characters and special characters.");
        window.location.href = "registerUser.php";
        </script>'; // informs the customer that the password given is invalid and redirects the customer back to the registration page
        mysqli_close($con); // closes the connection to the database
        exit(); // exits the function
    }





}


$username = sanitizeInput($_POST["username"]); // sanitize and initialize the username
$email = sanitizeInput($_POST["email"]); // sanitize and initialize the email
$password = sanitizeInput($_POST["password"]); // sanitize and initialize the password
$confirmPassword = sanitizeInput($_POST["confirmPassword"]); // sanitize and initialize the confirm password
$profilePicture=""; //initialize the profile picture as an empty string since the file has to be process by another function before being sent into the database


registerUser($username, $email, $password, $confirmPassword, uploadProfilePicture($profilePicture, $con), $con); // calls the function





?>