<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once("connect.php");
require_once("services/MedService.php");
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
            <a href="employees.php">Employees</a>
            <a href="doctors.php">Doctors</a>
            <a href="prescriptions.php">Prescriptions</a>
            <a href="medicines.php">Medicines</a>
            <a href="customers.php">Customers</a>
            <a href="admin.php">Admin</a>
        </div>
        <div id="content" class="col-md-10">
            <div id="inner-content">
                <div id="medicines">
                    <h2>Medicines</h2>
                    <hr/>

                    <div class="panel panel-default">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Stock</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach (MedService::Instance()->getAllMeds() as $med) {
                                echo '<tr>';
                                echo '<td>' . $med["Med_ID"] . '</td>';
                                echo '<td>' . $med["Name"] . '</td>';
                                echo '<td>' . $med["Stock_Amount"] . '</td>';
                                echo '<td>
                                        <form id="newCustomerForm" method="POST" action="controllers/med/DeleteMed.php">
                                        <input type="hidden" name="redirect" value="../../medicines.php"/>
                                        <input type="hidden" name="med-id" value="' . $med["Med_ID"] . '" />
                                        <button class="btn btn-md btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                     </td>';
                                echo '</tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="new-medicine">
                    <h2>New Medicine</h2>
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
                    <form id="newCustomerForm" method="POST" action="controllers/med/CreateMed.php">
                        <input type="hidden" name="redirect" value="../../medicines.php"/>
                        <div class="input-group col-md-4">
                            <input class="form-control" type="text" name="name" placeholder="Name" autofocus>
                        </div>
                        <div class="input-group col-md-4">
                            <input class="form-control" type="number" name="stock" placeholder="Stock">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary align-items-center">Create Medicine</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>