<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/10/18
 * Time: 6:37 PM
 */
require '/opt/lampp/htdocs/Naod-Moses-Co/core_resources/connect.inc.php';

#This class is the abstract class to set up all the default information any invoice must have.
#The invoice can be for sales or for purchases
class Invoice{

    public $invoiceNumber;
    public $owner;
    public $amount;
    public $dateRecorded;
    public $connect;

    #Setting the values of the invoice settings
    public function __construct($invoiceNumber, $owner, $amount, $dateRecorded)
    {
        global $db_conn;
        $this->connect = $db_conn;
        $this->invoiceNumber = $invoiceNumber;
        $this->owner = $owner;
        $this->amount = $amount;
        $this->dateRecorded = $dateRecorded;
    }
}
?>