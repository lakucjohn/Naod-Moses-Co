<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/10/18
 * Time: 6:39 PM
 */
require '../ReceiptContent.php';
require '../../Inventory/SpareParts/Spares/SparePartManager.php';
class SaleReceiptContent extends ReceiptContent{

    #dictating the content of a sale receipt
    public function __construct($receiptNumber, $sparePartId, $quantity, $description, $price,$amount, $owner)
    {
        parent::__construct($receiptNumber, $sparePartId, $quantity, $description, $price,$amount);
    }

    #This code is for adding content to a specified receipt(receipt number)
    public function addReceiptContent(){
        $sql = "INSERT INTO cash_sales_receipt_content(receipt_number, spare_part, quantity, description, price, amount) VALUES ('$this->receiptNumber','$this->sparePartId',$this->quantity,'$this->description',$this->price, $this->amount)";
        mysqli_query($this->connect,$sql);
    }

    #This code is for the editing the content of a receipt. this is a specific row in the database
    public function editReceiptContent(){
        $sql = "UPDATE cash_sales_receipt_content SET quantity=$this->quantity,description='$this->description',price=$this->price, amount=$this->amount WHERE spare_part='$this->sparePartId' AND receipt_number='$this->receiptNumber'";
        mysqli_query($this->connect,$sql);
    }

    #This code deletes the content of a receipt
    public function deleteReceiptContent(){
        $sql = "UPDATE cash_sales_receipt_content SET status=0 WHERE spare_part='$this->sparePartId' AND receipt_number='$this->receiptNumber'";
        mysqli_query($this->connect,$sql);
    }
}


if(isset($_POST['new_document_data'])) {
    $receivedJSON = $_POST['new_document_data'];

    #Conquering the incoming JSON to form arrays
    $owner = $receivedJSON[0]['document_details']['receiptName'];

    #Checking if the owner's name exists in the database
    $ownerCheckSql = "SELECT customer_number FROM customers WHERE customer_name = '$owner'";

    if($ownerCheckSqlRun = mysqli_query($db_conn, $ownerCheckSql)){
        if(mysqli_num_rows($ownerCheckSqlRun) != 0){
            $rs = mysqli_fetch_assoc($ownerCheckSqlRun);
            $owner = $rs['customer_number'];
        }
    }

    #Processig receipt content
    $documentId = $receivedJSON[0]['document_details']['receiptNumber'];
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

                                    #if it does not exist

                                    $itemId = getUniqueId();
                                    $sparePartManager = new SparePartManager();
                                    $sparePartManager->addSparePart($itemId,$itemName,'none','none','none','none',0);

                                }

                                #Now saving the final details
                                $saleReceipt = new SaleReceiptContent($documentId,$itemId,$itemQuantity,$itemDescription,$itemPrice,$itemAmount,$owner);

                                $saleReceipt ->addReceiptContent();
                            }




                        }
                    }
                }
            }
        }
    }


}
?>