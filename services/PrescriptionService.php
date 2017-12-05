<?php
/**
 * User: jonrapp
 * Date: 11/26/17
 */
require_once('DatabaseService.php');
require_once('MedService.php');
require_once('CustomerService.php');
require_once('DoctorService.php');

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
        $customer = CustomerService::Instance()->getCustomer($customerId);
        if ($customer !== null) {
            $doctor = DoctorService::Instance()->getDoctor($doctorId);
            if ($doctor !== null) {
                $med = MedService::Instance()->getMed($medId);
                if ($med !== null) {
                    $statement = $this->db->prepare('INSERT INTO `prescriptions` (Date_Writen, Refill_Amount, Customer_ID, Doctor_ID, Med_ID) VALUES (:date, :refills, :customerId, :doctorId, :medId)');
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
            return new ServiceError('A doctor with that ID does not exist.');
        }
        return new ServiceError('A customer with that ID does not exist.');
    }

    function fulfillPrescription($prescriptionId)
    {
        $prescription = $this->getPrescription($prescriptionId);
        if ($prescription !== null) {
            $newRefills = $prescription->Refill_Amount - 1;
            if ($newRefills > 0) {
                // Remove 1 from the refills and update
                $statement = $this->db->prepare('UPDATE `prescriptions` SET Refill_Amount = :newRefillsLeft WHERE Prescription_ID = :prescriptionId');
                $statement->bindParam(':newRefillsLeft', $newRefills);
                $statement->bindParam(':prescriptionId', $prescriptionId);
                $statement->execute();
                return true;
            }
            // Delete the prescription because there's no refills left
            $statement = $this->db->prepare('DELETE FROM `prescriptions` WHERE Prescription_ID = :prescriptionId');
            $statement->bindParam(':prescriptionId', $prescriptionId);
            $statement->execute();
            return true;
        }
        return new ServiceError('A prescription with that ID does not exist.');
    }

    function getAllPrescriptions()
    {
        $statement = $this->db->prepare('
          SELECT p.*, m.Med_Name as MedName, d.Doctor_Name as DocName, c.Customer_Name as CustName
          FROM `prescriptions` p 
          inner join `meds` m ON p.Med_ID = m.Med_ID 
          inner join `doctors` d ON p.Doctor_ID = d.Doctor_ID
          inner join `Customer` c on p.Customer_ID = c.Customer_ID
          ');
        $statement->execute();
        return $statement->fetchAll();
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

    function setDb($db)
    {
        $this->db = $db;
    }

}

