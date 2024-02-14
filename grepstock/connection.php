<?php
$con = mysqli_connect("localhost","registeredCustomer","xKAt*V8y2WRMnkfK","grepstocks"); //connect to database
if (!$con){
    echo "Failed to connect to MySQL: " . mysqli_connect_error(); //return error is connect fail
}

?>