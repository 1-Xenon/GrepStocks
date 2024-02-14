<?php
@session_start();
include("connection.php");

include("get-userID.php");
include("all-products.php");
include("get-picture.php");

$productID = $_GET['productID'];

include("specific-products.php");
include("get-specific-picture.php");

$specific_product_sql_review = "SELECT * FROM reviews WHERE productID = $productID";
$all_reviews = $con->query($specific_product_sql_review);

require_once("average-star.php");

require("is-logged-in.php");
require("existing-review.php");
require("can-edit-review.php");



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
        <?php include 'navbar.php'; ?> <!----include navbar.php------>
    </div>

    <!-- For the single product detail page -->
    <section id="prodetails" class="section-p1">
        <div class="single-pro-image">
            <img src="<?php echo $product_data['productPicture']; ?>" width="100%" alt="">
        </div>
        <div class="single-pro-details">
            <h6>
                <?php echo $product_data['productBrand']; ?>
            </h6>
            <h4>
                <?php echo $product_data['productName']; ?>
            </h4>
            <h2>$
                <?php echo $product_data['productPrice']; ?>
            </h2>
            <form action="add-cart.php" method="POST" id="add-to-cart-form">
    <select name="productColour" id="productColour" required onchange="checkColourSelected()">
        <option value="" disabled selected>Select Colour</option> <!-- This option is not selectable and will cause validation to fail if submitted -->
        <option value="Black">Black</option>
        <option value="White">White</option>
        <option value="Gray">Gray</option>
    </select>
    
    <input type="number" name="productQuantity" value="1" min="1">
			<input type="hidden" name="productID" value="<?php echo $product_data['productID']; ?>">
            <input type="hidden" name="productName" value="<?php echo $product_data['productName']?>">
            <input type="hidden" name="productBrand" value="<?php echo $product_data['productBrand']?>">
            <input type="hidden" name="productPrice" value="<?php echo $product_data['productPrice']?>"> 
            <button type="submit" class="add-to-cart-btn" name="addToCart" >Add to Cart</button>
            
</form>



            
            <a href="#reviews">
                <button class="review-btn">Reviews</button>
            </a>
            <h4>Product Details</h4>
            <span>
                <?php echo $product_data['productDescription']; ?>
            </span>
        </div>
    </section>

    <!-- Reviews -->
    <section id="reviews" class="section-p1">
        <!-- Heading -->
        <div class="reviews-heading">
            <span>Reviews</span>
            <div class="avr-rating">
                <h2>
                    <?php echo $average_rating; ?>
                </h2>
                <div class="avr-rating-stars">
                    <?php
                    // Generate star icons based on the rating
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $average_rating) {
                            echo '<i class="fas fa-star"></i>';
                        } else {
                            echo '<i class="far fa-star"></i>';
                        }
                    }
                    ?>
                </div>
            </div>
            <h1>Customers Say...</h1>
            <!-- HTML script for pop up -->
            <button id="addReviewButton" class="add-review-btn">Add Review</button>

            <!-- Review box container -->
            <div class="reviews-box-container">
                <?php
                // Iterate through each review using a while loop
                while ($review = $all_reviews->fetch_assoc()):
                    $rating = $review['reviewRating']; // Access the rating value
                    include("existing-review.php");
                    include("can-edit-review.php");
                    // Extract username from users table
                    require('user-data.php');
                    ?>
                    <!-- Box 1 -->
                    <div class="review-box">
                        <!-- Top part -->
                        <div class="box-top">
                            <!-- Profile -->
                            <div class="profile">
                                <!-- Profile img -->
                                <div class="pfp-img">
                                    <img src="<?php echo $profilepicture; ?>" alt="">
                                </div>
                                <!-- Name and username -->
                                <div class="username">
                                    <strong>
                                        <?php echo $username; ?>
                                    </strong>
                                    <span>
                                        <?php
                                        $reviewDateTime = new DateTime($review['reviewDateTime']);
                                        echo $reviewDateTime->format('Y-m-d H:i');
                                        ?> <br>
                                        <?php
                                        if (!is_null($review['reviewEditTime'])) {
                                            $reviewEditTime = new DateTime($review['reviewEditTime']);
                                            echo "<b>Edited:</b> " . $reviewEditTime->format('Y-m-d H:i');
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <!-- Reviews -->
                            <?php
                            // Now compare the session userID with the userID of the review
                            if (isset($_SESSION['userID']) && $_SESSION['userID'] == $review['userID']) {
                                ?>

                                <div class="review-btns">
                                    <a class="edit-review-btn" id="open-edit-review-popup"
                                        href="edit-review-form.php?reviewID=<?php echo $review['reviewID']; ?>&productID=<?php echo $product_data['productID']; ?>"><i
                                            class="fas fa-edit edit"></i></a>
                                    <a
                                        href="delete-review.php?reviewID=<?php echo $review['reviewID']; ?>&productID=<?php echo $product_data['productID']; ?>"><i
                                            class="fa fa-trash trash"></i></a>
                                </div>

                                <?php
                            }
                            ?>

                            <div class="rating-num-and-star">
                                <div class="rating-number">
                                    (<?php echo $rating; ?>)
                                </div>
                                <div class="rating">
                                </div>


                                <?php
                                // Generate star icons based on the rating
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo '<i class="fas fa-star star"></i>';
                                    } else {
                                        echo '<i class="far fa-star star"></i>';
                                    }
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Comments -->
                        <div class="customer-comment">
                            <p>
                                <?php echo $review['review']; ?>
                            </p>
                        </div>
                    </div>

                <?php endwhile; ?>
            </div>
            <!-- End of reviews -->

    </section>

    <!-- For the product page -->
    <section id="product1" class="section-p1">
        <h1>Related Products</h1>
        <div class="pro-container">

            <?php
            $count = 0;
            while ($row = $all_product->fetch_assoc()) {
                if ($count < 4) {
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
                    $count++;
                } else {
                    break;
                }
            }

            ?>

        </div>

    </section>

    <script>
            var userLoggedIn = <?php echo json_encode($userLoggedIn); ?>;
            console.log("User Logged In:", userLoggedIn); // Check the value in the browser console

            var hasExistingReview = <?php echo isset($has_existing_review) ? json_encode($has_existing_review) : 'false'; ?>;
            var canEditReview = <?php echo json_encode($canEditReview); ?>;

            document.getElementById('addReviewButton').addEventListener('click', function () {
                if (!userLoggedIn) {
                    alert("You must be logged in to add a review.");
                    event.preventDefault(); // Prevents the default button action
                } else if (hasExistingReview) {
                    alert('You have already reviewed this product. Please edit your existing review.');
                    event.preventDefault(); // Prevents the default button action
                } else {
                    // If logged in and no existing review, proceed with the action associated with the button
                    window.location.href = 'add-review-form.php?productID=<?php echo $productID; ?>';
                }
            });

            // Add an event listener for each edit button
            document.querySelectorAll('.edit-review-btn').forEach(function (button) {
                button.addEventListener('click', function (event) {
                    console.log('Edit button clicked. Can edit?', canEditReview); // Debugging line
                    if (!canEditReview) {
                        alert('You can only edit your review every 10 minutes.');
                        event.preventDefault(); // Prevents the default action (navigation to the edit page)
                    }
                });
            });



        </script>


    <div>
        <?php include 'footer.php'; ?> <!----include navbar.php------>
    </div>

</body>

</html>