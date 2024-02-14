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
        session_start();
        if (!isset($_SESSION['username'])) {
            // Redirect to login page
            header("Location: admin.php");
            exit();
        }
        ?>
        <?php include 'timeOut.php'; ?> <!----include timeOut.php----->
        <br><br>
    </div>

    <div>
        <h3 style="text-align: center"><b>Manage Accounts</b></h3>
        <?php
        // Check if a filter has been set in the URL query parameters
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        ?>
        <!-- Creating a form to filter the tables -->
        <form action="manageAccounts.php" method="GET" style="text-align:center">Type of Accounts:
            <select name="filter">
                <option value="all" <?php if ($filter == 'all')
                    echo 'selected'; ?>>All</option>
                <option value="users" <?php if ($filter == 'users')
                    echo 'selected'; ?>>Users</option>
                <option value="staff" <?php if ($filter == 'staff')
                    echo 'selected'; ?>>Staff</option>
                <option value="admin" <?php if ($filter == 'admin')
                    echo 'selected'; ?>>Admin</option>
            </select>
            <input type="submit" value="Filter">
        </form>
        <?php
        include("connection.php");

        //Function to display Users
        function displayUser($con)
        {
            $type="users";
            $statement = $con->prepare("SELECT userID, username, email, password, profilepicture FROM users");
            $statement->execute();
            echo "<h1><center>Users</center></h1>";
            $statement->bind_result($userID, $username, $email, $password, $profilePicture);
            $statement->store_result();
            echo "<table border='2' class='table2'>";
            echo "<tr><td>" . "User ID" . "</td><td>" . "Username" . "</td><td>" . "Email" . "</td><td>" . "Password" . "</td><td>" . "Profile Picture" . "</td><td>" . "Edit" . "</td><td>" . "Delete" . "</td></tr>";
            while ($statement->fetch()) {
                echo "<tr><td>" . $userID . "</td><td>" . $username . "</td><td>" . $email . "</td><td>" . $password . "</td><td>" . $profilePicture . "</td><td>" . "<a href='updateform.php?type=".$type."&username=".$username."'>Edit</a>" . "</td><td>"."<a href='deleteuser.php?type=".$type."&username=".$username."'>Delete</a>"."</td></tr>";
            }
            echo "</table><br><br>";
        }
        //Function to display Staff
        function displayStaff($con)
        {
            $type="staff";
            $statement = $con->prepare("SELECT staffID, username, password, email FROM staff");
            $statement->execute();
            echo "<h1><center>Staff</center></h1>";
            $statement->bind_result($staffID, $username, $password, $email);
            $statement->store_result();
            echo "<table border='2' class='table2'>";
            echo "<tr><td>" . "Staff ID" . "</td><td>" . "Username" . "</td><td>" . "Password" . "</td><td>" . "Email" . "</td><td>" . "Edit" . "</td><td>" . "Delete" . "</td></tr>";
            while ($statement->fetch()) {
                echo "<tr><td>" . $staffID . "</td><td>" . $username . "</td><td>" . $password . "</td><td>" . $email . "</td><td>" . "<a href='updateform.php?type=".$type."&username=".$username."'>Edit</a>" . "</td><td>"."<a href='deleteuser.php?type=".$type."&username=".$username."'>Delete</a>"."</td></tr>";
            }
            echo "</table><br><br>";
        }
        //Function to display Admins
        function displayAdmin($con)
        {
            $type="admin";
            $statement = $con->prepare("SELECT adminID, username, password FROM admin");
            $statement->execute();
            echo '<h1><center>Admins</center></h1>';
            $statement->bind_result($adminID, $username, $password);
            $statement->store_result();
            echo "<table border='2' class='table2'>";
            echo "<tr><td>" . "Admin ID" . "</td><td>" . "Username" . "</td><td>" . "Password" . "</td><td>" . "Edit" . "</td></tr>";
            while ($statement->fetch()) {
                echo "<tr><td>" . $adminID . "</td><td>" . $username . "</td><td>" . $password . "</td><td>" . "<a href='updateform.php?type=".$type."&username=".$username."'>Edit</a>" . "</td></tr>";
            }
            echo "</table>";
        }
        
        //Setting up cases based on the filter selected
        switch ($filter) {
            case "all":
                displayUser($con);
                displayStaff($con);
                displayAdmin($con);
                break;
            case "users":
                displayUser($con);
                break;
            case "staff":
                displayStaff($con);
                break;
            case "admin":
                displayAdmin($con);
                break;
        }

        ?>
    </div>

    </div>


</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>