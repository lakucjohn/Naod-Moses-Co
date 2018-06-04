<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/10/18
 * Time: 6:38 PM
 */

#A sale invoice is an invoice issues to a debtor.
#Therefore it is an invoice whose details are for a credit sale to a customer
require '../Invoice.php';
class SaleInvoice extends Invoice {

    #THis function makes it be considered an invoice
    public function __construct($invoiceNumber, $owner, $amount, $dateRecorded)
    {
        parent::__construct($invoiceNumber, $owner, $amount, $dateRecorded);
    }

    #This function creates the record of
    public function createNewInvoice(){
        $sql = "INSERT INTO credit_sales(invoice_number, customer, amount, date_issued) VALUES ('$this->invoiceNumber','$this->owner',$this->amount,'$this->dateRecorded')";
        mysqli_query($this->connect, $sql);
    }

    #This function edits an invoice already in the database
    public function editInvoice(){
        $sql = "UPDATE credit_sales SET customer='$this->owner',amount=$this->amount, date_issued='$this->dateRecorded' WHERE invoice_number='$this->invoiceNumber'";
        mysqli_query($this->connect, $sql);
    }

    #THis function deletes an invoice from the database
    public function deleteInvoice(){
        $sql = "UPDATE credit_sales SET status=0 WHERE invoice_number='$this->invoiceNumber'";
        mysqli_query($this->connect, $sql);
    }

}
#This code was repeated but let it be there. It generates a randon 7 character string to act as an Id for a new customer
function getUniqueId(){
    $stringSet = '0000000111111122222223333333444444455555556666666777777788888889999999';
    $stringSet = str_shuffle($stringSet);
    $stringSet = substr($stringSet, 0, 7);

    return $stringSet;
}
#Manipulating data from the interface. The values are got from ajax post request.
if(isset($_POST['invoiceName']) && isset($_POST['invoiceDate']) && isset($_POST['invoiceNumber']) && isset($_POST['invoiceAmount'])){
    $invoiceName = $_POST['invoiceName'];
    $invoiceNumber = $_POST['invoiceNumber'];
    $invoiceDate = $_POST['invoiceDate'];
    $invoiceAmount = $_POST['invoiceAmount'];

    $ownerCheckSql = "SELECT customer_number FROM customers WHERE customer_name = '$invoiceName'";

    if($ownerCheckSqlRun = mysqli_query($db_conn, $ownerCheckSql)){
        if(mysqli_num_rows($ownerCheckSqlRun) != 0){
            $rs = mysqli_fetch_assoc($ownerCheckSqlRun);
            $owner = $rs['customer_number'];
        }else{
            $ownerId = getUniqueId();
            $owner = $ownerId;
            $saveCustomerSql = "INSERT INTO customers(customer_number, customer_name, customer_address, customer_email, customer_phone, contact_person, contact_person_phone) VALUES ('$owner','$invoiceName','none','none','none','none','none')";

            mysqli_query($db_conn, $saveCustomerSql);

        }
        $saleInvoice = new SaleInvoice($invoiceNumber,$owner,(float)$invoiceAmount,$invoiceDate);
        $saleInvoice->createNewInvoice();
    }
}

if(isset($_POST['action'])){
    if($_POST['action'] == 'deleteDocument'){

        if(isset($_POST['documentId'])){
            $documentId = $_POST['documentId'];

            $document = new SaleInvoice($documentId,'','','');
            $document -> deleteInvoice();

        }
    }
}
?>