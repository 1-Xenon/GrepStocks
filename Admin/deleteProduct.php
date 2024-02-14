<?php
include("connection.php");

if (isset($_POST['deleteButton'])) {
    $productID = $_POST['productID'];
    
    $statement = $con->prepare("DELETE FROM products WHERE productID=?");
    $statement->bind_param("i", $productID);
    $result = $statement->execute();
    
    if ($result) {
        echo "Product deleted successfully!";
    } else {
        echo "Error deleting product: " . $statement->error;
    }
    
    $statement->close();
    $con->close();
    header("Location: adminProducts.php");
}
?>
