<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/grepstock.css">
    <title>Grepstocks - Add User</title>
</head>

<body>
    <div>
        <?php include 'adminNavbar.php'; ?> <!----include navbar.php------>
        <?php include "sessioncheck.php"; ?>
        <?php include 'timeOut.php'; ?> <!----include timeOut.php----->
        <br>
    </div>
    <div class="center">
    <h3 style="text-align: center"><b>Add A New Account</b></h3><br>
        <form action="adduser.php" method="POST">
            <fieldset class="form-group">
                <div class="form-group">
                    <label for="type"> Type of Account: </label>
                    <select name="type">
                        <option value="users">Users</option>
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" placeholder="Username" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" placeholder="Email"> (not required for Admins)
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" placeholder="Password" minlength="8" required>
                </div>


            </fieldset>
            <div>
                <button type="submit" class="btn btn-primary">Add Account</button>
            </div>
        </form>
</body>