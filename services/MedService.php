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

    function removeMedStock($medId)
    {
        $med = $this->getMed($medId);
        if ($med !== null) {
            $newStockLeft = $med->Stock_Amount - 1;
            if ($newStockLeft > 0) {
                // Remove 1 from the stock and update
                $statement = $this->db->prepare('UPDATE `meds` SET Stock_Amount = :newStockLeft WHERE Med_ID = :medId');
                $statement->bindParam(':newStockLeft', $newStockLeft);
                $statement->bindParam(':medId', $med);
                $statement->execute();
                return true;
            }
            // Delete the med because there's no stock left
            $statement = $this->db->prepare('DELETE FROM `meds` WHERE Med_ID = :medId');
            $statement->bindParam(':medId', $medId);
            $statement->execute();
            return true;
        }
        return new ServiceError('A medicine with that ID does not exist.');
    }

    function getAllMeds()
    {
        $statement = $this->db->prepare('SELECT * FROM `meds`');
        $statement->execute();
        return $statement->fetchAll();
    }

    function getMed($id)
    {
        $statement = $this->db->prepare('SELECT * FROM `meds` WHERE `Med_ID` = :id');
        $statement->bindParam(':id', $id);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            return $statement->fetch(PDO::FETCH_OBJ);
        }
        return null;
    }

    function doesMedExist($name)
    {
        $statement = $this->db->prepare('SELECT COUNT(*) FROM `meds` WHERE `Name` = :name');
        $statement->bindParam(':name', $name);
        $statement->execute();
        return $statement->fetchColumn() > 0;
    }

    function setDb($db)
    {
        $this->db = $db;
    }

}

