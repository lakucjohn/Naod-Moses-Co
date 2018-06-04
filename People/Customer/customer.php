<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/9/18
 * Time: 5:34 PM
 */
require_once '../person.php';
require_once 'CustomerManager.php';

#This is the file that processes information received from ajax
class customer extends person{

    public $contactPerson;
    private $customerManager;

    #setting the default requirements for managing a customer
    public function __construct($personName, $personAddress, $personContact,$email,$contactPerson,$contactPersonPhone)
    {
        parent::__construct($personName, $personAddress, $personContact,$email);
        $this->contactPerson = $contactPerson;
        $this->contactPersonPhone=$contactPersonPhone;
        $this->customerManager = new CustomerManager();
    }

    #This function adds a new customer to the database
    public function addPerson()
    {
        $this->customerManager->Register($this->personalId,$this->personName,$this->personAddress,$this->email,$this->personContact,$this->contactPerson,$this->contactPersonPhone);
    }

    #THis function is for editing a supplier in the database
    public function editPerson($personId)
    {
        $this->personalId=$personId;
        $this->customerManager->edit($this->personalId,$this->personName,$this->personAddress,$this->email,$this->personContact,$this->contactPerson,$this->contactPersonPhone);

    }

    #THis code deletes a supplier from the database
    public function deletePerson($personId)
    {
        $this->personalId=$personId;
        $this->customerManager->delete($this->personalId);

    }


}

#Now handling ajax requests
if(isset($_POST['action'])){

    #This code adds a new adds the new customer posted by ajax from customers.php
    if($_POST['action']=='addCustomer'){

        #This code add a new customer to the system
        if(isset($_POST['customerName'])
            &&isset($_POST['customerAddress'])
            &&isset($_POST['customerEmail'])
            &&isset($_POST['customerTelephone'])
            &&isset($_POST['customerContactPerson'])
            &&isset($_POST['customerContactPersonContact'])
        ){
            $customerName = $_POST['customerName'];
            $customerAddress = $_POST['customerAddress'];
            $customerEmail = $_POST['customerEmail'];
            $customerTelephone = $_POST['customerTelephone'];
            $customerContactPerson = $_POST['customerContactPerson'];
            $customerContactPersonPhone = $_POST['customerContactPersonContact'];

            $customer = new customer($customerName,$customerAddress,$customerTelephone,$customerEmail,$customerContactPerson,$customerContactPersonPhone);
            $customer->addPerson();
        }


    }

    #This code edits a selected customer posted by ajax from customers.php
    if($_POST['action']=='editCustomer'){

        if(isset($_POST['customerNameEdited'])
            &&isset($_POST['customerAddressEdited'])
            &&isset($_POST['customerEmailEdited'])
            &&isset($_POST['customerTelephoneEdited'])
            &&isset($_POST['customerContactPersonEdited'])
            &&isset($_POST['customerContactPersonContactEdited'])
            &&isset($_POST['editedCustomerId'])
        ){
            $customerNameEdited = $_POST['customerNameEdited'];
            $customerAddressEdited = $_POST['customerAddressEdited'];
            $customerEmailEdited = $_POST['customerEmailEdited'];
            $customerTelephoneEdited = $_POST['customerTelephoneEdited'];
            $customerContactPersonEdited = $_POST['customerContactPersonEdited'];
            $customerContactPersonPhoneEdited = $_POST['customerContactPersonContactEdited'];
            $customerIdEdited = $_POST['editedCustomerId'];

            $customer = new customer($customerNameEdited,$customerAddressEdited,$customerTelephoneEdited,$customerEmailEdited,$customerContactPersonEdited,$customerContactPersonPhoneEdited);
            $customer->editPerson($customerIdEdited);
        }
    }

    #This code deletes a customer from the system. its values are from customers.php
    if($_POST['action']=='deleteCustomer'){

        if(isset($_POST['deletedCustomerId'])){
            $deletedCustomerId = $_POST['deletedCustomerId'];
            $customer = new customer($deletedCustomerId,'','','','','');
            $customer->deletePerson($deletedCustomerId);
        }
    }
}
//$customer = new customer('Lakuc','John','Dera','0777971871');
//$customer->register();
?>