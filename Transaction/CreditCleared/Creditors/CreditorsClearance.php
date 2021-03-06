<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/11/18
 * Time: 2:40 PM
 */

#Clearing a credit purchase
require '../CreditCleared.php';
class CreditorsClearance extends CreditCleared{

    private $personType = 'supplier';

    #Dictating the the settings of a document used for clearing a credit purchase
    public function __construct($owner,$documentCleared, $clearingMethod, $clearingDocument, $amountPaid)
    {
        parent::__construct($owner,$documentCleared, $clearingMethod, $clearingDocument, $amountPaid);
    }

    #Registering a payment used to clear a credit purchase
    public function registerPayment(){
        $sql = "INSERT INTO credit_transactions_cleared(document_cleared, person_clearing, clearing_method, clearing_document_id, amount_paid, person_type) VALUES ('$this->documentCleared','$this->owner','$this->clearingMethod','$this->clearingDocument',$this->amountPaid,'$this->personType')";
        mysqli_query($this->connect,$sql);
    }

    #Editing the content of a document used to clear a credit purchase
    public function editPayment(){
        $sql = "UPDATE credit_transactions_cleared SET clearing_method='$this->clearingMethod', clearing_document_id='$this->clearingDocument',amount_paid=$this->amountPaid WHERE person_clearing='$this->owner' AND document_cleared='$this->documentCleared' AND person_type='$this->personType'";
        mysqli_query($this->connect,$sql);
    }

    #Deleting the document used for clearing a credit purchase
    public function deletePayment(){
        $sql = "UPDATE credit_transactions_cleared SET status=0 WHERE person_clearing='$this->owner' AND document_cleared='$this->documentCleared' AND person_type='$this->personType' ORDER BY id DESC LIMIT 1";
        mysqli_query($this->connect,$sql);
    }

}