<?php
/**
 * User: jonrapp
 * Date: 12/3/17
 */
require_once("DatabaseService.php");

final class DoctorService
{
    private $db;

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new DoctorService();
        }
        return $inst;
    }

    private function __construct()
    {
    }

    function createDoctor()
    {
        return false;
    }

    function getAllDoctors()
    {
        $statement = $this->db->prepare('SELECT * FROM `doctors`');
        $statement->execute();
        return $statement->fetchAll();
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

