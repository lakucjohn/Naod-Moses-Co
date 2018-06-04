<?php

/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/9/18
 * Time: 5:16 PM
 */
require_once '../../core_resources/connect.inc.php';
#This file handles all direct manipulations of a customer in the database
class CustomerManager
{
    private $connect;

    #Setting up the requirements for database manipulation
    public function __construct()
    {
        global $db_conn;
        $this->connect = $db_conn;
    }

    #THis is the code for adding a new customer to the database
    public function register($customerNumber,$customerName,$customerAddress,$customerEmail, $customerPhone, $contactPerson,$contactPersonPhone){
        $sql = "INSERT INTO customers(customer_name, customer_number, customer_address, customer_email, customer_phone, contact_person, contact_person_phone) VALUE ('$customerName','$customerNumber','$customerAddress','$customerEmail','$customerPhone','$contactPerson','$contactPersonPhone')";
        mysqli_query($this->connect,$sql);
    }

    #This is the code for editing a customer in the database
    public function edit($customerNumber,$customerName,$customerAddress, $customerEmail, $customerPhone, $contactPerson, $contactPersonPhone){
        $sql = "UPDATE customers SET customer_name='$customerName',customer_address='$customerAddress',customer_email='$customerEmail',contact_person='$contactPerson',customer_phone='$customerPhone', contact_person_phone='$contactPersonPhone' WHERE customer_number='$customerNumber'";
        mysqli_query($this->connect,$sql);
    }

    #This code deletes a customer from the database
    public function delete($customerNumber){
        $sql = "UPDATE customers SET status=0 WHERE customer_number='$customerNumber'";
        mysqli_query($this->connect,$sql);
    }
}