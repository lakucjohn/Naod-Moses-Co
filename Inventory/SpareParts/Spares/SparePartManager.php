<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/10/18
 * Time: 3:48 PM
 */

#This class is meant to manage all issues concerning inserting, editing and deleting spare parts
require '/opt/lampp/htdocs/Naod-Moses-Co/core_resources/connect.inc.php';
class SparePartManager{

    private $connect;

    #Setting up the requirements to handle the manipulation of database records
    public function __construct()
    {
        global $db_conn;

        $this->connect = $db_conn;

    }

    #THis function adds a spare part to the database
    public function addSparePart($sparePartId, $sparePart, $sparePartCategory, $sparePartDescription, $sparePartModel, $packagingMethod, $packageQuantity){
        $sql = "INSERT INTO spare_parts(spare_part, part_id, model, category, description, packaging_method, package_quantity) VALUES ('$sparePart','$sparePartId','$sparePartModel','$sparePartCategory','$sparePartDescription','$packagingMethod','$packageQuantity')";

        if(!mysqli_query($this->connect,$sql)){
            echo mysqli_error($this->connect);
        }
    }

    #This is the function for editing a spare part
    public function editSparePart($sparePartId, $sparePart, $sparePartCategory, $sparePartDescription, $sparePartModel){
        $sql = "UPDATE spare_parts SET spare_part='$sparePart',model='$sparePartModel',category='$sparePartCategory',description='$sparePartDescription' WHERE part_id='$sparePartId'";
        mysqli_query($this->connect,$sql);
    }

    #This is the actual function for deleting a spare part from the system
    public function deleteSparePart($sparePartId){
        $sql = "UPDATE spare_parts SET status=0 WHERE part_id='$sparePartId'";
        mysqli_query($this->connect,$sql);
    }

}
?>