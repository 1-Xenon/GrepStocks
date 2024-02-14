<?php

include("connection.php");
@session_start();

$productID = $_GET['productID'] ?? null;
$userID = $_SESSION['userID'] ?? null;
$canEditReview = true; // Assume the user can edit by default

if ($userID && $productID) {
    // Prepare the SQL query to check the last review edit time
    $query = "SELECT reviewEditTime, reviewDateTime FROM reviews WHERE userID = ? AND productID = ?";
    if ($stmt = mysqli_prepare($con, $query)) {
        mysqli_stmt_bind_param($stmt, "ii", $userID, $productID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $reviewEditTime, $reviewDateTime);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_fetch($stmt);

            // Use reviewEditTime if it's not null, otherwise fall back to reviewDateTime
            $editTimeToCheck = $reviewEditTime ?? $reviewDateTime;
            
            // Calculate the time difference
            date_default_timezone_set("Singapore");
            $currentTime = new DateTime();
            //echo $currentTime->format('Y-m-d H:i:s');
            $lastEditTime = new DateTime($editTimeToCheck);
            $interval = $currentTime->diff($lastEditTime);

            // Calculate total minutes since last edit
            $minutesSinceLastEdit = $interval->days * 24 * 60;
            $minutesSinceLastEdit += $interval->h * 60;
            $minutesSinceLastEdit += $interval->i;

            if ($minutesSinceLastEdit < 1) {
                $canEditReview = false;
            }
        }
        mysqli_stmt_close($stmt);
    }
} else {
    // Handle case where productID or userID is not set
    $canEditReview = false; // This might be adjusted based on your application's needs
}

?>

