<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/10/18
 * Time: 6:39 PM
 */

#This class manages the default content of any sale invoice issued to a customer
require '../InvoiceContent.php';
require '../../Inventory/SpareParts/Spares/SparePartManager.php';
class SaleInvoiceContent extends InvoiceContent{

    public function __construct($invoiceNumber, $sparePartId, $quantity, $description, $price,$amount)
    {
        parent::__construct($invoiceNumber, $sparePartId, $quantity, $description, $price,$amount);
    }

    public function addInvoiceContent(){
        $sql = "INSERT INTO credit_sales_invoice_content(invoice_number, spare_part, quantity, description, price,amount) VALUES ('$this->invoiceNumber','$this->sparePartId',$this->quantity,'$this->description',$this->price,$this->amount)";
        mysqli_query($this->connect,$sql);
    }

    public function editInvoiceContent(){
        $sql = "UPDATE credit_sales_invoice_content SET quantity=$this->quantity,description='$this->description', price=$this->price, amount=$this->amount WHERE invoice_number='$this->invoiceNumber' AND spare_part='$this->sparePartId'";
        mysqli_query($this->connect,$sql);
    }

    public function deleteInvoiceContent(){
        $sql = "UPDATE credit_sales_invoice_content SET status=0 WHERE invoice_number='$this->invoiceNumber' AND spare_part='$this->sparePartId'";
        mysqli_query($this->connect,$sql);
    }

}

function getUniqueId(){
    $stringSet = '0000000111111122222223333333444444455555556666666777777788888889999999';
    $stringSet = str_shuffle($stringSet);
    $stringSet = substr($stringSet, 0, 7);

    return $stringSet;
}

#Handling ajax post requests
#THis is for inserting a new sale invoice document
if(isset($_POST['new_document_data'])) {
    $receivedJSON = $_POST['new_document_data'];

    #Conquering the incoming JSON to form arrays
    $owner = $receivedJSON[0]['document_details']['invoiceName'];

    $ownerCheckSql = "SELECT customer_number FROM customers WHERE customer_name = '$owner'";

    if($ownerCheckSqlRun = mysqli_query($db_conn, $ownerCheckSql)){
        if(mysqli_num_rows($ownerCheckSqlRun) != 0){
            $rs = mysqli_fetch_assoc($ownerCheckSqlRun);
            $owner = $rs['customer_number'];
        }
    }

    $documentId = $receivedJSON[0]['document_details']['invoiceNumber'];
    //print_r($receivedJSON);

    foreach($receivedJSON as $jsonObject => $documentObject){
        if($jsonObject == 1){
            foreach($documentObject as $documentItem => $itemList){
                if($documentItem == 'document_content'){
                    foreach($itemList as $data){
                        if(array_key_exists('itemName',$data) &&
                            array_key_exists('itemDescription',$data) &&
                            array_key_exists('itemQuantity',$data) &&
                            array_key_exists('itemPrice',$data) &&
                            array_key_exists('itemAmount',$data)){
                            $itemName = $data['itemName'];
                            $itemDescription = $data['itemDescription'];
                            $itemQuantity = $data['itemQuantity'];
                            $itemPrice = $data['itemPrice'];
                            $itemAmount = $data['itemAmount'];

                            #Verfying the existence of spare part
                            $productCheckSql = "SELECT part_id FROM spare_parts WHERE spare_part = '$itemName'";
                            if($productCheckSqlRun = mysqli_query($db_conn, $productCheckSql)){

                                #If spare part exists
                                if(mysqli_num_rows($productCheckSqlRun) !=0 ){
                                    $prs = mysqli_fetch_assoc($productCheckSqlRun);
                                    $itemId = $prs['part_id'];
                                }else{

                                    #if it does not exist, give it a random unique Id and save it to the database

                                    $itemId = getUniqueId();
                                    $sparePartManager = new SparePartManager();
                                    $sparePartManager->addSparePart($itemId,$itemName,'none','none','none','none',0);

                                }

                                #Now saving the final details
                                $saleInvoice = new SaleInvoiceContent($documentId,$itemId,$itemQuantity,$itemDescription,$itemPrice,$itemAmount,$owner);

                                $saleInvoice ->addInvoiceContent();
                            }




                        }
                    }
                }
            }
        }
    }


}
?>