<?php
@session_start();
include("connection.php");
include("rate-limiting.php");
    
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the user is logged in and the username is set in the session
if (isset($_SESSION['username'])) {
    $username = sanitizeInput($_SESSION['username']); // Sanitize the username from the session

    // Prepare a SQL statement to get the userID from the users table using the username
    $sql = "SELECT userID FROM users WHERE username = ?";
    if ($stmt = mysqli_prepare($con, $sql)) {
        // Bind the username to the prepared statement
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Bind the result to a variable
        $result = mysqli_stmt_bind_result($stmt, $userID);

        // Fetch the data
        if (mysqli_stmt_fetch($stmt)) {
            // $userID is now set and can be used for further operations
            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Handle the case where no matching user is found
            echo "Error: No user found with that username.";
            exit;
        }
    } else {
        // Error in preparing the SQL statement
        echo "Error: " . mysqli_error($con);
        exit;
    }
} else {
    // Handle the case where the username is not in the session
    echo "Error: User is not logged in.";
    exit;
}


if (isset($_POST['add-review-submit'])) {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        exit('Error: Invalid CSRF token.');
    }
    
    // Validate and sanitize inputs
    // Assuming userID is stored in the session after login
    $username = $_SESSION['username'] ?? null;
    if (!$username) {
        // Redirect or handle the error if the user is not logged in
        exit('Error: You must be logged in to add a review.');
    }

    $reviewRating = intval($_POST['add-review-rating']); // Ensure integer value
    // Check if the rating is within the expected range
    if ($reviewRating < 1 || $reviewRating > 5) {
        exit('Error: Invalid rating value.');
    }

    $review = sanitizeInput($_POST['add-review-comment']);
    $productID = intval($_POST['productID']);

    // Check for word limit
    $maxWordCount = 150;
    if (str_word_count($review) > $maxWordCount) {
        echo "Error: Review exceeds the maximum limit of $maxWordCount words.";
        exit; // Stop further processing
    }

    // Prepare and execute SQL statement securely
    $sql = "INSERT INTO reviews (reviewID, userID, productID, review, reviewRating, reviewDatetime) VALUES (NULL, ?, ?, ?, ?, NOW())";
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "iisi", $userID, $productID, $review, $reviewRating);

        if (mysqli_stmt_execute($stmt)) {
            // Success message
            header('Location: singleproductpage.php?productID=' . $productID);
            exit();
        } else {
            // Error message
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        // Error in preparing statement
        echo "Error: " . mysqli_error($con);
    }
}


?>