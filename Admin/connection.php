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
?>