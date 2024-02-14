<?php
@session_start();

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

    <?php
    include_once 'navbar.php';
    ?>

    <br><br>

    

    <div style="text-align: center;">
    <?php 
    // Check if the 'isVerified' session variable is not set or if it's false
    if (!isset($_SESSION['isVerified']) || !$_SESSION['isVerified']): ?>
    <h2>Verify your identity with TOTP before you are allowed to change your password.</h2>
    <form action="forgetPassword.php" method="post" id="totpVerificationForm">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="otp">TOTP:</label>
        <input type="password" id="otp" name="otp" required>
        <br>
        <input type="submit" name="verifyTOTP" value="Verify TOTP">
        <br>
    </form>
    <?php
    //end of the if statement
    endif; ?>

    <?php 
    // Check if the 'isVerified' session variable is set and true
    if (isset($_SESSION['isVerified']) && $_SESSION['isVerified']): ?>
        <h2>Forgot Password</h2>
        <form action="forgetPassword.php" method="post" id="passwordChangeForm">
            <input type="hidden" id="verifiedUsername" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
            
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" minlength="8" required>

            <input type="submit" name="changePassword" value="Change Password">
        </form>
    <?php 
    //end of the if statement
    endif; ?>
    </div>

    <div style="text-align: center;">
    <form action="destroySession.php" method="post">
        <button type="submit" class="btn btn-primary">Back</button>
    </form>
    </div>

</body>


</html>