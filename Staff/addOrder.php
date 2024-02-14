<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $orderID = $_POST["orderID"];
    $cartID = $_POST["cartID"];
    $totalPrice = $_POST["totalPrice"];
    $markAsComplete = $_POST["markAsComplete"];
    $datetime = $_POST["datetime"];
    
    // Perform the insert operation
    $statement = $con->prepare("INSERT INTO orders (orderID, cartID, totalPrice, markAsComplete, datetime) VALUES (?, ?, ?, ?, ?)");
    $statement->bind_param("iisds", $orderID, $cartID, $totalPrice, $markAsComplete, $datetime);
    
    if ($statement->execute()) {
        echo "Order added successfully.";
    } else {
        echo "Error adding order: " . $statement->error;
    }
    
    $statement->close();
    $con->close();
}
?>
