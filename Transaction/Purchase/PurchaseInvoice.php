<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/10/18
 * Time: 6:38 PM
 */
require '../Invoice.php';
class PurchaseInvoice extends Invoice{
   public function __construct($invoiceNumber, $owner, $amount, $dateRecorded)
   {
       parent::__construct($invoiceNumber, $owner, $amount, $dateRecorded);
   }

    public function createNewInvoice(){
        $sql = "INSERT INTO credit_purchases(invoice_number, supplier, amount, date_received) VALUES ('$this->invoiceNumber','$this->owner',$this->amount,'$this->dateRecorded')";
        mysqli_query($this->connect, $sql);
    }

    public function editInvoice(){
        $sql = "UPDATE credit_purchases SET amount=$this->amount, date_received='$this->dateRecorded' WHERE supplier='$this->owner' AND invoice_number='$this->invoiceNumber'";
        mysqli_query($this->connect, $sql);
    }

    public function deleteInvoice(){
        $sql = "UPDATE credit_purchases SET status=0 WHERE invoice_number='$this->invoiceNumber' AND supplier='$this->owner'";
        mysqli_query($this->connect, $sql);
    }

}

#This function is repeated for convenience
function getUniqueId(){
    $stringSet = '0000000111111122222223333333444444455555556666666777777788888889999999';
    $stringSet = str_shuffle($stringSet);
    $stringSet = substr($stringSet, 0, 7);

    return $stringSet;
}
#Manipulating data from the interface. The data is sent her by ajax
if(isset($_POST['invoiceName']) && isset($_POST['invoiceDate']) && isset($_POST['invoiceNumber']) && isset($_POST['invoiceAmount'])){
    $invoiceName = $_POST['invoiceName'];
    $invoiceNumber = $_POST['invoiceNumber'];
    $invoiceDate = $_POST['invoiceDate'];
    $invoiceAmount = $_POST['invoiceAmount'];

    #Check if the owner(Supplier) exists in the database
    $ownerCheckSql = "SELECT customer_number FROM customers WHERE customer_name = '$invoiceName'";

    if($ownerCheckSqlRun = mysqli_query($db_conn, $ownerCheckSql)){

        #If he exists in the database
        if(mysqli_num_rows($ownerCheckSqlRun) != 0){
            $rs = mysqli_fetch_assoc($ownerCheckSqlRun);

            #Get the Id of the supplier
            $owner = $rs['customer_number'];
        }else{
            #If he does not exist, generate a seven character Id and assign it to him and save him in the database.
            $ownerId = getUniqueId();
            $saveSupplierSql = "INSERT INTO suppliers(supplier_id, supplier_name, supplier_address, email, telephone, contact_person, contact_person_phone) VALUES ('$ownerId','$invoiceName','none','none','none','none','none')";

            mysqli_query($db_conn, $saveSupplierSql);


            $owner = $ownerId;

        }
        $purchaseInvoice = new PurchaseInvoice($invoiceNumber,$owner,(float)$invoiceAmount,$invoiceDate);
        $purchaseInvoice->createNewInvoice();
    }
}

#This code deletes a purchase invoice
if(isset($_POST['action'])){
    if($_POST['action'] == 'deleteDocument'){

        if(isset($_POST['documentId'])&&isset($_POST['supplierId'])){
            $documentId = $_POST['documentId'];
            $supplier = $_POST['supplierId'];

            $document = new PurchaseInvoice($documentId,$supplier,'','');
            $document ->deleteInvoice();

        }
    }
}
?>