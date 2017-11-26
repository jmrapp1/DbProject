<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */

final class PrescriptionService
{
    private $db;

    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new PrescriptionService();
        }
        return $inst;
    }

    private function __construct()
    {
    }

    // TODO: Validate customer and doctors exist (need to wait for Nick's code)
    function createPrescription($date, $refillsLeft, $customerId, $doctorId, $medId)
    {
        if ($this->isRealDate($date)) {
            $med = MedService::Instance()->getMed($medId);
            if ($med !== null) {
                $statement = $this->db->prepare('INSERT INTO `prescriptions` (Date_Prescribed, Refills_Left, Customer_ID, Doctor_ID, Med_ID) VALUES (:date, :refills, :customerId, :doctorId, :medId)');
                $statement->bindParam(':date', date("Y-m-d H:i:s", strtotime($date)), PDO::PARAM_STR);
                $statement->bindParam(':refills', $refillsLeft);
                $statement->bindParam(':customerId', $customerId);
                $statement->bindParam(':doctorId', $doctorId);
                $statement->bindParam(':medId', $medId);
                $statement->execute();
                return $this->db->lastInsertId();
            }
            return new ServiceError('A medicine with that ID does not exist.');
        }
        return new ServiceError('Please enter a valid date.');
    }

    function getPrescription($id)
    {
        $statement = $this->db->prepare('SELECT * FROM `prescriptions` WHERE `Prescription_ID` = :id');
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

