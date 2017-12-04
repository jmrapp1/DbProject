<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once("services/DatabaseService.php");
require_once('services/PrescriptionService.php');
require_once('services/CustomerService.php');
require_once('services/ServiceError.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/styles.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
            integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
            integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
            crossorigin="anonymous"></script>
</head>
<body>
<div id="body" class="container-fluid">
    <div id="header" class="row">
        <h1 class="text-center">Pharmacy</h1>
    </div>
    <div id="main" class="flex-row">
        <div id="sidebar" class="col-md-2">
            <a href="index.php">Home</a>
            <a href="employees.php">Employees</a>
            <a href="employee_orders.php">Restock Orders</a>
            <a href="doctors.php">Doctors</a>
            <a href="prescriptions.php">Prescriptions</a>
            <a href="medicines.php">Medicines</a>
            <a href="customers.php">Customers</a>
            <a href="customer_orders.php">Customer Orders</a>
            <a href="admin.php">Admin</a>
        </div>
        <div id="content" class="col-md-10">
            <div id="inner-content">
                <div id="orders">
                    <h2>Employee Restock Orders</h2>
                    <hr/>

                    <div class="panel panel-default">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Medicine</th>
                                <th scope="col">Employee</th>
                                <th scope="col">Order Amount</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach (RestockOrderService::Instance()->getAllOrders() as $order) {
                                echo '<tr>';
                                echo '<td>' . $order["Restock_Order_ID"] . '</td>';
                                echo '<td>' . $order['MedName'] . '</td>';
                                echo '<td>' . $order["EmployeeName"] . '</td>';
                                echo '<td>' . $order["Order_Amount"] . '</td>';
                                echo '<td>' . $order["Date_Ordered"] . '</td>';
                                echo '</tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="new-prescription">
                    <h2>New Order</h2>
                    <hr/>
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<p class="error">' . $_SESSION['error'] . '</p>';
                        $_SESSION['error'] = '';
                    }
                    if (isset($_SESSION['success'])) {
                        echo '<p class="success">' . $_SESSION['success'] . '</p>';
                        $_SESSION['success'] = '';
                    }
                    ?>
                    <form method="POST" action="controllers/restockOrder/CreateRestockOrder.php">
                        <input type="hidden" name="redirect" value="../../employee_orders.php"/>
                        <div class="input-group col-md-4">
                            <select class="form-control" name="employeeId">
                                <option value="-1">Select Employee To Create Order</option>
                                <?php
                                foreach (EmployeeService::Instance()->getAllEmployees() as $employee) {
                                    echo "<option value=\"" . $employee['Employee_ID'] . "\">" . $employee['Name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group col-md-4">
                            <select class="form-control" name="medId">
                                <option value="-1">Select Medicine</option>
                                <?php
                                foreach (MedService::Instance()->getAllMeds() as $med) {
                                    echo "<option value=\"" . $med['Med_ID'] . "\">" . $med['Name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group col-md-4">
                            <input class="form-control" type="number" name="orderAmount" placeholder="Order Amount">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary align-items-center">Create Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>