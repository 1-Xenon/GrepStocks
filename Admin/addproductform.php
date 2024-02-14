<!-- addproductform.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/grepstock.css">
    <title>Grepstocks - Add Product</title>
</head>

<body>

    <div>
        <?php include 'adminNavbar.php'; ?> <!-- Include navbar.php -->
        <?php include 'sessioncheck.php'; ?>
        <?php include 'timeOut.php'; ?> <!-- Include timeOut.php -->
        <br><br>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center"><b>Add Product</b></h3>

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

                <form action="addproductform.php" method="post">
                    <div class="form-group">
                        <label for="productName">Product Name:</label>
                        <input type="text" name="productName" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="productDescription">Product Description:</label>
                        <input type="text" name="productDescription" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="productPrice">Product Price:</label>
                        <input type="number" name="productPrice" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="currentStock">Current Stock:</label>
                        <input type="number" name="currentStock" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="productPictureID">Product Picture ID:</label>
                        <input type="text" name="productPictureID" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="productBrand">Product Brand:</label>
                        <input type="text" name="productBrand" class="form-control" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" name="addButton" class="btn btn-primary">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>
