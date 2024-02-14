<?php

@session_start();

if(isset($_SESSION['username'])){

    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1200)) { //include in all pages
        // last request was more than 20 minutes ago
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        echo '<script>
                alert("You have been logged out of your account, after 20 minutes of inactivity. Please log in again.");
                window.location.href = "loginCustomer.php";
                </script>'; // alert the customer that the customer has been timed out and redirects the customer back to the login page.
            mysqli_close($con); // closes the connection to the database
            exit(); // exits the function here 
    }
    $_SESSION['last_activity'] = time(); // update last activity time stamp
    }


?>
