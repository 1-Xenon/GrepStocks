<?php

include 'connection.php';
@session_start(); // Ensure the session is started

function confirmPurchase($con) {
    // Start transaction
    $con->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
    try {
        $cartID = $_SESSION['cartID'];
        $totalPrice = 0;
        $allItemsInStock = true;
        
        // Fetch items from the cart
        $cartItemsQuery = $con->prepare("SELECT productID, SUM(productQuantity) as totalQuantity, productColour, productPrice FROM cart WHERE cartID = ? GROUP BY productID");
        $cartItemsQuery->bind_param("i", $cartID);
        $cartItemsQuery->execute();
        $cartResult = $cartItemsQuery->get_result();
        
        // Check each item for stock availability and calculate total price
        while ($cartItem = $cartResult->fetch_assoc()) {
            $inventoryQuery = $con->prepare("SELECT currentStock FROM inventory WHERE productID = ?");
            $inventoryQuery->bind_param("i", $cartItem['productID']);
            $inventoryQuery->execute();
            $inventoryResult = $inventoryQuery->get_result();
            $inventory = $inventoryResult->fetch_assoc();
            
            if ($cartItem['totalQuantity'] > $inventory['currentStock']) {
                $con->rollback();
                echo "The selected item " . $cartItem['productID'] . " is out of stock.";
                return; // No need to continue if any item is out of stock
            } else {
                $totalPrice += $cartItem['totalQuantity'] * $cartItem['productPrice']; // Correct calculation for total price
            }
        }
        
        // Update inventory for each product
        foreach ($cartResult as $cartItem) {
            $updateStockQuery = $con->prepare("UPDATE inventory SET currentStock = currentStock - ? WHERE productID = ?");
            $updateStockQuery->bind_param("ii", $cartItem['totalQuantity'], $cartItem['productID']);
            $updateStockQuery->execute();
            
            // Check for successful update
            if ($updateStockQuery->affected_rows == 0) {
                $con->rollback();
                echo "Error updating inventory for product ID: " . $cartItem['productID'];
                return; // No need to continue if inventory update fails
            }
        }
        
        // Insert order into orders table without the orderID
        $insertOrderQuery = $con->prepare("INSERT INTO orders (cartID, totalPrice, markAsComplete, datetime) VALUES (?, ?, 1, NOW())");
        $insertOrderQuery->bind_param("id", $cartID, $totalPrice);
        $insertOrderQuery->execute();
        
        // Clear the cart
        $clearCartQuery = $con->prepare("DELETE FROM cart WHERE cartID = ?");
        $clearCartQuery->bind_param("i", $cartID);
        $clearCartQuery->execute();
        
        // Commit the transaction
        $con->commit();
        
        // Clear the cart from the session
        $_SESSION['cart'] = []; // This resets the session cart variable
        
        // Redirect to a page showing the order has been placed and the cart is now empty.
        header("Location: order-confirmation.php");
        exit();
        
    } catch (Exception $e) {
        $con->rollback();
        error_log("An error occurred: " . $e->getMessage());
        echo "An error occurred during the purchase.";
    }
}

// Check if the confirmPurchase button was clicked.
confirmPurchase($con);


?>
