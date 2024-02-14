<!-- productmanagement.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add your head content here -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/grepstock.css">
    <title>Grepstocks - Product Management</title>
</head>

<body>

    <div>
        <?php include 'staffNavbar.php'; ?> <!-- Include navbar.php -->
        <?php include 'sessioncheck.php'; ?>
        <?php include 'timeOut.php'; ?> <!-- Include timeOut.php -->
        <br><br>
    </div>

    <div class="container">
        <h3 class="text-center"><b>Product Management</b></h3>
        <a href="addproductform.php" class="btn btn-primary">Add Product</a> <!-- Add Product Button -->
        <?php
        include("connection.php");

        // Function to display Products
        function displayProducts($con)
        {
            $statement = $con->prepare("SELECT * FROM products");
            $statement->execute();
            $result = $statement->get_result();

            echo "<h1><center>Product List</center></h1>";
            echo "<table border='1' class='table'>";
            echo "<tr><td>Product ID</td><td>Product Name</td><td>Product Description</td><td>Product Price</td><td>Current Stock</td><td>Product Picture ID</td><td>Product Brand</td><td>Actions</td></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['productID'] . "</td>";
                echo "<td>" . $row['productName'] . "</td>";
                echo "<td>" . $row['productDescription'] . "</td>";
                echo "<td>" . $row['productPrice'] . "</td>";
                echo "<td>" . $row['currentStock'] . "</td>";
                echo "<td>" . $row['productPictureID'] . "</td>";
                echo "<td>" . $row['productBrand'] . "</td>";
                echo "<td><a href='editproductform.php?productID=" . $row['productID'] . "'>Edit</a> | <a href='staffHome.php?deleteProductID=" . $row['productID'] . "'>Delete</a></td>";
                echo "</tr>";
            }

            echo "</table><br><br>";
        }

        // Display product list
        displayProducts($con);

        // Handle product deletion
        if (isset($_GET['deleteProductID'])) {
            $deleteProductID = $_GET['deleteProductID'];

            $deleteStatement = $con->prepare("DELETE FROM products WHERE productID = ?");
            $deleteStatement->bind_param("i", $deleteProductID);
            $deleteResult = $deleteStatement->execute();

            if ($deleteResult) {
                echo "<p class='text-success'>Product deleted successfully!</p>";

                // Add JavaScript to refresh the page after a delay
                echo "<script>
                    setTimeout(function(){
                        location.reload();
                    }, 2000); // Refresh after 2 seconds
                </script>";
            } else {
                echo "<p class='text-danger'>Error deleting product: " . $deleteStatement->error . "</p>";
            }

            $deleteStatement->close();
        }
        ?>
    </div>

</body>

</html>