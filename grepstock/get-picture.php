<?php
// get-picture.php
if (isset($searched_product_ids) && count($searched_product_ids) > 0) {
    $placeholders = implode(',', array_fill(0, count($searched_product_ids), '?'));
    $sql = "SELECT products.*, pictures.picturePath AS productPicture
            FROM products
            INNER JOIN pictures ON products.productPictureID = pictures.pictureID
            WHERE products.productID IN ($placeholders)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param(str_repeat('i', count($searched_product_ids)), ...$searched_product_ids);
    $stmt->execute();
    $all_product = $stmt->get_result();
} else {
    // Your existing code to fetch all products and pictures
}
$sql = "SELECT products.*, pictures.picturePath AS productPicture FROM products INNER JOIN pictures ON products.productPictureID = pictures.pictureID";
$all_product = $con->query($sql);
?>