<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once('../../services/RestockOrderService.php');
require_once('../../services/ServiceError.php');

if (isset($_POST['employeeId']) && isset($_POST['medId']) && isset($_POST['orderAmount']) && !empty($_POST['orderAmount'])) {
    $employeeId = $_POST['employeeId'];
    $medId = $_POST['medId'];
    $date = date('Y-m-d H:i:s');
    $orderAmount = $_POST['orderAmount'];

    $res = RestockOrderService::Instance()->createOrder($employeeId, $medId, $orderAmount, $date);

    if ($res instanceof ServiceError) {
        $_SESSION['error'] = $res->getError();
    } else {
        $_SESSION['error'] = '';
        $_SESSION['success'] = 'The order was created.';
    }
} else {
    $_SESSION['error'] = 'Please select the employee, medicine, order amount, and the date.';
}

// Redirect where needed
if (isset($_POST['redirect'])) {
    header('Location: ' . $_POST['redirect']);
}