<?php
error_reporting(E_ALL^E_WARNING);
session_start();
require '../cancel_sale.php';
if (isset($_SESSION['member_id'])) {
    header("Refresh:0;url=index.php");
    exit();
}
?>
<html>
    <head>
        <title>  Login Page </title>
        <meta charset="UTF-8">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/css_page.css" rel="stylesheet" type="text/css">  
        <script src="js/m_takelogin.js" type="text/javascript"></script>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <ul class="nav nav-tabs">
                    <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> HOME</a></li>
                    <ul class="nav navbar-default navbar-right "> 
                        <li class="active"><a href='login_page.php'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>
                    </ul>
                </ul>
            </div>
        </nav>
        <br>
        <br>
        <br>
        <div class="container">
            <div class="alert alert-warning">
                <strong>ขออภัย ! </strong> ทำการเข้าสู่ระบบก่อนทำรายการต่างๆ หรือ สมัครสมาชิก
            </div><hr>
            <div class="col-sm-6 col-sm-offset-3">
                <h4 class = 'modal-title text-danger'>Please Sigin for Add to cart!</h4><br>

                <div class = 'input-group'>
                    <span class = 'input-group-addon'><i class = 'glyphicon glyphicon-user'></i></span>
                    <input id = 'login-e-mail' type = 'text' class = 'form-control' maxlength="50" placeholder = 'Email Address'>
                </div>
                <div class="text-danger text-right">
                    <span id='error-email'></span> 
                </div><br>
                <div class = 'input-group'>
                    <span class = 'input-group-addon'><i class = 'glyphicon glyphicon-lock'></i></span>
                    <input id = 'login-password' type = 'password' class = 'form-control' placeholder = 'Password'>
                </div>                
                <div class="text-danger text-right">
                    <span id='error-password'></span> 
                </div><br>
                <div class='modal-footer'>
                    <button type='submit' id='takelogin' class = 'btn btn-primary'>Login</button>
                    <a href='register_page.php'> <div class = 'btn btn-success'>สมัครสมาชิก</div></a>
                    <a class="text-warning" href="recoverypassword_page.php"><u>ลืมรหัสผ่าน</u></a>
                </div>
            </div>
        </div>
    </body>
</html>
