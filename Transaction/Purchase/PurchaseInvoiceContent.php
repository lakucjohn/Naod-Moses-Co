<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/10/18
 * Time: 6:39 PM
 */
#This file handles the content of a purchase made on credit
require '../InvoiceContent.php';
require '../../Inventory/SpareParts/Spares/SparePartManager.php';
class PurchaseInvoiceContent extends InvoiceContent{
    public $owner;

    #Dictatting the nature of an invoice
    public function __construct($invoiceNumber, $sparePartId, $quantity, $description, $price,$amount,$owner)
    {
        parent::__construct($invoiceNumber, $sparePartId, $quantity, $description, $price,$amount);
        $this->owner = $owner;
    }

    #Adding content to a specific invoice specified byt its number and owner(supplier)
    public function addInvoiceContent(){
        $supplier = $this->owner;
        $documentId = $this->invoiceNumber;
        //echo $documentId;
        if(!empty($supplier) && !empty($documentId)){
            $sql = "INSERT INTO purchases_invoice_content(invoice_number, supplier, spare_part, quantity, description, price, amount) VALUES ('$documentId','$supplier','$this->sparePartId','$this->quantity','$this->description',$this->price, $this->amount)";
            mysqli_query($this->connect,$sql);
        }

    }

    #Edting the content of a saved invoice
    public function editInvoiceContent(){
        $sql = "UPDATE purchases_invoice_content SET quantity='$this->quantity',description='$this->description', price=$this->price, amount=$this->amount WHERE invoice_number='$this->invoiceNumber' AND spare_part='$this->sparePartId' AND supplier='$this->owner'";
        mysqli_query($this->connect,$sql);
    }

    #Deleting the content of an incoming invoice
    public function deleteInvoiceContent(){
        $sql = "UPDATE purchases_invoice_content SET status=0 WHERE invoice_number='$this->invoiceNumber' AND spare_part='$this->sparePartId' AND supplier='$this->owner'";
        mysqli_query($this->connect,$sql);
    }
}

if(isset($_POST['new_document_data'])) {
    $receivedJSON = $_POST['new_document_data'];

    #Conquering the incoming JSON to form arrays
    $owner = $receivedJSON[0]['document_details']['invoiceName'];

    #Getting the owner of the document
    $ownerCheckSql = "SELECT supplier_id FROM suppliers WHERE supplier_name = '$owner'";

    if($ownerCheckSqlRun = mysqli_query($db_conn, $ownerCheckSql)){
        if(mysqli_num_rows($ownerCheckSqlRun) != 0){
            $rs = mysqli_fetch_assoc($ownerCheckSqlRun);
            $owner = $rs['supplier_id'];
        }
    }

    #Getting the id of the invoice
    $documentId = $receivedJSON[0]['document_details']['invoiceNumber'];
    //print_r($receivedJSON);

    #processing the incoming JSON of invoice content
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

                                    #if it does not exist

                                    $itemId = getUniqueId();
                                    $sparePartManager = new SparePartManager();
                                    $sparePartManager->addSparePart($itemId,$itemName,'none','none','none','none',0);

                                }

                                #Now saving the final details
                                $purchaseInvoice = new PurchaseInvoiceContent($documentId,$itemId,$itemQuantity,$itemDescription,$itemPrice,$itemAmount,$owner);

                                $purchaseInvoice ->addInvoiceContent();
                            }




                        }
                    }
                }
            }
        }
    }


}
?>