<?php



$con = mysqli_connect("localhost","registeredCustomer","xKAt*V8y2WRMnkfK","grepstocks"); //connect to database
if (!$con){
	die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}

include_once 'rate-limiting.php';


function userExist($input, $con){ // To check whether username exists in database

    $query = "SELECT * FROM users WHERE username = '$input'"; 
    $result = $con->query($query);

    if ($result->num_rows > 0){ // if the result does not return empty then it shows that the username is already in use.
        return $input; // return the username since the username exists in the database
    }
    else{
        echo '<script>
            alert("Username is not in use. Please register for an account before attempting to login.");
            window.location.href = "registerUser.php";
            </script>'; // alert the customer that the username is already in use and redirects the customer back to the registration page.
        mysqli_close($con); // closes the connection to the database
        exit(); // exits the function here 
    }

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

//function to check whether password meets the requirements 
function validatePassword($input){
    $alphanumeric = preg_match('/[a-zA-Z0-9]/', $input); //checks password for alphanumeric characters
    $specialCharacters = preg_match('/[^a-zA-Z0-9]/', $input); //checks password for special characters


    return $alphanumeric && $specialCharacters; 
        
        
}



function login($con){

    if ($_SERVER["REQUEST_METHOD"] == "POST") { // check if the method is POST

        $ip = getClientIP(); // gets the customer's IP address
        $result = checkRateLimit($ip); // checks whether the customer has reached the rate limit
        
        $username = sanitizeInput($_POST["username"]); // sanitize the username and initialize the variable

        $password = sanitizeInput($_POST["password"]); // sanitize the password and initialize the variable

        userExist($username, $con); // checks whether the username exists in the database
        if (validatePassword($password)){
            $sql=$con->prepare("SELECT * FROM grepstocks.users where username='$username'"); //prepare the statement that will be sent to the database to retrieve the data needed

            $sql->execute(); // executes the prepared statement above

            $result = $sql->get_result(); // stores the results from the sql query into a array 

            $row = $result->fetch_assoc(); // gets the results from the array

            $rPassword = $row['password']; // assigns the variable to the data that is returned from the query
            $cartID = $row['cartID']; // assign the variable to the data that is returned from the query
            $userID = $row['userID']; // assign the variable to the data that is returned from the query
            
            if (password_verify($password, $rPassword)){ // checks whether the password matches the hashed password found inside the database
                
                if (session_status() !== PHP_SESSION_ACTIVE){ // checks to see if there is an active session
                    session_start(); // starts the session
                    $_SESSION["username"] = $username; // stores the username in the session variable
                    $_SESSION['cartID'] = $cartID; // stores the cartID in the session variable
                    $_SESSION['userID'] = $userID; // stores the userID in the session variable
                }
                
                header ("Location: 2fa.php"); // sends the customer to the 2fa page to create a secret key to enable time-based OTP
                mysqli_close($con); // closes the connection to the database
                exit(); // exits the function
                
            }
            else{
                echo '<script>
                alert("Password given is wrong. Please try again");
                window.location.href = "loginCustomer.php";
                </script>'; // alert the customer that the username is already in use and redirects the customer back to the registration page.
                mysqli_close($con); // closes the connection to the database
                exit(); // exits the function here 
            }
        }
        else{
            echo '<script>
            alert("Password is invalid. Please try again. Password needs to contain alphanumeric characters and special characters.");
            window.location.href = "loginCustomer.php";
            </script>'; // alert the customer that the username is already in use and redirects the customer back to the registration page.
            mysqli_close($con); // closes the connection to the database
            exit(); // exits the function here 
        }
        
    }
}

login($con);

	







?>