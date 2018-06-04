<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/10/18
 * Time: 6:26 PM
 */

#This file is for dictating the nature of a sale receipt issued to a customer
require '../Receipt.php';
class SaleReceipt extends Receipt{

    #THis code dictates the features of a cash sale receipt
    public function __construct($receiptNumber, $owner, $amount)
    {
        parent::__construct($receiptNumber, $owner, $amount);
    }

    #Create a receipt with all the features present
    public function createReceipt(){
        $sql = "INSERT INTO cash_sales(receipt_number, customer, amount) VALUES ('$this->receiptNumber','$this->owner',$this->amount)";
        mysqli_query($this->connect, $sql);
    }

    #Edit information about a receipt which is saved in the database
    public function editReceipt(){
        $sql = "UPDATE cash_sales SET customer='$this->owner',amount=$this->amount WHERE receipt_number='$this->receiptNumber'";
        mysqli_query($this->connect, $sql);
    }

    #Delete a wrongly written receipt
    public function deleteReceipt(){
        $sql = "UPDATE cash_sales SET status=0 WHERE receipt_number='$this->receiptNumber'";
        mysqli_query($this->connect, $sql);
    }
}

#This code is repeated. And it's meant to generate a 7 length string randomly
function getUniqueId(){
    $stringSet = '0000000111111122222223333333444444455555556666666777777788888889999999';
    $stringSet = str_shuffle($stringSet);
    $stringSet = substr($stringSet, 0, 7);

    return $stringSet;
}
#Manipulating data from the interface
if(isset($_POST['receiptName']) && isset($_POST['receiptDate']) && isset($_POST['receiptNumber']) && isset($_POST['receiptAmount'])){
    $receiptName = $_POST['receiptName'];
    $receiptNumber = $_POST['receiptNumber'];
    $receiptDate = $_POST['receiptDate'];
    $receiptAmount = $_POST['receiptAmount'];

    #Check if the owner exists in the database
    $ownerCheckSql = "SELECT customer_number FROM customers WHERE customer_name = '$receiptName'";

    if($ownerCheckSqlRun = mysqli_query($db_conn, $ownerCheckSql)){
        #if the owner exists get his id
        if(mysqli_num_rows($ownerCheckSqlRun) != 0){
            $rs = mysqli_fetch_assoc($ownerCheckSqlRun);
            $owner = $rs['customer_number'];
        }else{
            #If he does not exist provide him an Id
            $ownerId = getUniqueId();
            $owner = $ownerId;
            $saveCustomerSql = "INSERT INTO customers(customer_number, customer_name, customer_address, customer_email, customer_phone, contact_person, contact_person_phone) VALUES ('$owner','$receiptName','none','none','none','none','none')";

            mysqli_query($db_conn, $saveCustomerSql);

        }
        $saleReceipt = new SaleReceipt($receiptNumber,$owner,(float)$receiptAmount);
        $saleReceipt->createReceipt();
    }
}

#Deleting a cash sale receipt from the database
if(isset($_POST['action'])){
    if($_POST['action'] == 'deleteDocument'){

        if(isset($_POST['documentId'])){
            $documentId = $_POST['documentId'];

            $document = new SaleReceipt($documentId,'','');
            $document ->deleteReceipt();

        }
    }
}
?>