<?php
/**
 * User: jonrapp
 * Date: 12/3/17
 */
require_once("DatabaseService.php");

final class UserService
{
    private $db;

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new UserService();
        }
        return $inst;
    }

    private function __construct()
    {
    }

    function userExists($username)
    {
        $statement = $this->db->prepare('SELECT * FROM `Login` WHERE `username` = :username');
        $statement->bindParam(':username', $username);
        $statement->execute();
        return $statement->rowCount() > 0;
    }

    function registerEmployee($username, $password, $name, $title) {
        $loginId = $this->createUser($username, $password);
        if (!($loginId instanceof ServiceError)) {
            EmployeeService::Instance()->createEmployee($name, $title, $loginId);
            $this->createUserRole($loginId, "Employee");
            return true;
        }
        return $loginId;
    }

    function createUser($username, $password)
    {
        if ($this->userExists($username) == false) {
            $statement = $this->db->prepare('INSERT INTO `Login` (username, password) VALUES (:username, :password)');
            $statement->bindParam(':username', $username);
            $statement->bindParam(':password', md5($password));
            $statement->execute();
            return $this->db->lastInsertId();
        }
        return new ServiceError("That username has already been used.");
    }

    function getUser($username, $password)
    {
        $statement = $this->db->prepare('SELECT * FROM `Login` WHERE `username` = :username AND `password` = :password');
        $statement->bindParam(':username', $username);
        $statement->bindParam(':password', md5($password));
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return $statement->fetch(PDO::FETCH_OBJ);
        }
        return new ServiceError("Either the username or password is incorrect.");
    }

    function getUserType($loginId) {
        $role = $this->getUserRole($loginId);
        if ($role != null) {
            return $role->User_Type;
        }
        return null;
    }

    function getUserTypeObject($loginId) {
        $type = $this->getUserType($loginId);
        if ($type != null) {
            $obj = null;
            switch($type) {
                case "Customer": {
                    $obj = CustomerService::Instance()->getCustomerByLoginId($loginId);
                    break;
                }
                case "Doctor": {
                    $obj = DoctorService::Instance()->getDoctorByLoginId($loginId);
                    break;
                }
                case "Employee": {
                    $obj = EmployeeService::Instance()->getEmployeeByLoginId($loginId);
                }
            }
            if ($obj != null) {
                return $obj;
            }
            return new ServiceError("Error retrieving the user's role type.");
        }
        return new ServiceError("Error retrieving the user's role.");
    }

    function createUserRole($loginId, $type) {
        $statement = $this->db->prepare('INSERT INTO `UserRoles` (Login_ID, User_Type) VALUES (:loginId, :type)');
        $statement->bindParam(':loginId', $loginId);
        $statement->bindParam(':type', $type);
        $statement->execute();
        return $this->db->lastInsertId();
    }

    function getUserRole($loginId) {
        $statement = $this->db->prepare('SELECT * FROM `UserRoles` WHERE `Login_ID` = :id');
        $statement->bindParam(':id', $loginId);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return $statement->fetch(PDO::FETCH_OBJ);
        }
        return null;
    }

    function getDoctor($id)
    {
        $statement = $this->db->prepare('SELECT * FROM `doctors` WHERE `Doctor_ID` = :id');
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

