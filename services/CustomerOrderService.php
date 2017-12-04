<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once("DatabaseService.php");
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

    function createOrder($employeeId, $prescriptionId, $date, $orderAmount)
    {
        $prescription = PrescriptionService::Instance()->getPrescription($prescriptionId);
        if ($prescription !== null) {
            $employee = EmployeeService::Instance()->getEmployee($employeeId);
            if ($employee !== null) {
                $statement = $this->db->prepare('INSERT INTO `customer_orders` (Employee_ID, Prescription_ID, Date_Ordered, Order_Amount) VALUES (:employeeId, :prescriptionId, :date, :orderAmount)');
                $statement->bindParam(':employeeId', $employeeId);
                $statement->bindParam(':prescriptionId', $prescriptionId);
                $statement->bindParam(':date', date("Y-m-d H:i:s", strtotime($date)), PDO::PARAM_STR);
                $statement->bindParam(':orderAmount', $orderAmount);
                $statement->execute();
                return $this->db->lastInsertId();
            }
            return new ServiceError('An employee with that ID does not exist.');
        }
        return new ServiceError('A prescription with that ID does not exist.');
    }

    function getAllOrders()
    {
        $statement = $this->db->prepare('
          SELECT o.*, e.Name as EmployeeName, p.*, m.Name as MedName, c.Customer_Name as CustName
          FROM `customer_orders` o
          inner join `employees` e ON o.Employee_ID = e.Employee_ID
          inner join `prescriptions` p ON o.Prescription_ID = p.Prescription_ID
          inner join `meds` m ON p.Med_ID = m.Med_ID 
          inner join `Customer` c on p.Customer_ID = c.Customer_ID
          ');
        $statement->execute();
        return $statement->fetchAll();
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

