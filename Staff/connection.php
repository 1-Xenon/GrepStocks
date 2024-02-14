<?php
 //To connect to database
 $dbname = "grepstocks";
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpwd = "";

 $con = new mysqli($dbhost, $dbuser, $dbpwd, $dbname);
 if ($con->errno) {
     echo "Unable to connect";
 } else {
     // echo "Connected successfully";
 }
 
 function fetchProductDetails($con, $productID) {
     $statement = $con->prepare("SELECT * FROM products WHERE productID = ?");
     $statement->bind_param("i", $productID);
     $statement->execute();
     $result = $statement->get_result();
     
     // Check if a row is returned
     if ($row = $result->fetch_assoc()) {
         return $row;
     } else {
         return false; // or handle as needed
     }
 }
 
?>
