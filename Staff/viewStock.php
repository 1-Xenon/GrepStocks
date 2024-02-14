<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/grepstock.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Count Chart</title>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        canvas {
            display: block;
            margin: 20px auto;
        }
    </style>
</head>

<body>

    <div>
        <?php include 'staffNavbar.php'; ?>
        <?php include 'sessioncheck.php'; ?>
        <?php include 'timeOut.php'; ?> <!-- Include timeOut.php -->
        <br><br>
    </div>

<body>

    <h1 style="text-align: center;">Stock Count Chart</h1>

    <!-- Canvas to render the chart -->
    <canvas id="stockChart" width="600" height="400"></canvas>

    <?php
    // Include your database connection script
    include("connection.php");

    // Fetch stock count data from the database
    $result = $con->query("SELECT productID, inventoryStock FROM inventory");

    if ($result) {
        // Prepare data for Chart.js
        $labels = [];
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $labels[] = $row['productID'];
            $data[] = $row['inventoryStock'];
        }
    } else {
        echo "Error fetching data: " . $con->error;
    }
    ?>

    <script>
        <?php if (isset($labels) && isset($data)) : ?>
            // Use PHP data in JavaScript
            var labels = <?php echo json_encode($labels); ?>;
            var data = <?php echo json_encode($data); ?>;

            // Data for the chart
            var stockData = {
                labels: labels,
                datasets: [{
                    label: 'Stock Count',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            };

            // Get the canvas element
            var ctx = document.getElementById('stockChart').getContext('2d');

            // Create a bar chart
            var stockChart = new Chart(ctx, {
                type: 'bar',
                data: stockData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        <?php endif; ?>
    </script>

</body>

</html>
