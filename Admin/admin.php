<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/grepstock.css">
    <title>Grepstocks</title>
</head>

<body>
    <div>
        <?php include 'adminNavbar2.php'; ?> <!----include navbar.php------>
        <?php include 'timeOut.php'; ?> <!----include timeOut.php----->
        <br><br>
    </div>


    <div style="padding:20px;">
        <div class="center">
        <h3 style="text-align: center">Login </h3><br>
            <form action="adminLogin.php" method="post">
                <fieldset class="form-group">

                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" placeholder="Username" required>
                    </div>


                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" placeholder="Password" minlength="8" required>
                    </div>



                </fieldset>
                <div style="margin-left:100px;">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
        </div>
        </form>

    </div>




</body>







<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>