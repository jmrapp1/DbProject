<?php
/**
 * User: jonrapp
 * Date: 12/3/17
 */
require_once("DatabaseService.php");
require_once("PrescriptionService.php");

final class CustomerService
{
    private $db;

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new CustomerService();
        }
        return $inst;
    }

    private function __construct()
    {
    }

    function createCustomer()
    {
        return false;
    }

    function getAllCustomers()
    {
        $statement = $this->db->prepare('SELECT * FROM `Customer`');
        $statement->execute();
        return $statement->fetchAll();
    }

    function getCustomer($id)
    {
        $statement = $this->db->prepare('SELECT * FROM `Customer` WHERE `Customer_ID` = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return $statement->fetch(PDO::FETCH_OBJ);
        }
        return null;
    }

    function deleteCustomer($customerId) {
        $statement = $this->db->prepare('DELETE FROM `Customer` WHERE Customer_ID = :customerId');
        $statement->bindParam(':customerId', $customerId);
        $statement->execute();
        PrescriptionService::Instance()->deletePrescriptionsForCustomer($customerId);
    }

    function setDb($db)
    {
        $this->db = $db;
    }

}

