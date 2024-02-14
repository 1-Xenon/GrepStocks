<?php

include('connection.php');
include('all-products.php');

// Start the session to use session variables
session_start();

function deleteCart($con) {
    if (isset($_POST['deleteCart'])) {
        // Get the cartItemID from the POST request
        // Make sure this matches the name of the input field in your form
        $cartItemID = $_POST['deleteCart'];
        
        // Prepare the SQL query to delete the item from the cart based on cartItemID
        $query = "DELETE FROM cart WHERE cartItemID = ?";
        
        // Prepare statement
        if ($stmt = $con->prepare($query)) {
            // Bind the cartItemID parameter
            $stmt->bind_param("i", $cartItemID);  // 'i' specifies the type is 'integer'
            
            // Execute the statement
            $stmt->execute();
            
            // Check if any rows were affected
            if ($stmt->affected_rows > 0) {
                // Redirect to the cart page after deletion
                header("Location: cartpage.php");
                exit;
            } else {
                // Display error message if no rows affected
                echo "Failed to delete the item from the cart.";
            }
            
            // Close the statement
            $stmt->close();
        } else {
            // Error message for statement preparation failure
            echo "Error preparing statement: " . $con->error;
        }
    } else {
        // Message if delete request is not set
        echo "Deletion request not received.";
    }
}

// Call the function with the database connection
deleteCart($con);

?>

