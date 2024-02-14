<?php

@session_start();

if (isset($_SESSION['username'])){
    header("Location: userAccount.php"); // if the customer is logged in, the customer will not be able to access this page and be redirected back to the user's account page
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
<div>
    <?php include_once 'navbar.php'; ?> <!----include navbar.php------>
    <br><br>
</div>

<div style="padding:20px;">
    <h3 style="text-align: center">Login</h3>
    <br><br>
    <form action="login.php" method="post" >
        <fieldset class="form-group">
            
            <div class="form-group" style="text-align: center;">
                <label for="username">Username :</label>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            
            <div class="form-group" style="text-align: center;">
                <label for="password">Password :</label>
                <input type="password" name="password" placeholder="Password" minlength="8" required>
                <p>Forget your password? <a href="forgetPasswordForm.php">Click here</a></p>
            </div>

        </fieldset>
        <div style="text-align: center;">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
        
    </div>

    <div>
        <br><br>
        <p style="text-align: center;">Don't have an account? <a href="registerUser.php">Register here</a></p>

    </div>


</body>



 



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>