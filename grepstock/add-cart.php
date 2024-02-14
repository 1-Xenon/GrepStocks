<?php
include ('connection.php');
include ('all-products.php');

// Start the session to use session variables
session_start();
if (!isset($_SESSION['username'])){
    echo '<script>
    alert("Failed to add to cart. Please login before adding to cart");
    window.location.href = "loginCustomer.php";
    </script>'; // alerts the customer that item has not been added to cart and redirects the user to login before adding item to the cart
    mysqli_close($con); // closes the connection to the database
    
    exit();
}else{


function addToCart($con) {
    
    // Check if the form is already submitted
    if (isset($_POST['addToCart'])) {
        // Prepare the SQL query to insert the new cart item
        $query = "INSERT INTO cart (cartID, userID, productID, productName, productBrand, productQuantity, productColour, productPrice) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        // Prepare the statement
        if ($stmt = $con->prepare($query)) {
            // Bind the parameters from the session and form data
            $stmt->bind_param("iiississ",
                $_SESSION['cartID'],
                $_SESSION['userID'],
                $_POST['productID'],
                $_POST['productName'],
                $_POST['productBrand'],
                $_POST['productQuantity'],
                $_POST['productColour'],
                $_POST['productPrice']
                );
            
            // Execute the statement
            $stmt->execute();
            
            // Check for successful insertion
            if ($stmt->affected_rows > 0) {
                header ("Location:cartpage.php");
                echo "Item added to cart successfully.";
            } else {
                echo "Failed to add item to cart.";
            }
            
            // Close the statement
            $stmt->close();
        } else {
            // SQL error
            echo "Error preparing statement: " . $con->error;
        }
    } else {
        // Session variables or form data not set
        echo "All cart details must be provided.";
    }
}

// Call the function with the database connection
addToCart($con);
}
?>