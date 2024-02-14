<?php
include("connection.php");

if (isset($_POST['editButton'])) {
    $productID = $_POST['productID'];
    $productName = $_POST['productName'];
    $productDescription = $_POST['productDescription'];
    $productPrice = $_POST['productPrice'];
    $currentStock = $_POST['currentStock'];
    $productPictureID = $_POST['productPictureID'];
    $productBrand = $_POST['productBrand'];
    
    // Prepare and bind the statement
    $statement = $con->prepare("UPDATE products SET productName=?, productDescription=?, productPrice=?, currentStock=?, productPictureID=?, productBrand=? WHERE productID=?");
    $statement->bind_param("ssdissi", $productName, $productDescription, $productPrice, $currentStock, $productPictureID, $productBrand, $productID);
    
    // Execute the statement
    if ($statement->execute()) {
        echo "Product updated successfully!";
    } else {
        echo "Error updating product: " . $statement->error;
    }
    
    // Close the statement and connection
    $statement->close();
    $con->close();
}
?>
