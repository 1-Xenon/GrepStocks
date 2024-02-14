<?php

@session_start();
if (!isset($_SESSION['username'])){
    header("Location: loginCustomer.php"); // if the customer is not logged in, it will redirect the customer back to the login page
    exit();
}

?>


<html lang="en">
<head>
<meta charset="UTF-8">
<title>GrepStocks</title>
<style>
table {
	width: 100%;
	border-collapse: collapse;
}

th, td {
	border: 1px solid #ddd;
	padding: 8px;
	text-align: left;
}

th {
	background-color: #f2f2f2;
}
</style>
</head>
<body>
	<div>
        <?php include 'navbar.php'; 
        ?> <!----include navbar.php------>
	</div>
	<h2>Your Shopping Cart</h2>


	<table>


		<tr>
			<th>Product Name</th>
			<th>Product Brand</th>
			<th>Quantity</th>
			<th>Colour</th>
			<th>Price</th>
			<th>Total</th>
			<th>Action</th>
		</tr>
		
		
    <?php
    //if(isset($_SESSION['userID'])){
    //need a function to get cartID from session
    include 'connection.php'; // Ensure this file contains your database connection
    function getCart($con) {
        $cartID = $_SESSION['cartID'];
        $totalAmount=0; //Initialize total amount
        $query = $con->prepare("SELECT cartItemID,productName,productBrand,productQuantity,productColour,productPrice FROM cart WHERE cartID = '$cartID'");
        $query -> execute();
        $query -> bind_result($cartItemID,$productName,$productBrand,$productQuantity,$productColour,$productPrice);
        $query -> store_result();
        while($query->fetch()){
            $itemTotal = $productQuantity * $productPrice; //Calculate total for the item
            $totalAmount += $itemTotal; //Add to total amount
            echo "<tr>";
            echo "<td>". htmlspecialchars($productName)."</td>";
            echo "<td>".htmlspecialchars($productBrand)."</td>";
            echo "<td>".htmlspecialchars($productQuantity)."</td>";
            echo "<td>".htmlspecialchars($productColour)."</td>";
            echo "<td>$".number_format(htmlspecialchars($productPrice), 2)."</td>";
            echo "<td>$".number_format(htmlspecialchars($itemTotal), 2)."</td>";
            echo "<td>";
            // Begin form for delete button
            echo "<form action='delete-cart.php' method='POST'>";
            echo "<input type='hidden' name='deleteCart' value='".htmlspecialchars($cartItemID)."'>";
            echo "<button type='submit'>Remove</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        return $totalAmount;
    }
// }
    //else{
        // echo("You are not logged in, please sign in");
    //}
    
    
    $totalAmount=getCart($con);
   
    ?>
 
	</table>

	<p>
		<strong>Total Amount: $<?php echo number_format($totalAmount,2); ?> </strong>
	</p>
    <form action="checkout.php" method="POST">
    <?php if ($totalAmount > 0): ?>
        <button type="submit">Proceed to Checkout</button>
    <?php else: ?>
        <button type="button" disabled>Proceed to Checkout</button>
        <script>alert("Please add items into the cart")</script>
    <?php endif; ?>
</form>
</body>
<div>

        <?php include 'footer.php'; ?>
        </div>
</html>