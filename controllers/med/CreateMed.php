<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once("../../connect.php");
require_once('../../services/MedService.php');
require_once('../../services/ServiceError.php');

if (isset($_POST['name']) && isset($_POST['stock'])) {
    $name = $_POST['name'];
    $stock = $_POST['stock'];

    $res = MedService::Instance()->createMed($name, $stock);

    if ($res == false) {
        $_SESSION['success'] = '';
        $_SESSION['error'] = 'A medication with that name already exists.';
    } else {
        $_SESSION['error'] = '';
        $_SESSION['success'] = 'The medicine has been created.';
    }
} else {
    $_SESSION['error'] = 'Please enter a name and stock amount for the medicine.';
}

// Redirect where needed
if (isset($_POST['redirect'])) {
    header('Location: ' . $_POST['redirect']);
}