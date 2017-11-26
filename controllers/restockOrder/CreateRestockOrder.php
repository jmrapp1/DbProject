<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once('../../services/RestockOrderService.php');
require_once('../../services/ServiceError.php');

if (isset($_POST['employeeId']) && isset($_POST['medId']) && isset($_POST['date'])) {
    $employeeId = $_POST['employeeId'];
    $medId = $_POST['medId'];
    $date = $_POST['date'];

    $res = RestockOrderService::Instance()->createOrder($employeeId, $medId, $date);

    if ($res instanceof ServiceError) {
        $_SESSION['error'] = $res->getError();
    } else {
        $_SESSION['error'] = '';
        $_SESSION['success'] = true;
    }
} else {
    $_SESSION['error'] = 'Please enter the employee ID, medicine ID, and the date.';
}