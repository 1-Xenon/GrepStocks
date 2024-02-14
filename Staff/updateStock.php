
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/grepstock.css">
    <title>Grepstocks</title>
</head>

<body>

    <div>
        <?php include 'staffNavbar.php'; ?> <!-- include navbar.php -->
        <?php include "sessioncheck.php"; ?>
        <?php include 'timeOut.php'; ?> <!-- Include timeOut.php -->
        <br><br>
    </div>
<?php
include("connection.php");

echo "<br>";

$hasAction = isset($_POST["action"]);
$listAll = false;
$actionAdd = false;
$actionUpdate = false;
$actionDelete = false;

if (!$hasAction) {
    $listAll = true;
    //     echo "List All <br>";
} else {
    $action = $_POST["action"];
    //     echo "action".$action."<br>";
    $actionAdd = $action === "add";
    $actionUpdate = $action === "update";
    $actionDelete = $action === "delete";
    
    //     echo "With action <br>";
    //     echo "Add: ".$actionAdd."<br>";
    //     echo "Update: ".$actionUpdate."<br>";
    //     echo "Delete: ".$actionDelete."<br>";
}

if ($listAll) {
    $statement = $con->prepare("SELECT * FROM products");
    if (!$statement) {
        die('Error preparing statement: ' . $con->error);
    }
    $result = $statement->execute();
    if (!$result) {
        die('Error executing statement: ' . $statement->error);
    }
    
    echo "<h1>List of Products</h1><br>";
    $result = $statement->get_result();
    echo "<table border='1'>";
    echo "<tr><td>" . "Product ID" . "</td><td>" . "Product Name" . "</td><td>" . "Product Description" . "</td><td>" . "Product Price" . "</td><td>" . "Current Stock" . "</td><td>" . "Product Picture ID" . "</td><td>" . "Product Brand" . "</td></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['productID'] . "</td><td>" . $row['productName'] . "</td><td>" . $row['productDescription'] . "</td><td>" . $row['productPrice'] . "</td><td>" . $row['currentStock'] . "</td><td>" . $row['productPictureID'] . "</td><td>" . $row['productBrand'] . "</td></tr>";
    }
    echo "</table>";
} else {
    $productID = $_POST["productID"];
    $productName = $_POST["productName"];
    $productDescription = $_POST["productDescription"];
    $productPrice = $_POST["productPrice"];
    $currentStock = $_POST["currentStock"];
    $productPictureID = $_POST["productPictureID"];
    $productBrand = $_POST["productBrand"];
    
    if ($actionAdd) {
        $statement = $con->prepare("INSERT INTO products (productID, productName, productDescription, productPrice, currentStock, productPictureID, productBrand) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $statement->bind_param("isssiss", $productID, $productName, $productDescription, $productPrice, $currentStock, $productPictureID, $productBrand);
        $result = $statement->execute();
        if ($result) {
            echo "Insert Successful";
        } else {
            echo "Unable to Insert";
        }
    } else if ($actionUpdate) {
        $statement = $con->prepare("UPDATE products SET productName=?, productDescription=?, productPrice=?, currentStock=?, productPictureID=?, productBrand=? WHERE productID=?");
        $statement->bind_param("sssissi", $productName, $productDescription, $productPrice, $currentStock, $productPictureID, $productBrand, $productID);
        $result = $statement->execute();
        if ($result) {
            echo "Update Successful";
        } else {
            echo "Unable to Update";
        }
    } else if ($actionDelete) {
        $statement = $con->prepare("DELETE FROM products WHERE productID=?");
        $statement->bind_param("i", $productID);
        $result = $statement->execute();
        if ($result) {
            echo "Delete Successful";
        } else {
            echo "Unable to Delete";
        }
    }
}
?>
