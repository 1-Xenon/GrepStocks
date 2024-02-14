<?php
include("connection.php");

$statement = $con->prepare("SELECT inventoryID, inventoryStock FROM inventory");
$statement->execute();
$result = $statement->get_result();

$chartData = [['Product Name', 'Current Stock']];

while ($row = $result->fetch_assoc()) {
    $chartData[] = [$row['inventoryID'], $row['inventoryStock']];
}
?>
