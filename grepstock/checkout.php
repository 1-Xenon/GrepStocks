
<?php

session_start();

include 'connection.php'; // Make sure this file contains your database connection


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - GrepStocks</title>
    <!-- Add your CSS links here -->
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

 #map {
    height: 400px; /* Example height */
    margin-left: 800px; /* Optional: to add some space between the map and the summary */
    width: 50%; /* Full width */
  }
</style>
    
</head>
<body>
<div>
        <?php include 'navbar.php'; 
        
        ?> <!----include navbar.php------>
	</div>
    <h2>Order Summary</h2>
    <table>
        <tr>
        <th>Product Name</th>
        <th>Product Quantity</th>
        <th>Total Price</th>
        
          
            <!-- Add other headers as needed -->
        </tr>
        <?php
        function displayCartItems($con) {
            
            $totalAmount=0; //Initialize total amount
            
            $cartID = $_SESSION['cartID']; // Assuming you store cartID in the session
            $query = $con->prepare("SELECT productID, productName, productQuantity, productPrice FROM cart WHERE cartID = ?");
            $query->bind_param("i", $cartID);
            $query->execute();
            $result = $query->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $productQuantity = $row['productQuantity']; // Define the productQuantity variable
                $productPrice = $row['productPrice']; // Define the productPrice variable
                $itemTotal = $productQuantity * $productPrice; // Calculate total for the item
                $totalAmount += $itemTotal;
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['productName']) . "</td>";
                echo "<td>" . htmlspecialchars($row['productQuantity']) . "</td>";
                echo "<td>$" . number_format($itemTotal, 2) . "</td>";
                echo "</tr>";
            }
            return $totalAmount;
            
        }
        $totalAmount=displayCartItems($con);
        
        ?>
        
    </table>
    
    <table>
    <br>
    <h3>Self-Collection at Temasek Polytechnic Advanced Manufacturing Centre</h3>
    <br>
    <tr>Total : $<?php echo number_format($totalAmount,2); ?> </tr>
    
    </table>
    <br>
    
    <form action="process-order.php" method="POST"> 
    <button id="confirmPurchase">Confirm Purchase</button>
    </form>
<div id="map"></div>
<?php

$apiKey = 'AIzaSyD3OYDu_tu767iTFhHY0iE0WphJEqcKWgU';
$latitude = 1.3465137542673806;
$longitude = 103.93194848875173;
$zoom = 18; 
?>

<script>
  
    

    function initMap() {
        var mapOptions = {
            center: {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>},
            zoom: <?php echo $zoom; ?>
        };
        

        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        var marker = new google.maps.Marker({
            position: {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>},
            map: map,
            
        });
    }
</script>




<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=<?php echo $apiKey; ?>&callback=initMap">
</script>










  
</body>
</html>
