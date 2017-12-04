<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once("DatabaseService.php");
require_once('MedService.php');
require_once('ServiceError.php');

final class RestockOrderService
{
    private $db;

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new RestockOrderService();
        }
        return $inst;
    }

    private function __construct()
    {
    }

    function createOrder($employeeId, $medId, $orderAmount, $date)
    {
        $med = MedService::Instance()->getMed($medId);
        if ($med !== null) {
            $employee = EmployeeService::Instance()->getEmployee($employeeId);
            if ($employee !== null) {
                $statement = $this->db->prepare('INSERT INTO `Restock_Orders` (Employee_ID, Med_ID, Order_Amount, Date_Ordered) VALUES (:employeeId, :medId, :orderAmount, :date)');
                $statement->bindParam(':employeeId', $employeeId);
                $statement->bindParam(':medId', $medId);
                $statement->bindParam(':orderAmount', $orderAmount);
                $statement->bindParam(':date', date("Y-m-d H:i:s", strtotime($date)), PDO::PARAM_STR);
                $statement->execute();
                return $this->db->lastInsertId();
            }
            return new ServiceError('An employee with that ID does not exist.');
        }
        return new ServiceError('A medicine with that ID does not exist.');
    }

    function getAllOrders()
    {
        $statement = $this->db->prepare('
          SELECT o.*, e.Name as EmployeeName, m.Name as MedName
          FROM `Restock_Orders` o
          inner join `employees` e ON o.Employee_ID = e.Employee_ID
          inner join `meds` m ON o.Med_ID = m.Med_ID 
          ');
        $statement->execute();
        return $statement->fetchAll();
    }

    function getOrder($id)
    {
        $statement = $this->db->prepare('SELECT * FROM `Restock_Orders` WHERE `Order_ID` = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return $statement->fetch(PDO::FETCH_OBJ);
        }
        return null;
    }

    function setDb($db)
    {
        $this->db = $db;
    }

}

