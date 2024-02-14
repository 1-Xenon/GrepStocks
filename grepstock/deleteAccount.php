<?php

$con = mysqli_connect("localhost","deleteAccount","Raq5@OT(NajWPTTc","grepstocks"); //connect to database
if (!$con){
	die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}

@session_start();
$username = $_SESSION['username'];

function deleteAccount($username, $con){

    $query="DELETE FROM grepstocks.users where username='$username'";

    $result=mysqli_query($con, $query);

    if($result){
        echo '<script>
            alert("Account has been successfully deleted.");
            window.location.href = "registerUser.php";
            </script>'; // alert the customer that the account has been deleted and redirects the customer back to the registration page.
            date_default_timezone_set('Asia/Singapore'); // set default timezone to Singapore timezone
            $_SESSION["deleteAccount"] = date("Y-m-d H:i:s", time()); // captures the time the user deleted the account
            $time = $_SESSION["deleteAccount"];
            $description="Deleted account";
            $query = "INSERT INTO grepstocks.userLog (username, time, description) VALUES ('$username', '$time', '$description')";
            $result=mysqli_query($con, $query); // sends the query to the database

            session_unset(); // unset the items stored in the session variable
            session_destroy(); // destroys the session variable
            mysqli_close($con); // closes the connection to the database
            exit(); // exits the function

    }
    

}

deleteAccount($username, $con);

?>