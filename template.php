<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once("services/DatabaseService.php");
require_once('services/MedService.php');
require_once('services/RestockOrderService.php');
require_once('services/EmployeeService.php');
require_once('services/PrescriptionService.php');
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
            <a href="doctors.php">Doctors</a>
            <a href="prescriptions.php">Prescriptions</a>
            <a href="medicines.php">Medicines</a>
            <a href="customers.php">Customers</a>
            <a href="admin.php">Admin</a>
        </div>
        <div id="content" class="col-md-10">
            <div id="inner-content">
                <h2>Content</h2>
                <p></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>