<?php
// Initialize an array for the parameters and a string for the parameter types
$params = [];
$types = '';

// Start with the base query
$sql = "SELECT products.*, pictures.picturePath AS productPicture FROM products INNER JOIN pictures ON products.productPictureID = pictures.pictureID";

// Initialize an array for the WHERE conditions
$whereConditions = [];

// Check for a search query
if (isset($_GET['search_query']) && trim($_GET['search_query']) !== '') {
    $search_query = trim($_GET['search_query']);
    $whereConditions[] = "productName LIKE ?";
    $params[] = "%$search_query%";
    $types .= 's'; // string type
}

// Filter by Brand
if (isset($_GET['brand']) && $_GET['brand'] !== '') {
    $whereConditions[] = "productBrand = ?";
    $params[] = $_GET['brand'];
    $types .= 's'; // string type
}

// Add WHERE conditions to SQL query if needed
if (!empty($whereConditions)) {
    $sql .= " WHERE " . implode(' AND ', $whereConditions);
}

// Filter by Price and Alphabetical Order
$orderSql = "";

// Filter by Price
if (isset($_GET['price']) && $_GET['price'] !== '') {
    if ($_GET['price'] == 'high_to_low') {
        $orderSql = " ORDER BY productPrice DESC";
    } elseif ($_GET['price'] == 'low_to_high') {
        $orderSql = " ORDER BY productPrice ASC";
    }
}

// Filter by Alphabetical Order
if (isset($_GET['alphabetical_order']) && $_GET['alphabetical_order'] !== '') {
    if ($_GET['alphabetical_order'] == 'a_z') {
        $orderSql = $orderSql ? $orderSql . ", productName ASC" : " ORDER BY productName ASC";
    } elseif ($_GET['alphabetical_order'] == 'z_a') {
        $orderSql = $orderSql ? $orderSql . ", productName DESC" : " ORDER BY productName DESC";
    }
}

// Append order by SQL if needed
$sql .= $orderSql;

// Prepare the statement
$stmt = $con->prepare($sql);

// Bind parameters if there are any
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

// Execute the query
$stmt->execute();
$all_product = $stmt->get_result();
