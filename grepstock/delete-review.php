<?php
include("connection.php");

$productID = $_GET['productID'];
$reviewID = $_GET['reviewID'];

// **3. Prepared statement for secure query:**

// Check if the deletion is confirmed through a GET parameter
if (isset($_GET['confirmDelete']) && $_GET['confirmDelete'] == '1') {
    $del_sql = "DELETE FROM reviews WHERE reviewID = ?";
    $stmt = mysqli_prepare($con, $del_sql);
    mysqli_stmt_bind_param($stmt, "i", $reviewID);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect back to the product page after successful deletion
        header("Location: singleproductpage.php?productID=" . $productID);
        exit;
    } else {
        echo "Unable to delete"; // Handle the error appropriately
    }

    $stmt->close();
    $con->close();
} else {
    echo "<script>
            var confirmDelete = confirm('Are you sure you want to delete this record?');
            if (confirmDelete) {
                window.location.href = '?productID=$productID&reviewID=$reviewID&confirmDelete=1';
            } else {
                window.location.href = 'singleproductpage.php?productID=$productID'; // Redirect to the form page if not confirmed
            }
          </script>";
}

?>