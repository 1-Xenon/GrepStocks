<?php
include_once("connection.php");
@session_start();
$username = $_SESSION['username'];

require_once("add-review.php");
$productID = $_GET['productID'];
$specific_product_sql = "SELECT * FROM products WHERE productID = $productID";
$specific_product = $con->query($specific_product_sql);
$product_data = mysqli_fetch_assoc($specific_product);
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

    <!-- Review pop up -->
    <div>
        <?php include 'navbar.php'; ?> <!----include navbar.php------>
    </div>

    <div class="content-wrap">
    <!-- All other page content goes here -->
    <div class="add-review-popup" id="add-review-popup">
        <form action="add-review.php" method="POST">
            <input type="hidden" name="productID" value="<?php echo $product_data['productID']; ?>">
            <div class="add-review-popup-content">
                <h2>Product review for <?php echo $product_data['productName']; ?></h2>
                <p>Username:</p>
                <textarea name="edit-review-username" cols="90" rows="1" readonly><?php echo htmlspecialchars($username); ?></textarea>
                <p>Rating:</p>
                <div class="add-review-rating">
                    <input type="number" name="add-review-rating" hidden>
                    <i class="far fa-star star" style="--i: 0;"></i>
                    <i class="far fa-star star" style="--i: 1;"></i>
                    <i class="far fa-star star" style="--i: 2;"></i>
                    <i class="far fa-star star" style="--i: 3;"></i>
                    <i class="far fa-star star" style="--i: 4;"></i>
                </div>
                <p>Comments:</p>
                <textarea name="add-review-comment" cols="90" rows="5"
                    placeholder="Write down your comment here..." required></textarea>
                <div class="controls">
                    <a href="singleproductpage.php?productID=
                    <?php echo $product_data['productID']; ?>
                    " class="close-btn">Close</a>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <button class="submit-btn" name="add-review-submit">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <!-- JS script for pop up -->
    
    <script>


        const allStar = document.querySelectorAll('.add-review-rating .star')
        const ratingValue = document.querySelector('.add-review-rating input')

        allStar.forEach((item, idx) => {

            item.addEventListener('click', function () {
                let click = 0
                ratingValue.value = idx + 1


                allStar.forEach(i => {
                    i.classList.replace('fas', 'far')
                    i.classList.remove('active')
                })

                for (let i = 0; i < allStar.length; i++) {
                    if (i <= idx) {
                        allStar[i].classList.replace('far', 'fas')
                        allStar[i].classList.add('active')
                    } else {
                        allStar[i].style.setProperty('--i', click)
                        click++
                    }
                }
            })
        })





    </script>
    </div>
    

    <div>
        <?php include_once 'footer.php'; ?> <!----include navbar.php------>
    </div>

</body>

</html>