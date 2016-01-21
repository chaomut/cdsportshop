<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();
require '../cancel_sale.php';
require './php/m_checklogin.php';
if (isset($_SESSION['member_id'])) {
    require './php/connect.php';
    $sql = "SELECT member_email FROM member WHERE member_id='{$_SESSION['member_id']}'";
    $result = mysqli_query($connect, $sql);
    $array = mysqli_fetch_array($result);
    $member_email = $array['member_email'];
}
?>
<html>
    <head>
        <title>Change New Password</title>
        <meta charset = "UTF-8">
        <link href = "css/bootstrap.min.css" rel = "stylesheet" type = "text/css">
        <script src = "js/jquery-1.11.3.min.js" type = "text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/css_page.css" rel="stylesheet" type="text/css">
        <script src="js/password_recovery.js" type="text/javascript"></script>

    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <ul class="nav nav-tabs">
                    <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> HOME</a></li>
                    <ul class="nav navbar-nav navbar-right">

                    </ul>
                </ul>
            </div>
        </nav>
        <br>
        <br>
        <h2 id="text-head" class="text-center">Change New Password </h2>
        <hr>
        <div id="forget-pass" class="col-sm-6 col-sm-offset-3">                    
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <div id="sign-in" class="panel-title">Sign In</div>
                </div>     
                <div  class="panel-body" >
                    <div style="display:none" id="login-alert" class="col-sm-12"></div>
                    <div style="margin-bottom: 20px">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input id="email-recovery" type="email" class="form-control" maxlength="50" value="<?php
                            if (isset($member_email)) {
                                echo $member_email;
                            }
                            ?>" placeholder="Email">
                        </div>
                        <div class="text-danger text-right">
                            <span id='error-email-recovery'></span> 
                        </div>
                    </div>
                    <div style="margin-bottom: 20px">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
                            <input id="recovery-tel" type="tel" class="form-control" maxlength="10" placeholder="Tel">
                        </div>
                        <div class="text-danger text-right">
                            <span id='error-recovery-tel'></span> 
                        </div>
                    </div>
                    <div style="margin-bottom: 20px">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="recovery-password" type="password" class="form-control" placeholder="New-Password">
                        </div>
                        <div class="text-danger text-right">
                            <span id='error-recovery-password'></span> 
                        </div>
                    </div>
                    <div style="margin-bottom: 20px">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="recovery-password-again" type="password" class="form-control"  placeholder="New-Password-Again">
                        </div>
                        <div class="text-danger text-right">
                            <span id='error-recovery-password-again'></span> 
                        </div>
                    </div>
                    <div style="margin-top:10px" class="form-group">
                        <div class="col-sm-12">
                            <a id="recovery-pass-btn"  class="btn btn-success">Change new password</a>                        
                        </div>
                    </div>
                </div>                     
            </div>  
        </div>
    </body>
</head>
</html>