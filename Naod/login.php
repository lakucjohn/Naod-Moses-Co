<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/31/18
 * Time: 9:18 AM
 */
$getSystemSettings = "SELECT * FROM settings";
if($getSystemSettingsRun = mysqli_query($db_conn, $getSystemSettings)){
    $rs = mysqli_fetch_assoc($getSystemSettingsRun);
    $system_name = $rs['application_name'];
}
$user_error = '';
if(isset($_POST['submit_user'])){
    if(isset($_POST['username_login']) && isset($_POST['password_login'])){
        $username_login = $_POST['username_login'];
        $password_login = $_POST['password_login'];

        require '../core_resources/connect.inc.php';

        if(!empty($username_login)&&!empty($password_login)){
            $validateAdmin = "SELECT * FROM settings WHERE admin_username='$username_login' AND admin_password='$password_login'";

            if($validateAdminRun = mysqli_query($db_conn, $validateAdmin)){
                if(mysqli_num_rows($validateAdminRun)==0){
                    $user_error = 'Invalid Username and/or Password';
                }else{
                    session_start();
                    $app_rs = mysqli_fetch_assoc($validateAdminRun);
                    $_SESSION['username'] = $app_rs['admin_username'];
                    $_SESSION['appname'] = $app_rs['application_name'];
                    $_SESSION['company'] = $app_rs['name_of_company'];
                    $_SESSION['location'] = $app_rs['location'];
                    $_SESSION['email'] = $app_rs['email_address'];
                    $_SESSION['mailing_address'] = $app_rs['mailing_address'];
                    $_SESSION['telephone'] = $app_rs['telephone'];
                    $_SESSION['logo'] = $app_rs['company_logo'];

                    header('Location: index.php');
                }
            }else{
                echo mysqli_error($db_conn);
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
    <title><?php echo $system_name; ?> | Login</title>
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
        .login-form {
            width: 60%;
            margin: 0 auto;
            padding: 100px 0 30px;
        }
        .login-form form {
            color: #7a7a7a;
            border-radius: 2px;
            margin-bottom: 15px;
            font-size: 13px;
            background: #ececec;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
            position: relative;
        }
        .login-form h2 {
            font-size: 22px;
            margin: 35px 0 25px;
        }
        .login-form .avatar {
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
        .login-form .avatar img {
            width: 100%;
        }
        .login-form input[type="checkbox"] {
            margin-top: 2px;
        }
        .login-form .btn {
            font-size: 16px;
            font-weight: bold;
            background: #70c5c0;
            border: none;
            margin-bottom: 20px;
        }
        .login-form .btn:hover, .login-form .btn:focus {
            background: #50b8b3;
            outline: none !important;
        }
        .login-form a {
            color: #fff;
            text-decoration: underline;
        }
        .login-form a:hover {
            text-decoration: none;
        }
        .login-form form a {
            color: #7a7a7a;
            text-decoration: none;
        }
        .login-form form a:hover {
            text-decoration: underline;
        }
        .error{
            color:red;
        }
    </style>
</head>
<body>
<div class="login-form">
    <form action="login.php" method="post">
        <div class="avatar">
            <img src="../Assets/images/avatar.png" alt="Avatar">
        </div>
        <h2 class="text-center"><?php echo $system_name; ?> Login</h2>
        <div class="form-group">
            <input type="text" class="form-control" name="username_login" value="" placeholder="Username" required="required">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password_login" value="" placeholder="Password" required="required">
        </div>

        <div class="form-group">
            <div class="error">
                <?php if($user_error) echo $user_error;?>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="submit_user" class="btn btn-primary btn-lg btn-block">Sign in</button>
        </div>
        <div class="clearfix">
<!--            <label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>-->
            <a href="#" class="pull-right">Forgot Password?</a>
        </div>
    </form>
    <p class="text-center small">Don't have an account? <a href="#">Sign up here!</a></p>
</div>
</body>
</html>