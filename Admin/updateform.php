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
        <?php include 'adminNavbar.php'; ?> <!----include navbar.php------>
        <?php
        include "sessioncheck.php";
        ?>
        <?php include 'timeOut.php'; ?> <!----include timeOut.php----->
        <br>
    </div>
    <div class="center">
    <h3 style="text-align: center"><b>Edit Account</b></h3><br>
        <?php
        // Capture the account type from the URL query parameter
        $accountType = isset($_GET['type']) ? $_GET['type'] : 'users';
        $username = isset($_GET['username']) ? $_GET['username'] : '';

        $isDisabled = ($accountType === 'admin' or $accountType === 'staff' or $accountType === 'users') ? 'disabled' : '';
        echo "<form action='updateuser.php?type=" . $accountType . "&username=" . $username . "' method='POST'>";
        echo "<fieldset class='form-group'>";


        ?>
        <div class="form-group">
            <label for="type"> Type of Account: </label>
            <select name="type" <?php echo $isDisabled; ?>>
                <option value="users" <?php echo ($accountType === 'users') ? 'selected' : ''; ?>>Users</option>
                <option value="staff" <?php echo ($accountType === 'staff') ? 'selected' : ''; ?>>Staff</option>
                <option value="admin" <?php echo ($accountType === 'admin') ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>

        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo $_GET['username']; ?>" placeholder="Username" disabled>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Email">(not required for Admins)
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" minlength="8" required>
        </div>


        </fieldset>
        <div>
            <button type="submit" class="btn btn-primary">Update Account</button>
        </div>
        </form>
</body>