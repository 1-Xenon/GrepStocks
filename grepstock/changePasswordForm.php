<?php
@session_start();

$username = $_SESSION['username'];
if (!isset($username)){
    header("Location: loginCustomer.php"); //checks if there is a username set within the session variable, if there is no username set it will redirect the customer back to the login page
    exit();
}
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

    <div style="text-align: center;">
    <br><br>
    <h2>Change Password</h2>
    <br>
        <form action="changePassword.php" method="post" id="passwordChangeForm">
            
            <label for="oldPassword">Old Password:</label>
            <input type="password" id="oldPassword" name="oldPassword" minlength="8" required>
            <br>
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" minlength="8" required>
            <br>
            <label for="confirmNewPassword">Confirm New Password:</label>
            <input type="password" id="confirmNewPassword" name="confirmNewPassword" minlength="8" required>
            <br>
            <input type="submit" name="changePassword" value="Change Password">
        </form>

    </div>

</body>

</html>