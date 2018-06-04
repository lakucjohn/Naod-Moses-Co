<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/9/18
 * Time: 1:43 PM
 */
require_once '../person.php';
require_once 'SupplierManager.php';

#This file is for handling all direct operations that happen on a supplier
class supplier extends person{

    #This is a person that the company connects with to communicate with the supplier
    private $contactPerson;

    #This variable is an object that will use the functions in the class SupplierManager.php
    private $supplierManager;
    #This is the contact of the person that the coompany connects to to communicate with the company
    private $contactPersonPhone;

    #Setting the sefault values of any supplier
    public function __construct($personName, $personAddress, $personContact,$email,$contactPerson,$contactPersonPhone)
    {
        parent::__construct($personName, $personAddress, $personContact,$email);
        $this->contactPerson = $contactPerson;
        $this->contactPersonPhone=$contactPersonPhone;
        $this->supplierManager = new SupplierManager();
    }

    #THis is the function to add a new supplier to the database
    public function addPerson()
    {
        $this->supplierManager->Register($this->personalId,$this->personName,$this->personAddress,$this->email,$this->personContact,$this->contactPerson,$this->contactPersonPhone);
    }

    #This is the function to edit a supplier
    public function editPerson($personId)
    {
        $this->personalId=$personId;
        $this->supplierManager->edit($this->personalId,$this->personName,$this->personAddress,$this->email,$this->personContact,$this->contactPerson,$this->contactPersonPhone);

    }

    #This function deletes the supplier from the database
    public function deletePerson($personId)
    {
        $this->personalId=$personId;
        $this->supplierManager->delete($this->personalId);

    }


}
#Handling the various ajax post requests
if(isset($_POST['action'])){

    #This code adds a user posted by ajax from suppliers.php
    if($_POST['action']=='addSupplier'){

        #This code add a new supplier to the system
        if(isset($_POST['supplierName'])
            &&isset($_POST['supplierAddress'])
            &&isset($_POST['supplierEmail'])
            &&isset($_POST['supplierTelephone'])
            &&isset($_POST['supplierContactPerson'])
            &&isset($_POST['supplierContactPersonContact'])
        ){
            $supplierName = $_POST['supplierName'];
            $supplierAddress = $_POST['supplierAddress'];
            $supplierEmail = $_POST['supplierEmail'];
            $supplierTelephone = $_POST['supplierTelephone'];
            $supplierContactPerson = $_POST['supplierContactPerson'];
            $supplierContactPersonPhone = $_POST['supplierContactPersonContact'];

            $supplier = new supplier($supplierName,$supplierAddress,$supplierTelephone,$supplierEmail,$supplierContactPerson,$supplierContactPersonPhone);
            $supplier->addPerson();
        }


    }

    #This code edits a supplier posted by ajax from suppliers.php
    if($_POST['action']=='editSupplier'){

        if(isset($_POST['supplierNameEdited'])
            &&isset($_POST['supplierAddressEdited'])
            &&isset($_POST['supplierEmailEdited'])
            &&isset($_POST['supplierTelephoneEdited'])
            &&isset($_POST['supplierContactPersonEdited'])
            &&isset($_POST['supplierContactPersonContactEdited'])
            &&isset($_POST['editedSupplierId'])
        ){
            $supplierNameEdited = $_POST['supplierNameEdited'];
            $supplierAddressEdited = $_POST['supplierAddressEdited'];
            $supplierEmailEdited = $_POST['supplierEmailEdited'];
            $supplierTelephoneEdited = $_POST['supplierTelephoneEdited'];
            $supplierContactPersonEdited = $_POST['supplierContactPersonEdited'];
            $supplierContactPersonPhoneEdited = $_POST['supplierContactPersonContactEdited'];
            $supplierIdEdited = $_POST['editedSupplierId'];

            $supplier = new supplier($supplierNameEdited,$supplierAddressEdited,$supplierTelephoneEdited,$supplierEmailEdited,$supplierContactPersonEdited,$supplierContactPersonPhoneEdited);
            $supplier->editPerson($supplierIdEdited);
        }
    }

    #This code deletes a suppier from the system. It is posted by ajax from suppliers.php
    if($_POST['action']=='deleteSupplier'){

        if(isset($_POST['deletedSupplierId'])){
            $deletedSupplierId = $_POST['deletedSupplierId'];
            $supplier = new supplier($deletedSupplierId,'','','','','');
            $supplier->deletePerson($deletedSupplierId);
        }
    }
    //$supplier = new supplier('Harbourline Industries Ltd','Kampala','0777971871','supply@harbourline.com','John','0706291191');
    //$supplier->addPerson();
}


?>