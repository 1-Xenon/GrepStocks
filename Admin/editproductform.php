<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Edit Product - Grepstocks</title>
</head>

<body>

    <div>
        <?php include 'adminNavbar.php'; ?> <!-- Include navbar.php -->
        <?php include 'sessioncheck.php';?>
        <?php include 'timeOut.php'; ?> <!-- Include timeOut.php -->
        <br><br>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center"><b>Edit Product</b></h3>

                <?php
                include("connection.php");

                if (isset($_GET['productID'])) {
                    $productID = $_GET['productID'];

                    // Retrieve product details for the given productID
                    $statement = $con->prepare("SELECT * FROM products WHERE productID = ?");
                    $statement->bind_param("i", $productID);
                    $statement->execute();
                    $result = $statement->get_result();

                    if ($row = $result->fetch_assoc()) {
                        // Display the edit form with pre-filled values
                        ?>
                        <form action="editProduct.php" method="post">
                            <input type="hidden" name="productID" value="<?php echo $row['productID']; ?>">

                            <div class="form-group">
                                <label for="productName">Product Name:</label>
                                <input type="text" name="productName" class="form-control" value="<?php echo $row['productName']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="productDescription">Product Description:</label>
                                <input type="text" name="productDescription" class="form-control" value="<?php echo $row['productDescription']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="productPrice">Product Price:</label>
                                <input type="text" name="productPrice" class="form-control" value="<?php echo $row['productPrice']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="currentStock">Current Stock:</label>
                                <input type="text" name="currentStock" class="form-control" value="<?php echo $row['currentStock']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="productPictureID">Product Picture ID:</label>
                                <input type="text" name="productPictureID" class="form-control" value="<?php echo $row['productPictureID']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="productBrand">Product Brand:</label>
                                <input type="text" name="productBrand" class="form-control" value="<?php echo $row['productBrand']; ?>">
                            </div>

                            <div class="text-center">
                                <button type="submit" name="editButton" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                        <?php
                    } else {
                        echo "<p class='text-danger'>Product not found.</p>";
                    }

                    $statement->close();
                } else {
                    echo "<p class='text-danger'>ProductID not provided.</p>";
                }
                ?>
            </div>
        </div>
    </div>

</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>
