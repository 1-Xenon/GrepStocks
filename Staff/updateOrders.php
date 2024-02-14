<?php
include("connection.php");

$hasAction = isset($_POST["action"]);
$listAll = !$hasAction;
$actionAdd = false;
$actionUpdate = false;
$actionDelete = false;

if (!$listAll) {
    $action = $_POST["action"];
    $actionAdd = $action === "add";
    $actionUpdate = $action === "update";
    $actionDelete = $action === "delete";
}

if ($listAll) {
    $statement = $con->prepare("SELECT * FROM orders");
    $result = $statement->execute();

    if (!$result) {
        die('Error executing statement: ' . $statement->error);
    }

    $result = $statement->get_result();
    echo "<h1>List of Orders</h1><br>";
    echo "<table border='1'>";
    echo "<tr><td>Order ID</td><td>Cart ID</td><td>Total Price</td><td>Mark As Complete</td><td>Datetime</td></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['orderID']}</td><td>{$row['cartID']}</td><td>{$row['totalPrice']}</td><td>{$row['markAsComplete']}</td><td>{$row['datetime']}</td></tr>";
    }

    echo "</table>";
} else {
    $orderID = $_POST["orderID"];
    $cartID = $_POST["cartID"];
    $totalPrice = $_POST["totalPrice"];
    $markAsComplete = $_POST["markAsComplete"];
    $updatedStock = $_POST["updatedStock"];
    $datetime = $_POST["datetime"];

    if ($actionAdd) {
        $statement = $con->prepare("INSERT INTO orders (orderID, cartID, totalPrice, markAsComplete, datetime) VALUES (?, ?, ?, ?, ?)");
        $statement->bind_param("iisds", $orderID, $cartID, $totalPrice, $markAsComplete, $datetime);
    } elseif ($actionUpdate) {
        $statement = $con->prepare("UPDATE orders SET cartID=?, totalPrice=?, markAsComplete=?, datetime=? WHERE orderID=?");
        $statement->bind_param("dsdsi", $cartID, $totalPrice, $markAsComplete, $datetime, $orderID);
    } elseif ($actionDelete) {
        $statement = $con->prepare("DELETE FROM orders WHERE orderID=?");
        $statement->bind_param("i", $orderID);
    }

    if ($actionAdd || $actionUpdate || $actionDelete) {
        $result = $statement->execute();

        if ($result) {
            echo ($actionAdd ? "Insert" : ($actionUpdate ? "Update" : "Delete")) . " Successful";
        } else {
            echo "Unable to " . ($actionAdd ? "Insert" : ($actionUpdate ? "Update" : "Delete"));
        }
    }
}
?>
