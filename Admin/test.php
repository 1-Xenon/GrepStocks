<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
  }
  .container {
    width: 48%; /* Adjust width as needed */
    margin: 20px;
    padding: 20px;
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: inline-block; /* Keeps the containers side-by-side */
    vertical-align: top; /* Aligns containers at the top */
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  table, th, td {
    border: 1px solid #ddd;
  }
  th, td {
    padding: 8px;
    text-align: left;
  }
  th {
    background-color: #f2f2f2;
  }
  h2 {
    margin-top: 0;
  }
  .header {
    text-align: center;
    margin: 20px;
  }
  .flex-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap; /* Allows containers to wrap on smaller screens */
  }
</style>
</head>
<body>

<div class="header">
  <h1>Dashboard</h1>
</div>

<div class="flex-container">
  <div class="container">
    <h2>Stocks</h2>
    <a href="#">See more</a>
    <h3>Product List</h3>
    <!-- Product Table -->
    <table>
      <tr>
        <th>Product Name</th>
        <th>Product Price</th>
        <th>Current Stock</th>
      </tr>
      <!-- Repeat for each product -->
      <tr>
        <td>Office Mouse</td>
        <td>$20</td>
        <td>1</td>
      </tr>
      <!-- ... other products ... -->
    </table>
  </div>

  <div class="container">
    <h2>Users</h2>
    <h3>User Activity</h3>
    <!-- User Activity Table -->
    <table>
      <tr>
        <th>Username</th>
        <th>Time</th>
        <th>Description</th>
      </tr>
      <!-- Repeat for each user activity -->
      <tr>
        <td>admin1</td>
        <td>2024-01-18 09:47:07</td>
        <td>Registration</td>
      </tr>
      <!-- ... other user activities ... -->
    </table>
  </div>
</div>

</body>
</html>
