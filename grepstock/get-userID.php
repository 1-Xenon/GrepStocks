<?php

// Make sure you have the session started
@session_start();

// Check if the user is logged in by checking for the username in the session
if (isset($_SESSION['username'])) {
    // Sanitize the username to prevent SQL injection
    $username = sanitizeInput($_SESSION['username']);

    // SQL to fetch the userID for the username
    $sql = "SELECT userID FROM users WHERE username = ?";

    // Prepare the SQL statement to prevent SQL injection
    if ($stmt = mysqli_prepare($con, $sql)) {
        // Bind the username to the statement
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Bind the result
        mysqli_stmt_bind_result($stmt, $userID);

        // Fetch the result
        if (mysqli_stmt_fetch($stmt)) {
            // Store userID in the session
            $_SESSION['userID'] = $userID;
        } else {
            // Handle case where no userID is found for the username
            echo 'No user found for the provided username.';
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle case where statement could not be prepared
        echo 'Database query error: ' . mysqli_error($con);
    }
} else {
    // Handle case where user is not logged in or username is not in session
    //  echo 'User is not logged in.';
}

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
