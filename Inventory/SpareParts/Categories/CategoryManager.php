<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/10/18
 * Time: 4:15 PM
 */

#THis class manages inserting, editing and deleting of product categories
require '../../../core_resources/connect.inc.php';
class CategoryManager{

    private $connect;

    #Setting up the pre-requisites of carrying ou the operations
    public function __construct()
    {
        global $db_conn;
        $this->connect = $db_conn;
    }

    #THis function creates a new product category
    public function createCategory($categoryId, $categoryName, $categoryDescription){
        $sql = "INSERT INTO categories(category_id, category_name, description) VALUES('$categoryId','$categoryName','$categoryDescription')";
        mysqli_query($this->connect,$sql);
    }

    #This function edits a product category
    public function editCategory($categoryId, $categoryName, $categoryDescription){
        $sql = "UPDATE categories SET category_name='$categoryName',description='$categoryDescription' WHERE category_id='$categoryId'";
        mysqli_query($this->connect,$sql);
    }

    #This is the function to delete a product category
    public function deleteCategory($categoryId){
        $sql = "UPDATE categories SET status=0 WHERE category_id='$categoryId'";
        mysqli_query($this->connect,$sql);
    }

}
?>