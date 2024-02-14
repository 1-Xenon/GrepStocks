<?php

// Create connection


$con = mysqli_connect("localhost","guest","7mW[[R0ooEcshRbM","grepstocks"); //connect to database
if (!$con){
	die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}
// Fetch product data from the database
$sql = "SELECT products.*, pictures.picturePath AS productPicture 
FROM products 
INNER JOIN pictures ON products.productPictureID = pictures.pictureID";
$result = $con->query($sql);

$products = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$con->close();
?>

<div id="homePage" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php foreach ($products as $index => $product): ?>
            <li data-target="#homePage" data-slide-to="<?php echo $index; ?>" <?php echo ($index === 0) ? 'class="active"' : ''; ?>></li>
        <?php endforeach; ?>
    </ol>
    <div class="carousel-inner">
        <?php foreach ($products as $index => $product): ?>
            <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
                <img style="height: 250px; width: auto; object-fit: contain;"  class="w-100"src="<?php echo $product['productPicture']; ?>" alt="<?php echo $product['productName']; ?>">
                <div class="carousel-caption d-none d-md-block">
                    <h3 style="color: red; width:200px; text-align:center; "><?php echo $product['productName']; ?></h5>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <a class="carousel-control-prev" href="#homePage" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#homePage" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>



