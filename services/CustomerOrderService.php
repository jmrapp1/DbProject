<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once('MedService.php');
require_once('ServiceError.php');
require_once('PrescriptionService.php');

final class CustomerOrderService
{
    private $db;

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new CustomerOrderService();
        }
        return $inst;
    }

    private function __construct()
    {
    }

    function createOrder($prescriptionId, $date)
    {
        if ($this->isRealDate($date)) {
            $prescription = PrescriptionService::Instance()->getPrescription($prescriptionId);
            if ($prescription !== null) {
                $statement = $this->db->prepare('INSERT INTO `customer_orders` (Prescription_ID, Order_Date) VALUES (:prescriptionId, :date)');
                $statement->bindParam(':prescriptionId', $prescriptionId);
                $statement->bindParam(':date', date("Y-m-d H:i:s", strtotime($date)), PDO::PARAM_STR);
                $statement->execute();
                return $this->db->lastInsertId();
            }
            return new ServiceError('A prescription with that ID does not exist.');
        }
        return new ServiceError('Please enter a valid date.');
    }

    function getOrder($id)
    {
        $statement = $this->db->prepare('SELECT * FROM `customer_orders` WHERE `Order_ID` = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return $statement->fetch(PDO::FETCH_OBJ);
        }
        return null;
    }

    function isRealDate($date)
    {
        if (false === strtotime($date)) {
            return false;
        }
        list($year, $month, $day) = explode('-', $date);
        return checkdate($month, $day, $year);
    }

    function setDb($db)
    {
        $this->db = $db;
    }

}

