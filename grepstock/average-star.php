<?php
    include("connection.php");
    $productID = $_GET['productID'];

    // Calculate average rating using SQL
    $average_rating_sql = "SELECT ROUND(AVG(reviewRating), 1) AS average_rating FROM reviews WHERE productID = $productID";
    $average_rating_result = $con->query($average_rating_sql);
    $average_rating_row = $average_rating_result->fetch_assoc();
    $average_rating = $average_rating_row['average_rating'];

?>