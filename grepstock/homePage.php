<?php
    include_once 'timeOut.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/grepstock.css">
    <title>Grepstock</title>
</head>

<body>

    <div>
        <?php include_once 'navbar.php'; ?> <!----include navbar.php------>
        <br><br>
    </div>
    
    <div>
        <h1 style="text-align:center;">
            <b>Featured Products<b>
        </h1>
        <br><br>
    
        <?php include_once 'carousel.php'; ?> <!---- include carousel.php---->
        <br><br>
    </div>
    <div id="homePage">
        <div id="FAQs">
            <h4>
                <p style="text-align:center;">FAQs<p>
            </h4>
            <p style="text-align:center;">
                Qn)How can I pay for the product(s)?
                <br><br>

                Ans)We only accept cash on delivery. 
                <br><br>

                Qn)When will I receive my product(s)? 
                <br><br>

                Ans)We ship within 2 to 3 business days.
                <br><br>
            </p>
        </div>

        <div id="locateUs">
            <h4>
                <p style="text-align:center;">Locate Us<p>
            </h4>
            
            <div id="map" style="height: 400px; width: 100%;"></div>
            <?php include_once 'map.php'; ?> <!---- include map.php--->
            
        </div>
</div>
    

<?php include_once 'footer.php'; ?> <!----include navbar.php------>

    
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>