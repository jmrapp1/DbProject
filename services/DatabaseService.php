<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once('MedService.php');
require_once('RestockOrderService.php');
require_once('EmployeeService.php');
require_once('PrescriptionService.php');
require_once('CustomerOrderService.php');
require_once('CustomerService.php');
require_once('DoctorService.php');
require_once('UserService.php');
require_once('SessionService.php');

final class DatabaseService
{
    private $db;

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new DatabaseService();
        }
        return $inst;
    }

    private function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=dbproject', 'root', '');
            session_start();

            MedService::Instance()->setDb($this->db);
            RestockOrderService::Instance()->setDb($this->db);
            EmployeeService::Instance()->setDb($this->db);
            PrescriptionService::Instance()->setDb($this->db);
            CustomerOrderService::Instance()->setDb($this->db);
            CustomerService::Instance()->setDb($this->db);
            DoctorService::Instance()->setDb($this->db);
            UserService::Instance()->setDb($this->db);
            SessionService::Instance()->setDb($this->db);
        } catch (PDOException $e) {
            print 'Error!: ' . $e->getMessage() . '<br/>';
            die();
        }
    }

    public function getDb()
    {
        return $this->db;
    }

}

DatabaseService::Instance();

?>