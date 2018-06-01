<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/10/18
 * Time: 6:26 PM
 */
require '../Receipt.php';
class SaleReceipt extends Receipt{

    public function __construct($receiptNumber, $owner, $amount)
    {
        parent::__construct($receiptNumber, $owner, $amount);
    }

    public function createReceipt(){
        $sql = "INSERT INTO cash_sales(receipt_number, customer, amount) VALUES ('$this->receiptNumber','$this->owner',$this->amount)";
        mysqli_query($this->connect, $sql);
    }

    public function editReceipt(){
        $sql = "UPDATE cash_sales SET customer='$this->owner',amount=$this->amount WHERE receipt_number='$this->receiptNumber'";
        mysqli_query($this->connect, $sql);
    }

    public function deleteReceipt(){
        $sql = "UPDATE cash_sales SET status=0 WHERE receipt_number='$this->receiptNumber'";
        mysqli_query($this->connect, $sql);
    }
}

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

    $ownerCheckSql = "SELECT customer_number FROM customers WHERE customer_name = '$receiptName'";

    if($ownerCheckSqlRun = mysqli_query($db_conn, $ownerCheckSql)){
        if(mysqli_num_rows($ownerCheckSqlRun) != 0){
            $rs = mysqli_fetch_assoc($ownerCheckSqlRun);
            $owner = $rs['customer_number'];
        }else{
            $ownerId = getUniqueId();
            $owner = $ownerId;
            $saveCustomerSql = "INSERT INTO customers(customer_number, customer_name, customer_address, customer_email, customer_phone, contact_person, contact_person_phone) VALUES ('$owner','$receiptName','none','none','none','none','none')";

            mysqli_query($db_conn, $saveCustomerSql);

        }
        $saleReceipt = new SaleReceipt($receiptNumber,$owner,(float)$receiptAmount);
        $saleReceipt->createReceipt();
    }
}

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