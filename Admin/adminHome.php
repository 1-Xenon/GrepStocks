<?php
    include "sessioncheck.php"; 
    include 'timeOut.php'; 
    include("connection.php");

    function displayProducts($con)
    {
        $statement = $con->prepare("SELECT productName, productPrice, currentStock FROM products");
        $statement->execute();
        $result = $statement->get_result();

        echo "<h4><center>Product List</center></h4>";
        echo "<table border='1' class='table'>";
        echo "<tr><td>Product Name</td><td>Product Price</td><td>Current Stock</td></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['productName'] . "</td>";
            echo "<td>" . $row['productPrice'] . "</td>";
            echo "<td>" . $row['currentStock'] . "</td>";
            
        
            echo "</tr>";
        }

        echo "</table><br><br>";
    }

    function displayUserLog($con)
    {
        $statement = $con->prepare("SELECT * FROM userLog ORDER BY time DESC LIMIT 10");
        $statement->execute();
        $result = $statement->get_result();
        $maxRow = 0;

        echo "<h4><center>User activity</center></h4>";
        echo "<table border='1' class='table'>";
        echo "<tr><td>Username</td><td>Time</td><td>Description</td></tr>";

        while ($row = $result->fetch_assoc()) {
            if($maxRow < 10){
            echo "<tr>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['time'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "</tr>";
            $maxRow ++;
        }else{
            break;
        }


    }
    echo "</table><br><br>";
    }

?>


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
        <?php include 'adminNavbar.php'; ?> <!----include navbar.php------>
        <br><br>
    </div>
    
    <div>
        <h1>
            <p style="text-align:center;"><b>Welcome back <?php
                echo $_SESSION['username'];
            ?></b><p>
        </h1>
        <br><br>
    </div>

    <div>
        <p style="text-align:center;">Here's a look at the recent activities on Grepstock</p>
    </div>

    
    
<div class="flex-containerHome">
    <div class="containerHome">
        <h4>
            <p style="text-align:center;">Stocks<p>
        </h4>
        <p style="text-align:center;">
            <a href="adminProducts.php" style="text-align: center;">See more</a>
            <?php displayProducts($con)?>
            <br><br>
        </p>    
    </div>
    <div class="containerHome">
        <h4>
            <p style="text-align:center;">Users<p>
        </h4>
        <?php displayUserLog($con)?>
  </div>

</div>

    
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>