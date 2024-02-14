<?php
session_start();
include_once "connection.php";
include_once "search-bar.php";
include_once "filter.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/grepstock.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <title>GrepStocks</title>
</head>

<body>

    <div>
        <?php include_once 'navbar.php'; ?> <!----include navbar.php------>
    </div>

    <!-- For the search bar -->
    <section class="search-bar">
        <h1>Products</h1>
        <h4>Get the best deals at GrepStock!</h4>
        <form action="" method="GET"> <!-- You can also specify another page for the action -->
            <div class="search-input-box">
                <i class="uil uil-search"></i>
                <input type="text" name="search_query" placeholder="Search here..."
                    value="<?php echo isset($_GET['search_query']) ? htmlspecialchars($_GET['search_query']) : ''; ?>" />
                <button type="submit" class="search-btn">Search</button>
            </div>
        </form>
    </section>

    <!-- Filter bar section -->
    <section class="filter-bar">
        <form action="" method="GET">
            <!-- Keep the search query if it's set -->
            <input type="hidden" name="search_query" value="<?php echo isset($_GET['search_query']) ?
                htmlspecialchars($_GET['search_query']) : ''; ?>" />

            <!-- Filter by Brand -->
            <select name="brand">
                <option value="">All Brands</option>
                <?php
                $selectedBrand = isset($_GET['brand']) ? $_GET['brand'] : '';
                $sql = "SELECT DISTINCT productBrand FROM products ORDER BY productBrand";
                $result = mysqli_query($con, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $brand = htmlspecialchars($row['productBrand']);
                        $isSelected = $selectedBrand === $brand ? 'selected' : '';
                        echo "<option value='$brand' $isSelected>$brand</option>";
                    }
                }
                ?>
            </select>


            <!-- Filter by Price -->
            <select name="price">
                <option value="">Select Price</option>
                <?php
                $selectedPrice = isset($_GET['price']) ? $_GET['price'] : '';
                ?>
                <option value="high_to_low" <?php echo $selectedPrice === 'high_to_low' ? 'selected' : ''; ?>>$$$ - $
                </option>
                <option value="low_to_high" <?php echo $selectedPrice === 'low_to_high' ? 'selected' : ''; ?>>$ - $$$
                </option>
            </select>

            <!-- Filter by Alphabetical Order -->
            <select name="alphabetical_order">
                <option value="">Select Order</option>
                <?php
                $selectedOrder = isset($_GET['alphabetical_order']) ? $_GET['alphabetical_order'] : '';
                ?>
                <option value="a_z" <?php echo $selectedOrder === 'a_z' ? 'selected' : ''; ?>>A to Z</option>
                <option value="z_a" <?php echo $selectedOrder === 'z_a' ? 'selected' : ''; ?>>Z to A</option>
            </select>

            <button type="submit" class="filter-btn">Filter</button>
        </form>

    </section>


    <!-- For the product page -->
    <section id="product1" class="section-p1">
        <div class="pro-container">

            <?php
            while ($row = $all_product->fetch_assoc()) {
                ?>

                <!-- Card start-->
                <div class="pro">
                    <img src="<?php echo $row["productPicture"]; ?>" alt="Product Image">
                    <div class="des">
                        <span>
                            <?php echo $row["productBrand"]; ?>
                        </span>
                        <h5>
                            <?php echo $row["productName"]; ?>
                        </h5>
                        <h4>$
                            <?php echo $row["productPrice"]; ?>
                        </h4>
                    </div>
                    <a href="singleproductpage.php?productID=<?php echo $row['productID']; ?>">
                        <button class="learn-btn">Learn More!</button>
                    </a>
                </div>
                <!-- Card end -->

                <?php
            }

            ?>

        </div>
    </section>

    <div>
        <?php include_once 'footer.php'; ?> <!----include navbar.php------>
    </div>

</body>

</html>