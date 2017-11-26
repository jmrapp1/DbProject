<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once('../../services/EmployeeService.php');
require_once('../../services/ServiceError.php');

if (isset($_POST['name']) && isset($_POST['title'])) {
    $name = $_POST['name'];
    $title = $_POST['title'];

    $res = EmployeeService::Instance()->createEmployee($name, $title);

    if ($res instanceof ServiceError) {
        $_SESSION['error'] = $res->getError();
    } else {
        $_SESSION['error'] = '';
        $_SESSION['success'] = true;
    }
} else {
    $_SESSION['error'] = 'Please enter a name and title for the employee.';
}