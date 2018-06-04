<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/10/18
 * Time: 6:42 PM
 */

#This file is for clearing credit transactions
require '../../core_resources/connect.inc.php';
class CreditCleared{
    public $documentCleared;
    public $clearingMethod;
    public $clearingDocument;
    public $amountPaid;
    public $owner;
    public $connect;

    #Setting the requirements to clear a credit transaction
    public function __construct($owner,$documentCleared, $clearingMethod,$clearingDocument, $amountPaid)
    {
        global $db_conn;
        $this->connect = $db_conn;
        $this->documentCleared = $documentCleared;
        $this->clearingMethod = $clearingMethod;
        $this->clearingDocument = $clearingDocument;
        $this->amountPaid = $amountPaid;
        $this->owner = $owner;
    }
}
?>