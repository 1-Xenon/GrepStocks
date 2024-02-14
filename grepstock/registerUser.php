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
    

<div style="padding:20px; text-align:center;">
    <h3 style="text-align: center">Register an account today!</h3>
    <br><br>
    
    <form action="registration.php" method="post" enctype="multipart/form-data">
        <fieldset class="form-group">
            
            <div class="form-group">
                <label for="username">Username :</label>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <label for="password">Password :</label>
                <input type="password" name="password" placeholder="Password" minlength="8" required>
                <br>
                <a class="instruction">The password needs a minimum of 8 alphanumeric and special characters</a>    
            </div>

            <div class="form-group">
                <label for="" confirmPassword>Confirm Password :</label>
                <input type="password" name="confirmPassword" placeholder="Confirm Password" minlength="8" required>
            </div>

            <div class="form-group">
                <label for="file" class="mt-5">Profile Picture</label>
                <input  type="file" name="profilePicture" accept="image/*" required >
                <br><br>
            </div>
        </fieldset>
        <div>
            <button type="submit" class="btn btn-primary">Register</button>
        </div>

    </form>
</div>    
    

    <div style="padding: 25px;"> 
        <br><br>
        <p style="text-align: center;">Already have an account? <a href="loginCustomer.php">Login here</a></p>

    </div>
    
</body>



 



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>