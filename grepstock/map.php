<?php

$apiKey = 'AIzaSyD3OYDu_tu767iTFhHY0iE0WphJEqcKWgU';
$latitude = 1.3465137542673806;
$longitude = 103.93194848875173;
$zoom = 18;
?>

<script>
    function initMap() { // this will create a new map that will be displayed on homePage.php and contactUs.php
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









