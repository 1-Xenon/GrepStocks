<?php
if (
    $stmt = $con->prepare("SELECT products.*, pictures.picturePath AS productPicture
FROM products
INNER JOIN pictures ON products.productPictureID = pictures.pictureID
WHERE products.productID = ?")
) {
    $stmt->bind_param("i", $productID); // 'i' specifies the variable type => 'integer'
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product_data = $result->fetch_assoc();
    } else {
        echo "No product found.";
    }
    $stmt->close();
} else {
    // Handle errors with preparing the statement
    echo "ERROR: Could not prepare query: $sql. " . $con->error;
}
?>