<?php



$con = mysqli_connect("localhost","registeredCustomer","xKAt*V8y2WRMnkfK","grepstocks"); //connect to database
if (!$con){
	die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}

include_once 'rate-limiting.php';

@session_start();
$username = $_SESSION['username']; //makes the username stored in the session variable a local variable


function checkOldPassword($oldPassword, $username, $con){

    if ($_SERVER["REQUEST_METHOD"] == "POST"){ // check if the method is POST
        

        if(validatePassword($oldPassword)){ // validates the old password

            $sql=$con->prepare("SELECT * FROM grepstocks.users where username='$username'");

            $sql->execute(); // executes the prepared statement above

            $result = $sql->get_result(); // stores the results from the sql query into a array 

            $row = $result->fetch_assoc(); // gets the results from the array

            $rPassword = $row['password']; // assigns the variable to the data that is returned from the query
            
            if (password_verify($oldPassword, $rPassword)){// checks whether the password matches the hashed password found inside the database

                return $oldPassword; // if found, return the old password

            }
            else{
                //if not found, it will redirect the customer back to the login page
                @session_unset(); //unset the items inside the session variable
                @session_destroy(); // destroy the session variable
                mysqli_close($con); //close the connection to the database
                echo '<script>
                alert("Invalid Account. Please login with a valid account.");
                window.location.href = "loginCustomer.php"; 
                </script>'; // informs the customer to login with a valid account and redirect back to the login page
                exit(); //exit the function
            }
        }
        else{
            echo '<script>
                alert("Please ensure that your old password contains at least one special character and contains alphanumeric characters.");
                window.location.href = "changePasswordForm.php";
                </script>'; // informs the customer to enter the password with the right format and redirect back to the same page
        }
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

    return $input; //returns a sanitized string
}



function validatePassword($input){
    $alphanumeric = preg_match('/[a-zA-Z0-9]/', $input); //checks password for alphanumeric characters
    $specialCharacters = preg_match('/[^a-zA-Z0-9]/', $input); //checks password for special characters

    return $alphanumeric && $specialCharacters;

}

function changePassword($username, $con){

    if ($_SERVER["REQUEST_METHOD"] == "POST"){ // check if the method is POST
        $newPassword = sanitizeInput($_POST['newPassword']); // sanitize the new password input and initialize the new password into a local variable
        $confirmNewPassword = sanitizeInput($_POST['confirmNewPassword']); // sanitize the confirm new password input and initialize the confirm new password into a local
        $oldPassword = sanitizeInput($_POST['oldPassword']); //sanitize the old password input and initialize the old password into a local variable
        
        $ip = getClientIP(); // gets the customer's IP address
        $result = checkRateLimit($ip); // checks whether the customer has reached the rate limit

        checkOldPassword($oldPassword, $username, $con); // calls the function from above

        if (validatePassword($newPassword) && validatePassword($confirmNewPassword)){ // validate the new password and confirm new password variables
            if ($newPassword != $oldPassword){ // ensure that the new password does not matach with the old password
                if ($newPassword == $confirmNewPassword){ // if the new password matches the confirm new password

                    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT); // hashes password and salts the hash for additional layer of security
                    $query = "UPDATE grepstocks.users SET password = '$hashedPassword' WHERE username = '$username'"; // prepare the statement that will be inserted into the database
    
                    $result = mysqli_query($con, $query); // execute the statement
            
                    if(!$result){
                        echo '<script>
                        alert("System error. Please try again.");
                        window.location.href = "changePasswordForm.php";
                        </script>'; // informs the customer that there was an error and redirect back to the same page
                        mysqli_close($con); // closes the connection to the database
                        exit(); // exits the function
                    }else{

                        date_default_timezone_set('Asia/Singapore'); // set default timezone to Singapore timezone
                        $_SESSION["changePassword"] = date("Y-m-d H:i:s", time()); // captures the time the user changes password
                        $time = $_SESSION["changePassword"];
                        $description="Changed Password";
                        $query = "INSERT INTO grepstocks.userLog (username, time, description) VALUES ('$username', '$time', '$description')";
                        $result=mysqli_query($con, $query); // sends the query to the database
                        mysqli_close($con); // closes the connection to the database
                        echo '<script>
                        alert("Password has been changed successfully.");
                        window.location.href = "userAccount.php"; //informs the customer that the password has been changed and redirects back to the user account page
                        </script>';
                    }

                }else{
                    echo '<script>
                    alert("New Password and Confirm New Password do not match. Please try again.");
                    window.location.href = "changePasswordForm.php"; // informs the customer that the passwords do not match and redirects back to the same page
                    </script>';
                    exit(); // exits the function
                }
            }else{
                echo '<script>
                alert("You are not allowed to reuse the same password.");
                window.location.href = "changePasswordForm.php"; // informs the customer that the password cannot be reused and redirects back to same page
                </script>';
                exit(); // exits the function
                
            }
        }else{
            echo '<script>
                alert("Please ensure that your new password contains at least one special character and contains alphanumeric characters.");
                window.location.href = "changePasswordForm.php"; // informs the customer the necessary format for the password and redirects back to the same page
                </script>';
                exit(); // exits the function
        }
    }
}

changePassword($username,$con);





?>