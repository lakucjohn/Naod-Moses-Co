<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/10/18
 * Time: 6:39 PM
 */
#This is what the content of every receipt must have
$db_conn = mysqli_connect('localhost','root','','naod_moses_co_ltd');
class ReceiptContent{
    public $receiptNumber;
    public $sparePartId;
    public $quantity;
    public $description;
    public $price;
    public $amount;
    public $connect;

    #Setting the values of instantiation as the default values
    public function __construct($receiptNumber,$sparePartId,$quantity,$description,$price, $amount)
    {
        global $db_conn;
        $this->connect = $db_conn;
        $this->receiptNumber = $receiptNumber;
        $this->sparePartId = $sparePartId;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->price = $price;
        $this->amount = $amount;

    }
}
?>