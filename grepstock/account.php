<?php



$con = mysqli_connect("localhost","registeredCustomer","xKAt*V8y2WRMnkfK","grepstocks"); //connect to database
if (!$con){
	die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}

function logout($con){

    @session_start(); // resume session
    date_default_timezone_set('Asia/Singapore'); // set default timezone to Singapore timezone
    $_SESSION['logoutTime'] = date("Y-m-d H:i:s", time()); // capture the logout time and saves it into the session variable

    $time = $_SESSION['logoutTime']; //makes the item in the session variable a local variable
    $username = $_SESSION['username']; // makes the item in the session variable a local variable
    $description="Logout time"; // initialize the variable 


    $query = "INSERT INTO grepstocks.userLog (username, time, description) VALUES ('$username', '$time', '$description')"; //prepares the statement to be sent to the database

    $result=mysqli_query($con, $query); // sends the query to the database

    if(!$result){
        echo "failure";

    }else{
        echo '<script>
            alert("Logout successfully");
            window.location.href = "loginCustomer.php"; // informs the customer that the customer has logged out successfully and redirects back to login page
            </script>';
        mysqli_close($con); // closes the connection to the database
        session_unset(); // unset the items stored in the session variable
        session_destroy(); // destroys the session variable
        exit(); // exits the function
    }
    
}



logout($con); // this will log the customer out, destroy the session and then redirect the customer back to the login page




?>