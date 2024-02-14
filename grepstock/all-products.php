<?php
$sql = "SELECT products.*, pictures.picturePath AS productPicture FROM products INNER JOIN pictures ON products.productPictureID = pictures.pictureID";
$all_product = $con->query($sql);
?>