<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $orderID = $_POST["orderID"];
    
    // Perform the delete operation
    $statement = $con->prepare("DELETE FROM orders WHERE orderID=?");
    $statement->bind_param("i", $orderID);
    
    if ($statement->execute()) {
        echo "Order deleted successfully.";
    } else {
        echo "Error deleting order: " . $statement->error;
    }
    
    $statement->close();
    $con->close();
}
?>
