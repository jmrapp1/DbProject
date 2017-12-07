<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once("../../services/DatabaseService.php");
require_once('../../services/PrescriptionService.php');

if (isset($_POST['prescriptionId'])) {
    $presId = $_POST['prescriptionId'];

    PrescriptionService::Instance()->deletePrescription($presId);
} else {
    $_SESSION['error'] = 'Please select a prescription';
}

// Redirect where needed
if (isset($_POST['redirect'])) {
    header('Location: ' . $_POST['redirect']);
}