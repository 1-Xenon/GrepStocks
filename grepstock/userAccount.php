<?php
$con = mysqli_connect("localhost","registeredCustomer","xKAt*V8y2WRMnkfK","grepstocks"); //connect to database
if (!$con){
	die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fail
}




@session_start();

include_once 'timeOut.php';

$username = $_SESSION['username']; // assigns the local variable with the value stored within the session variable
$id = $_SESSION['userID'];

$stmt = $con->prepare("SELECT email, password, profilePicture FROM grepstocks.users WHERE username='$username'"); //select all user details that are related to the username stored within the $_SESSION variable from the database
$stmt->execute(); // execute the statement 
$stmt->store_result(); // stores the result locally
$stmt->bind_result($rEmail, $rPassword, $rProfilePicture); // sets the values retrieved from the databse to local database
$stmt->fetch(); // get the data needed

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
<div>
    <?php include_once 'navbar.php'; ?> <!----include navbar.php------>
    <br><br>
</div>


<div class="user-info">
    <div class="profile-pic">
        <?php
            echo '<img style="object-fit: cover; width: 100px; height: 100px; border-radius: 50%;" src="' . $rProfilePicture . '" alt="Profile Picture">';
        ?>
    </div>
    <div class="user-details">
        <h3>Username: <?php echo $username;?></h3>
        <p>Email: <?php echo $rEmail;?></p>
    </div>
</div>

<div class="actions">
  <div>Recent Purchases</div>
  <div>Track my order</div>
  <div>Saved Items</div>
  <div class="dropdown">
    <button class="dropbtn">Account Settings</button>
    <div class="dropdown-content" style="text-align: center;">
    <form action="changePasswordForm.php">
        <button class="btn btn-primary">Change password</button>

    </form>
    <form action="account.php" method="post">
        <button type="submit" class="btn btn-primary">Log out</button>
    </form>

    <form action="deleteAccount.php" method="post">
        <button type="submit" class="btn btn-primary"> Delete Account</button>
    </form>
    </div>
  </div>
</div>




</body>

</html>