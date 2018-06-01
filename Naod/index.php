
<?php
session_start();
require '../core_resources/connect.inc.php';
$getSettingsSql = "SELECT * FROM settings";

if($getSettingsSqlRun = mysqli_query($db_conn, $getSettingsSql)){
    if(mysqli_num_rows($getSettingsSqlRun) == 0){
        include 'customise.php';
    }else{

        if(isset($_SESSION['username'])){
            include 'profile.php';

        }else{

            include 'login.php';
        }
    }
}

?>