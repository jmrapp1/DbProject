<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once('services/MedService.php');
require_once('services/RestockOrderService.php');
require_once('services/EmployeeService.php');
require_once('services/PrescriptionService.php');
require_once('services/CustomerOrderService.php');

$username = 'root';
$password = '';

try {
    global $db;
    $db = new PDO('mysql:host=localhost;dbname=dbproject', $username, $password);

    MedService::Instance()->setDb($db);
    RestockOrderService::Instance()->setDb($db);
    EmployeeService::Instance()->setDb($db);
    PrescriptionService::Instance()->setDb($db);
    CustomerOrderService::Instance()->setDb($db);

} catch (PDOException $e) {
    print 'Error!: ' . $e->getMessage() . '<br/>';
    die();
}
?>