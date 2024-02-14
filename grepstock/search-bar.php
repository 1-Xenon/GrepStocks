<?php
include("connection.php");

// Check if there's a search query
if (isset($_GET['search_query']) && trim($_GET['search_query']) !== '') {
    $search_query = trim($_GET['search_query']);
    
    // Prepare the SQL statement to prevent SQL injection and to include pictures
    $sql = "SELECT products.*, pictures.picturePath AS productPicture 
            FROM products 
            INNER JOIN pictures ON products.productPictureID = pictures.pictureID 
            WHERE productName LIKE ?";
    $stmt = $con->prepare($sql);
    $search_term = "%" . $search_query . "%";
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $all_product = $stmt->get_result();
} else {
    // If there's no search query, include all-products.php which presumably fetches all products
    include("all-products.php");
}
?>