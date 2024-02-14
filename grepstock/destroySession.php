<?php
@session_start();

if (isset($_POST['username'])){
    session_unset();
    session_destroy();
    header("Location: loginCustomer.php");
}
else{
    header("Location: loginCustomer.php");
}
?>
