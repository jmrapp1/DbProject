<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */

final class MedService
{
    private $db;

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new MedService();
        }
        return $inst;
    }

    private function __construct()
    {
    }

    function createMed($name, $stock)
    {
        if (!$this->doesMedExist($name)) {
            $statement = $this->db->prepare('INSERT INTO `meds` (Name, Stock_Amount) VALUES (:name, :stock)');
            $statement->bindParam(':name', $name);
            $statement->bindParam(':stock', $stock);
            $statement->execute();
            return $this->db->lastInsertId();
        }
        return false;
    }

    function getMed($id) {
        $statement = $this->db->prepare('SELECT * FROM `meds` WHERE `Med_ID` = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return $statement->fetch(PDO::FETCH_OBJ);
        }
        return null;
    }

    function doesMedExist($name) {
        $statement = $this->db->prepare('SELECT COUNT(*) FROM `meds` WHERE `Name` = :name');
        $statement->bindParam(':name', $name);
        $statement->execute();
        return $statement->fetchColumn() > 0;
    }

    function setDb($db) {
        $this->db = $db;
    }

}

