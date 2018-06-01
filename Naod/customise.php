<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/31/18
 * Time: 9:19 AM
 */
require '../core_resources/connect.inc.php';

$password_error = '';
$company_name = '';
$country = '';
$district = '';
$street = '';
$mailing_address = '';
$telephone = '';
$email = '';
$username = '';
$system_name = '';

if(isset($_POST['save_app_settings'])){
    if(isset($_POST['company_name']) &&
        isset($_POST['country']) &&
        isset($_POST['district']) &&
        isset($_POST['street']) &&
        isset($_POST['mailing_address']) &&
        isset($_POST['telephone']) &&
        isset($_POST['email']) &&
        isset($_POST['username']) &&
        isset($_POST['password']) &&
        isset($_POST['password_confirm']) &&
        isset($_POST['system_name'])){

        $company_name = $_POST['company_name'];
        $country = $_POST['country'];
        $district = $_POST['district'];
        $street = $_POST['street'];
        $mailing_address = $_POST['mailing_address'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $system_name = $_POST['system_name'];

        if(!empty($company_name)&&
            !empty($country)&&
            !empty($district)&&
            !empty($street)&&
            !empty($telephone)&&
            !empty($username)&&
            !empty($password)&&
            !empty($password_confirm)&&
            !empty($system_name)){

            #Checking the passwords

            if($password == $password_confirm){
                //Process the Image input
                if(getimagesize($_FILES['logo']['tmp_name']) == FALSE){
                    echo 'Please Select an Image';
                }else{
                    $imageFile = addslashes($_FILES['logo']['tmp_name']);

                    $imageName = addslashes($_FILES['logo']['name']);

                    $imageContent = file_get_contents($imageFile);

                    $encodedImage = base64_encode($imageContent);
                }

                #Preparing the Location Information
                $location = $street.', '.$district.' - '.$country;

                #Now saving the settings
                $settingsSql = "INSERT INTO settings(application_name, name_of_company, location, mailing_address, telephone, company_logo, file_name, admin_username, admin_password, email_address) VALUES ('$system_name','$company_name','$location','$mailing_address','$telephone','$encodedImage','$imageName','$username','$password','$email')";

                if(mysqli_query($db_conn,$settingsSql)){
                    header('Location: index.php');
                }

            }else{
                $password_error = 'Your passwords do mot match';
            }



        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Login Form with Avatar Image</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
        body {
            color: #fff;
            background: #b9b9b9;
        }
        .form-control {
            min-height: 41px;
            background: #fff;
            box-shadow: none !important;
            border-color: #e3e3e3;
        }
        .form-control:focus {
            border-color: #70c5c0;
        }
        .form-control, .btn {
            border-radius: 2px;
        }
        .customise-form {
            width: 80%;
            margin: 0 auto;
            padding: 100px 0 30px;
        }
        .customise-form form {
            color: #7a7a7a;
            border-radius: 2px;
            margin-bottom: 15px;
            font-size: 13px;
            background: #ececec;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
            position: relative;
        }
        .customise-form h2 {
            font-size: 22px;
            margin: 35px 0 25px;
        }
        .customise-form .avatar {
            position: absolute;
            margin: 0 auto;
            left: 0;
            right: 0;
            top: -50px;
            width: 95px;
            height: 95px;
            border-radius: 50%;
            z-index: 9;
            background: #70c5c0;
            padding: 15px;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
        }
        .customise-form .avatar img {
            width: 100%;
        }
        .customise-form input[type="checkbox"] {
            margin-top: 2px;
        }
        .customise-form .btn {
            font-size: 16px;
            font-weight: bold;
            background: #70c5c0;
            border: none;
            margin-bottom: 20px;
        }
        .customise-form .btn:hover, .login-form .btn:focus {
            background: #50b8b3;
            outline: none !important;
        }
        .customise-form a {
            color: #fff;
            text-decoration: underline;
        }
        .cusotmise-form a:hover {
            text-decoration: none;
        }
        .customise-form form a {
            color: #7a7a7a;
            text-decoration: none;
        }
        .customise-form form a:hover {
            text-decoration: underline;
        }
        .right-text{
            text-align: right;
        }
        hr {
            margin-top: 20px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #333;
        }

        .section-heading{
            margin-left: 40%;
        }
        .error{
            color:red;
        }
    </style>
</head>
<body>
<div class="customise-form">
    <form action="customise.php" method="post" enctype="multipart/form-data">

        <h2>APPLICATION SETTINGS</h2>

        <hr>
        <h3 class="section-heading">Part 1: Company</h3>

        <div class="row">
            <div class="col-md-3 right-text">
                <label>Name of Company: </label>
            </div>

            <div class="form-group col-md-8">
                <input type="text" class="form-control" name="company_name" value="<?php if($company_name){echo $company_name;} ?>" placeholder="Name of the company" required="required">
            </div>
        </div>

        <hr>
        <h3 class="section-heading">Part 2: Contact</h3>

        <div class="row">
            <div class="col-md-3 right-text">
                <label>Location: </label>
            </div>

            <div class="form-group col-md-8">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="country" value="<?php if($country){echo $country;} ?>" placeholder="Country" required="required">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="district" value="<?php if($district){echo $district;} ?>" placeholder="District" required="required">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="street" value="<?php if($street){echo $street;} ?>" placeholder="Street, Building" required="required">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 right-text">
                <label>Mailing Address: </label>
            </div>

            <div class="form-group col-md-8">
                <input type="text" class="form-control" name="mailing_address" value="<?php if($mailing_address){echo $mailing_address;} ?>" placeholder="example: P. O Box ...">
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 right-text">
                <label>Telephone: </label>
            </div>

            <div class="form-group col-md-8">
                <input type="text" class="form-control" name="telephone" value="<?php if($telephone){echo $telephone;} ?>" placeholder="example: 256777971871" required="required">
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 right-text">
                <label>Email Address: </label>
            </div>

            <div class="form-group col-md-8">
                <input type="email" class="form-control" name="email" value="<?php if($email){echo $email;} ?>" placeholder="example: admin@tech.com">
            </div>
        </div>

        <hr>
        <h3 class="section-heading">Part 3: Logo</h3>

        <div class="row">
            <div class="col-md-3 right-text">
                <label>Logo: </label>
            </div>

            <div class="form-group col-md-8">
                <input type="file" class="form-control" name="logo" placeholder="Logo" required="required">
            </div>
        </div>

        <hr>
        <h3 class="section-heading">Part 4: Administrator User Authentication</h3>

        <div class="row">
            <div class="col-md-3 right-text">
                <label>Administrator Username: </label>
            </div>

            <div class="form-group col-md-8">
                <input type="text" class="form-control" name="username" value="<?php if($username){echo $username;} ?>" placeholder="Username" required="required">
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 right-text">
                <label>Administrator Password: </label>
            </div>

            <div class="form-group col-md-8">
                <input type="password" class="form-control" name="password" placeholder="Password" required="required">
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 right-text">
                <label>Confirm Password: </label>
            </div>

            <div class="form-group col-md-8">
                <input type="password" class="form-control" name="password_confirm" placeholder="Re-enter Password" required="required">
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 right-text">
                <label> </label>
            </div>

            <div class="form-group col-md-8">
                <div class="row error">
                    <?php if($password_error){echo $password_error;} ?>
                </div>
            </div>
        </div>



        <hr>
        <h3 class="section-heading">Part 5: System</h3>

        <div class="row">
            <div class="col-md-3 right-text">
                <label>Name of the System: </label>
            </div>

            <div class="form-group col-md-8">
                <input type="text" class="form-control" name="system_name" value="<?php if($system_name){echo $system_name;} ?>" placeholder="Name of the System" required="required">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-7"></div>
            <div class="col-md-4"><button type="submit" name="save_app_settings" class="btn btn-primary btn-lg btn-block">Save Settings</button></div>

        </div>
        <div class="clearfix">

        </div>
    </form>
</div>
</body>
</html>
