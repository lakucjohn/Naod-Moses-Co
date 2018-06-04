<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/10/18
 * Time: 6:38 PM
 */

#This is the file managing the content of an incoming receipt

require '/opt/lampp/htdocs/Naod-Moses-Co/Transaction/ReceiptContent.php';
require '/opt/lampp/htdocs/Naod-Moses-Co/Inventory/SpareParts/Spares/SparePartManager.php';

class PurchaseReceiptContent extends ReceiptContent{

    public $owner;

    #Dictating the nature of an incoming receipt content
    public function __construct($receiptNumber, $sparePartId, $quantity, $description, $price, $amount, $owner)
    {
        parent::__construct($receiptNumber, $sparePartId, $quantity, $description, $price, $amount);
        $this->owner = $owner;
    }

    #Function to add a new purchase receipt content
    public function addReceiptContent(){
        $sql = "INSERT INTO purchases_receipt_content(receipt_number, spare_part, quantity, description, supplier, price, amount) VALUES ('$this->receiptNumber','$this->sparePartId',$this->quantity,'$this->description','$this->owner',$this->price, $this->amount)";
        mysqli_query($this->connect,$sql);
    }

    #Function to edit single content of an existing receipt
    public function editReceiptContent(){
        $sql = "UPDATE purchases_receipt_content SET quantity=$this->quantity,description='$this->description',supplier='$this->owner',price=$this->price, amount = $this->amount WHERE  spare_part='$this->sparePartId' AND receipt_number='$this->receiptNumber' AND supplier='$this->owner'";
        mysqli_query($this->connect,$sql);
    }

    #Function to delete a content from a purchase receipt in the database
    public function deleteReceiptContent(){
        $sql = "UPDATE purchases_receipt_content SET status=0 WHERE spare_part='$this->sparePartId' AND receipt_number='$this->receiptNumber' AND supplier='$this->owner'";
        mysqli_query($this->connect,$sql);
    }
}

#Processing the ajax post request of new document content
if(isset($_POST['new_document_data'])) {
    $receivedJSON = $_POST['new_document_data'];

    #Conquering the incoming JSON to form arrays
    $owner = $receivedJSON[0]['document_details']['receiptName'];

    #Check if the content owner exists
    $ownerCheckSql = "SELECT supplier_id FROM suppliers WHERE supplier_name = '$owner'";

    if($ownerCheckSqlRun = mysqli_query($db_conn, $ownerCheckSql)){
        if(mysqli_num_rows($ownerCheckSqlRun) != 0){
            $rs = mysqli_fetch_assoc($ownerCheckSqlRun);

            #Get his Id
            $owner = $rs['supplier_id'];
        }
    }

    $documentId = $receivedJSON[0]['document_details']['receiptNumber'];
    //print_r($receivedJSON);

    #Manipulating the JSON
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
                                $purchaseReceipt = new PurchaseReceiptContent($documentId,$itemId,$itemQuantity,$itemDescription,$itemPrice,$itemAmount,$owner);

                                $purchaseReceipt ->addReceiptContent();
                            }




                        }
                    }
                }
            }
        }
    }


}
?>