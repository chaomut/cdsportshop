<?php
session_start();
require '../cancel_sale.php';
if (isset($_SESSION['admin_id'])) {
    header("location:mainmenu_back.php");
    exit();
}
?>
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="css/login_back.css" rel="stylesheet" type="text/css">
        <script src="js/jquery-2.1.4.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <header class="headertop">
            <img id="web-cover" src="../img/cover.jpg">
        </header>
        <div class="login-backoff">
            <!--login form-->
            <div class="login-form">
                <h2>Login to Back Office</h2>
                <form class="form-group" action="php/take_login.php" method="post">
                    <label class="control-label">Email:</label>
                    <input type="email" class="form-control" id="email-login" name="email" placeholder="Enter Email Address" maxlength="50">
                    <label class="control-label">Password:</label>
                    <input type="password" class="form-control" id="pass-login" name="password" placeholder="Enter Password" maxlength="24">
                    <a href="AdminProfile/forgot_password.php" class="forgotpw">forgot your password?</a><br><br>
                    <button type="submit" class="btn btn-primary">Login</button> 
                </form>
            </div>
        </div>
        <!--/login form-->
    </body>
</html>
