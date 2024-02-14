<?php

$specific_product_sql = "SELECT * FROM products WHERE productID = $productID";
$specific_product = $con->query($specific_product_sql);
$product_data = mysqli_fetch_assoc($specific_product);

?>