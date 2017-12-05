<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once("DatabaseService.php");

final class EmployeeService
{
    private $db;

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new EmployeeService();
        }
        return $inst;
    }

    private function __construct()
    {
    }

    function createEmployee($name, $title)
    {
        $statement = $this->db->prepare('INSERT INTO `employees` (Employee_Name, Employee_Title) VALUES (:name, :title)');
        $statement->bindParam(':name', $name);
        $statement->bindParam(':title', $title);
        $statement->execute();
        return $this->db->lastInsertId();
    }

    function getAllEmployees()
    {
        $statement = $this->db->prepare('SELECT * FROM `employees`');
        $statement->execute();
        return $statement->fetchAll();
    }

    function getEmployee($id)
    {
        $statement = $this->db->prepare('SELECT * FROM `employees` WHERE `Employee_ID` = :id');
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

