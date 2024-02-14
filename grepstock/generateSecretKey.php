<?php
require_once 'vendor/autoload.php'; // include the  libraries needed

use OTPHP\TOTP;  // import the TOTP class from the OTP package ( look under vendor to find out more)

@session_start(); // resume the session that has been created
$username = $_SESSION['username']; // initialize the $username variable by assigning the stored username within the SESSION

$con = mysqli_connect("localhost", "registeredCustomer", "xKAt*V8y2WRMnkfK", "grepstocks"); // connect to the database
if (!$con) {
    die('Could not connect: ' . mysqli_connect_errno());
}

//get the email and secretKey that is stored in the database
$query = "SELECT email, secretKey FROM grepstocks.users WHERE username = '$username'"; // prepare the statement that will be sent to the database
$result = mysqli_query($con, $query); // executes the query

if ($result) {
    $row = mysqli_fetch_assoc($result); //obtain the result from the query and stores it in an array
    if ($row) {
        $rEmail = $row['email']; // assign the stored email to a local variable
        $storedSecret = $row['secretKey']; // assign the stored secret to a local variable
    }
}


// Function to store the secret key for a user in the database
function storeSecretForUser($con, $username, $secretKey) {
    $query = "UPDATE grepstocks.users SET secretKey = '$secretKey' WHERE username = '$username'";

    $result=mysqli_query($con, $query); // sends the query to the database
    if(!$result){
        echo "error";
    }
}




// Only generate and store a new secret if one does not already exist
if (empty($storedSecret)) { //check if there is a stored secret within the database
    //Create the new Time-based OTP object
    $totp = TOTP::create();
    $totp->setLabel($rEmail); // identify the customer account within the authenticator app

    //Generate a URL for the QR code the customer will scan
    $qrCodeUrl = $totp->getProvisioningUri();
    $qrCodeImageUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrCodeUrl);

    $qrCodeHtml = '<img src="' . $qrCodeImageUrl . '" alt="QR Code" />' ; // initialize the QR code generated to a local variable
    $secretKey = $totp->getSecret(); // Retrieve the base32 encoded secret key for TOTP generation and verification.

    // Store the new secret in your database
    storeSecretForUser($con, $username, $secretKey);
    mysqli_close($con); // close the connection to the database

} else {
    mysqli_close($con); // close the connection to the database
    $qrCodeHtml = "2FA is already set up for your account. Check your authenticator app for your time-based OTP.";
}

//Displays the QR code for the user
echo $qrCodeHtml;
?>