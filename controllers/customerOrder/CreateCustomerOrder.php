<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once('../../services/CustomerOrderService.php');
require_once('../../services/ServiceError.php');

if (isset($_POST['prescriptionId']) && isset($_POST['date'])) {
    $prescriptionId = $_POST['prescriptionId'];
    $date = $_POST['date'];

    $res = CustomerOrderService::Instance()->createOrder($prescriptionId, $date);

    if ($res instanceof ServiceError) {
        $_SESSION['error'] = $res->getError();
    } else {
        $_SESSION['error'] = '';
        $_SESSION['success'] = true;
    }
} else {
    $_SESSION['error'] = 'Please enter the prescription ID and the date.';
}

// Redirect where needed
if (isset($_POST['redirect'])) {
    header('Location: ' . $_POST['redirect']);
}