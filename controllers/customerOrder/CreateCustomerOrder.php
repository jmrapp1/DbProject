<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once('../../services/CustomerOrderService.php');
require_once('../../services/ServiceError.php');

if (isset($_POST['orderAmount']) && isset($_POST['employeeId']) && isset($_POST['prescriptionId']) && !empty($_POST['orderAmount']) && !empty($_POST['orderAmount'])) {
    $orderAmount = $_POST['orderAmount'];
    $date = date('Y-m-d H:i:s');
    $employeeId = $_POST['employeeId'];
    $prescriptionId = $_POST['prescriptionId'];
    $orderType = $_POST['orderType'];

    $res = CustomerOrderService::Instance()->createOrder($employeeId, $prescriptionId, $date, $orderAmount, $orderType);

    if ($res instanceof ServiceError) {
        $_SESSION['error'] = $res->getError();
    } else {
        $_SESSION['error'] = '';
        $_SESSION['success'] = 'The order has been placed.';
    }
} else {
    $_SESSION['error'] = 'Please select the Employee, Prescription and the Order Amount.';
}

// Redirect where needed
if (isset($_POST['redirect'])) {
    header('Location: ' . $_POST['redirect']);
}