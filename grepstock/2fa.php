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
    <br><br>
    

    
    <div style="text-align: center;">
    <h2>2FA Setup</h2>
    <p>Please scan the QR code to obtain the time-based OTP</p>
    <?php require_once "generateSecretKey.php"; //produces the QR code needed?>
    <br><br>
    <h2>Enter OTP for Verification</h2>
    
    <form action="authenticator.php" method="post">
        <label for="otp">OTP:</label>
        <input type="password" id="otp" name="otp" placeholder="******" required>
        <input type="submit" value="Verify OTP">
    </form>
    </div>

    
</body>


</html>