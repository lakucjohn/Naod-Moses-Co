<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/9/18
 * Time: 5:06 PM
 */

require_once '../../core_resources/connect.inc.php';

#This is the actual class having functions for directly manipulating values from the database
class SupplierManager{
    private $connect;

    #Setting up the requirements for database manipulation
    public function __construct()
    {
        global $db_conn;
        $this->connect = $db_conn;
    }

    #THis function registers a new supplier
    public function register($supplierId, $supplierName, $supplierAddress, $supplierEmail, $supplierTelephone,$contactPerson, $contactPersonPhone){
        $sql = "INSERT INTO suppliers(supplier_id, supplier_name, supplier_address, email, telephone,contact_person, contact_person_phone) VALUES ('$supplierId','$supplierName','$supplierAddress','$supplierEmail','$supplierTelephone','$contactPerson','$contactPersonPhone')";
        mysqli_query($this->connect,$sql);

    }

    #This function edits the information about the supplier
    public function edit($supplierId, $supplierName, $supplierAddress, $supplierEmail, $supplierTelephone,$contactPerson, $contactPersonPhone){
        $sql = "UPDATE suppliers SET supplier_name='$supplierName',supplier_address='$supplierAddress',email='$supplierEmail',telephone='$supplierTelephone',contact_person='$contactPerson',contact_person_phone='$contactPersonPhone' WHERE supplier_id='$supplierId'";
        mysqli_query($this->connect,$sql);
    }

    #This function deletes
    public function delete($supplierId){
        $sql = "UPDATE suppliers SET status=0 WHERE supplier_id='$supplierId'";
        mysqli_query($this->connect,$sql);
    }
}
?>