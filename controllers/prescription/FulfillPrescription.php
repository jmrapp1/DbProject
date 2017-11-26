<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once('../../services/PrescriptionService.php');
require_once('../../services/ServiceError.php');

if (isset($_POST['prescriptionId'])) {
    $prescriptionId = $_POST['prescriptionId'];

    $res = PrescriptionService::Instance()->fulfillPrescription($prescriptionId);

    if ($res instanceof ServiceError) {
        $_SESSION['error'] = $res->getError();
    } else {
        $_SESSION['error'] = '';
        $_SESSION['success'] = true;
    }
} else {
    $_SESSION['error'] = 'Please enter the prescription ID.';
}