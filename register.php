<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once("services/DatabaseService.php");
require_once("services/MedService.php");

if (SessionService::Instance()->isSessionSet()) {
    header("Location: index.php");
}
$userType = "";
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
    <script src="https://use.fontawesome.com/2b90d30d0a.js"></script>
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
            <?php
            if (SessionService::Instance()->isSessionSet()) {
                echo '<a href="controllers/login/Logout.php">Logout</a>';

                if ($userType == "Employee") {
                    echo '<a href="employee_orders.php">Restock Orders</a>';
                    echo '<a href="customers.php">Customers</a>';
                    echo '<a href="customer_orders.php">Customer Orders</a>';
                } else if ($userType == "Doctor") {
                    echo '<a href="medicines.php">Medicines</a>';
                }

                if ($userType != "Customer") { // either customer or doctor
                    echo '<a href="employees.php">Employees</a>';
                    echo '<a href="doctors.php">Doctors</a>';
                    echo '<a href="prescriptions.php">Prescriptions</a>';
                }
            } else {
                echo '<a href="login.php">Login</a>';
                echo '<a href="register.php">Register</a>';
            }
            ?>
        </div>
        <div id="content" class="col-md-10">
            <div id="inner-content">
                <div id="medicines">
                    <h2>Register</h2>
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
                    <form id="newCustomerForm" method="POST" action="controllers/login/RegisterLogin.php">
                        <input type="hidden" name="redirect" value="../../register.php"/>
                        <div class="input-group col-md-4">
                            <input class="form-control" type="text" name="username" placeholder="Username" autofocus>
                        </div>
                        <div class="input-group col-md-4">
                            <input class="form-control" type="password" name="password" placeholder="Password">
                        </div>
                        <div class="input-group col-md-4">
                            <select class="form-control" name="type">
                                <option value="Employee">Employee</option>
                                <option value="Doctor">Doctor</option>
                                <option value="Customer">Customer</option>
                            </select>
                        </div>
                        <h2>Employee</h2>
                        <hr/>
                        <div class="input-group col-md-4">
                            <input class="form-control" type="text" name="employeeName" placeholder="Full Name"
                                   autofocus>
                        </div>
                        <div class="input-group col-md-4">
                            <input class="form-control" type="text" name="employeeTitle" placeholder="Title" autofocus>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary align-items-center">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>