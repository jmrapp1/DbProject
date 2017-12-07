<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once("../../services/DatabaseService.php");
require_once('../../services/UserService.php');
require_once('../../services/EmployeeService.php');
require_once('../../services/ServiceError.php');

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['type']) && !empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['type'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $type = $_POST['type'];

    if ($type == "Customer") {
        // TODO: Need Nick's service code to implement
        $_SESSION['error'] = "Registering as a customer is not yet supported.";
    } else if ($type == "Doctor") {
        // TODO: Need Nick's service code to implement
        $_SESSION['error'] = "Registering as a doctor is not yet supported.";
    } else if ($type == "Employee") {
        if (isset($_POST['employeeName']) && isset($_POST['employeeTitle']) && !empty($_POST['employeeName']) && !empty($_POST['employeeTitle'])) {
            $name = $_POST['employeeName'];
            $title = $_POST['employeeTitle'];
            $res = UserService::Instance()->registerEmployee($username, $password, $name, $title);
            if ($res instanceof ServiceError) {
                $_SESSION['error'] = $res->getError();
            } else {
                $_SESSION['success'] = 'You have registered the employee successfully.';
            }
        } else {
            $_SESSION['error'] = 'Please enter a name and title for the employee.';
        }
    }
} else {
    $_SESSION['error'] = 'Please enter a username, password, and select a type.';
}

// Redirect where needed
if (isset($_POST['redirect'])) {
    header('Location: ' . $_POST['redirect']);
}