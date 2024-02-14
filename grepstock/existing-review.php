<?php
@session_start();
include("connection.php");

$productID = $_GET['productID'];

// Assuming the user's ID is stored in the session upon login
$userID = $_SESSION['userID'] ?? null;

if ($userID) {
    // Check if the user has already reviewed this product
    $existing_review_query = "SELECT reviewID FROM reviews WHERE userID = ? AND productID = ?";
    $has_existing_review = false;
    if ($stmt = mysqli_prepare($con, $existing_review_query)) {
        mysqli_stmt_bind_param($stmt, "ii", $_SESSION['userID'], $productID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        // Check if a review exists
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $has_existing_review = true;
        }
        mysqli_stmt_close($stmt);
    }

}


?>

