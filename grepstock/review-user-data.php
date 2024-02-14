<?php

// Inside your file that fetches the review data
$specific_product_sql_review = "
    SELECT reviews.*, users.username, users.profilepicture 
    FROM reviews 
    INNER JOIN users ON reviews.userID = users.userID 
    WHERE reviews.productID = ?
";

// Prepare the SQL statement to prevent SQL injection
if ($stmt = $con->prepare($specific_product_sql_review)) {
    $stmt->bind_param("i", $productID); // 'i' specifies the variable type => 'integer'
    $stmt->execute();
    
    // Get the result of the query
    $all_reviews = $stmt->get_result();
    
    // Now you can fetch the reviews in your HTML with a loop
    // ...

    $stmt->close();
} else {
    // Handle errors with preparing the statement
    echo "ERROR: Could not prepare query: " . $con->error;
}
?>