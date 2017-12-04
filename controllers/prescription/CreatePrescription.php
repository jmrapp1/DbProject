<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once('../../services/PrescriptionService.php');
require_once('../../services/ServiceError.php');

if (isset($_POST['refillsLeft']) && isset($_POST['customerId']) && isset($_POST['doctorId']) && isset($_POST['medId'])) {
    $date = date("Y-m-d H:i:s");
    $refillsLeft = $_POST['refillsLeft'];
    $customerId = $_POST['customerId'];
    $doctorId = $_POST['doctorId'];
    $medId = $_POST['medId'];

    $res = PrescriptionService::Instance()->createPrescription($date, $refillsLeft, $customerId, $doctorId, $medId);

    if ($res instanceof ServiceError) {
        $_SESSION['error'] = $res->getError();
    } else {
        $_SESSION['error'] = '';
        $_SESSION['success'] = 'The prescription has been created.';
    }
} else {
    $_SESSION['error'] = 'Please enter the date, number of refills, customer, prescribing doctor, and the medicine.';
}
echo $_SESSION['error'];

// Redirect where needed
if (isset($_POST['redirect'])) {
    header('Location: ' . $_POST['redirect']);
}