<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/grepstock.css">
    <title>Order Management</title>
</head>

<body>

    <div>
        <?php include 'staffNavbar.php'; ?>
        <?php include 'sessioncheck.php'; ?>
        <?php include 'timeOut.php'; ?> <!-- Include timeOut.php -->
        <br><br>
    </div>

    <div>
        <h3 style="text-align: center"><b>Order Management</b></h3>

        <!-- Button trigger modal for adding order -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addOrderModal">
            Add Order
        </button>

        <!-- Order table -->
        <?php
        include("connection.php");

        $statement = $con->prepare("SELECT * FROM orders ORDER BY datetime DESC");
        $result = $statement->execute();
        $result = $statement->get_result();
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Cart ID</th>
                    <th>Total Price</th>
                    <th>Mark As Complete</th>
                    <th>Datetime</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row['orderID']; ?></td>
                        <td><?= $row['cartID']; ?></td>
                        <td><?= $row['totalPrice']; ?></td>
                        <td><?= $row['markAsComplete']; ?></td>
                        <td><?= $row['datetime']; ?></td>
                        <td>
                            <!-- Button trigger modal for editing order -->
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editOrderModal<?= $row['orderID']; ?>">
                                Edit
                            </button>

                            <!-- Button trigger modal for deleting order -->
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteOrderModal<?= $row['orderID']; ?>">
                                Delete
                            </button>
                        </td>
                    </tr>

                    <!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal<?= $row['orderID']; ?>" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5>Edit Order ID: <?= $row['orderID']; ?></h5>
                <!-- Your form fields for editing order -->
                <form action="editOrder.php" method="post">
                    <!-- Keep Order ID as hidden -->
                    <input type="hidden" name="orderID" value="<?= $row['orderID']; ?>">
                    <div class="form-group">
                        <label for="editedCartID">Cart ID</label>
                        <input type="text" class="form-control" name="editedCartID" value="<?= $row['cartID']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="editedTotalPrice">Total Price</label>
                        <input type="text" class="form-control" name="editedTotalPrice" value="<?= $row['totalPrice']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="editedMarkAsComplete">Mark As Complete</label>
                        <input type="text" class="form-control" name="editedMarkAsComplete" value="<?= $row['markAsComplete']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="editedDatetime">Datetime</label>
                        <input type="text" class="form-control" name="editedDatetime" value="<?= $row['datetime']; ?>" required>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


                    <!-- Delete Order Modal -->
                    <div class="modal fade" id="deleteOrderModal<?= $row['orderID']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h5>Delete Order ID: <?= $row['orderID']; ?></h5>
                                    <p>Are you sure you want to delete this order?</p>
                                    <form action="deleteOrder.php" method="post">
                                        <input type="hidden" name="orderID" value="<?= $row['orderID']; ?>">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Add Order Modal -->
    <div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="addOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5>Add New Order</h5>
                    <!-- Your form fields for adding order -->
                    <form action="addOrder.php" method="post">
                        <div class="form-group">
                            <label for="orderID">Order ID</label>
                            <input type="text" class="form-control" name="orderID" required>
                        </div>
                        <div class="form-group">
                            <label for="cartID">Cart ID</label>
                            <input type="text" class="form-control" name="cartID" required>
                        </div>
                        <div class="form-group">
                            <label for="totalPrice">Total Price</label>
                            <input type="text" class="form-control" name="totalPrice" required>
                        </div>
                        <div class="form-group">
                            <label for="markAsComplete">Mark As Complete</label>
                            <input type="text" class="form-control" name="markAsComplete" required>
                        </div>
                        <div class="form-group">
                            <label for="datetime">Datetime</label>
                            <input type="text" class="form-control" name="datetime" required>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
