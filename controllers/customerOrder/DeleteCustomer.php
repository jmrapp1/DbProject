<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once("../../services/DatabaseService.php");
require_once('../../services/CustomerService.php');

if (isset($_POST['customer-id'])) {
    $customerId = $_POST['customer-id'];

    CustomerService::Instance()->deleteCustomer($customerId);
} else {
    $_SESSION['error'] = 'Please provide a customer ID';
}

// Redirect where needed
if (isset($_POST['redirect'])) {
    header('Location: ' . $_POST['redirect']);
}