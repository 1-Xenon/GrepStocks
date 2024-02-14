<?php
// Get the current page filename without extension
$current_page = basename($_SERVER['PHP_SELF'], '.php');


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/grepstock.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <title>GrepStocks</title>
</head>


<body>
<nav class="navbar">
    
        <div class="logo"><h1>GrepStocks</h1></div>
        <ul class="menu">
            <li class="nav-item <?php echo ($current_page == 'homePage') ? 'active' : ''; ?>">
                <a href="homePage.php">Home</a>
            </li>
            <li class="nav-item <?php echo ($current_page == 'productpage') ? 'active' : ''; ?>">
                <a href="productpage.php">Products</a>
            </li>
            <li class="nav-item <?php echo ($current_page == 'contactUs') ? 'active' : ''; ?>">
            <a href="contactUs.php">Contact Us</a></li>
            <li class="nav-item <?php echo ($current_page == 'registerUser' || $current_page == 'userAccount' || $current_page == 'loginCustomer') ? 'active' : ''; ?>">
                <?php
                
                @session_start();

                if (isset($_SESSION["username"])){
                    echo ' <a href="userAccount.php">Account</a> ';
                }
                else{
                    echo ' <a href="registerUser.php">Account</a> ';
                }
                
                
                ?>    
            
            
            
            </li>
            <li><a href="cartpage.php"><i class="fas fa-shopping-cart"></i></a></li>
        </ul>

</nav>
</body>



