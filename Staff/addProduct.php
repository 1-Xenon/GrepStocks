<?php
include("connection.php");

if (isset($_POST['addButton'])) {
    $productName = $_POST['productName'];
    $productDescription = $_POST['productDescription'];
    $productPrice = $_POST['productPrice'];
    $currentStock = $_POST['currentStock'];
    $productPictureID = $_POST['productPictureID'];
    $productBrand = $_POST['productBrand'];

    $statement = $con->prepare("INSERT INTO products (productName, productDescription, productPrice, currentStock, productPictureID, productBrand) VALUES (?, ?, ?, ?, ?, ?)");
    $statement->bind_param("ssdiss", $productName, $productDescription, $productPrice, $currentStock, $productPictureID, $productBrand);
    $result = $statement->execute();

    if ($result) {
        echo "Product added successfully!";
    } else {
        echo "Error adding product: " . $statement->error;
    }

    $statement->close();
    $con->close();
}
?>
