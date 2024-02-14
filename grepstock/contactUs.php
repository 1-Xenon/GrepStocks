<?php
    include_once("timeOut.php");
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
    <div id="homePage">
        <div id="FAQs">
        <div>
            <h4>
                <p style="text-align: center;">What we do</p>
            </h4>
            <p style="text-align: center;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            
        </div>
        <br><br>
        <div>
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
        </div>

        <div id="locateUs">
            <h4>
                <p style="text-align:center;">Locate Us<p>
            </h4>
            
            <div id="map" style="height: 400px; width: 100%;"></div>
            <?php include_once 'map.php'; ?>
            
        </div>
    </div>
</div>

</body>









<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>