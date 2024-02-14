<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $orderID = $_POST["orderID"];
    $cartID = $_POST["editedCartID"];
    $totalPrice = $_POST["editedTotalPrice"];
    $markAsComplete = $_POST["editedMarkAsComplete"];
    $updatedStock = $_POST["editedUpdatedStock"];
    $datetime = $_POST["editedDatetime"];
    
    // Perform the update operation
    $statement = $con->prepare("UPDATE orders SET cartID=?, totalPrice=?, markAsComplete=?, updatedStock=?, datetime=? WHERE orderID=?");
    $statement->bind_param("dsdssi", $cartID, $totalPrice, $markAsComplete, $updatedStock, $datetime, $orderID);
    
    if ($statement->execute()) {
        echo "Order updated successfully.";
    } else {
        echo "Error updating order: " . $statement->error;
    }
    
    $statement->close();
    $con->close();
}
?>
