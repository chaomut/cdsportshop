<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();
require '../cancel_sale.php';
require './php/m_checklogin.php';
if (isset($_SESSION['member_id'])) {
    header("Refresh:0;url=index.php");
    exit();
}
?>
<html>
    <head>
        <title>Register Page</title>
        <meta charset = "UTF-8">
        <link href = "css/bootstrap.min.css" rel = "stylesheet" type = "text/css">
        <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/css_page.css" rel="stylesheet" type="text/css">
        <script src="js/member_js.js" type="text/javascript"></script>

    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <ul class="nav nav-tabs">
                    <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> HOME</a></li>
                    <li id="register-active" class="active"><a href="#"><span class="glyphicon glyphicon-user"></span> Register</a></li>
                    <ul class="nav navbar-nav navbar-right">    
                        <?php echo $show_login ?>
                    </ul>
                </ul>
            </div>
        </nav>
        <br>
        <div class="container"> 
            <div id="loginbox" style="margin-top:50px;" class="mainbox col-sm-6 col-sm-offset-3">                    
                <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div id="sign-in" class="panel-title">Register</div>
                    </div>     
                    <div class="panel-body" >                        
                        <form id="signupform" class="form-horizontal" role="form" method="POST">
                            <div class="form-group">
                                <label  class="col-sm-4 control-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email" id="e-mail" class="form-control" maxlength="50"  placeholder="Email Address">
                                    <div class="text-danger text-right">
                                        <span id='error-email'></span> 
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">ชื่อ</label>
                                <div class="col-sm-8">
                                    <input type="text" id="fname" class="form-control" maxlength="50" placeholder="ชื่อ">
                                    <div class="text-danger text-right">
                                        <span id='error-fname'></span> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-4 control-label">นามสกุล</label>
                                <div class="col-sm-8">
                                    <input type="text" id="lname" class="form-control" maxlength="50" placeholder="นามสกุล">
                                    <div class="text-danger text-right">
                                        <span id='error-lname'></span> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-4 control-label">ที่อยู่</label>
                                <div class="col-sm-8">
                                    <textarea rows="3" id="address"class="form-control" maxlength="80"  placeholder="ที่อยู่"></textarea>
                                    <div class="text-danger text-right">
                                        <span id='error-address'></span> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-4 control-label">ตำบล/แขวง</label>
                                <div class="col-sm-8">
                                    <input type="text" id="Subdistrict" class="form-control" maxlength="30"  placeholder="ตำบล / แขวง">
                                    <div class="text-danger text-right">
                                        <span id='error-Subdistrict'></span> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">อำเภอ/เขต</label>
                                <div class="col-sm-8">
                                    <input type="text" id="District" class="form-control" maxlength="30"  placeholder="อำเภอ / เขต">
                                    <div class="text-danger text-right">
                                        <span id='error-District'></span> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-4 control-label">จังหวัด</label>
                                <div class="col-sm-8">
                                    <input type="text" id="Proviance" maxlength="30" class="form-control" placeholder="จังหวัด">
                                    <div class="text-danger text-right">
                                        <span id='error-Proviance'></span> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">รหัสไปรษณีย์</label>
                                <div class="col-sm-8">
                                    <input type="text" id="postcode" maxlength="5" class="form-control"  placeholder="รหัสไปรษณีย์">
                                    <!-- check password-->
                                    <div class="text-danger text-right">
                                        <span id='error-postcode'></span> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">เบอร์โทรศัพท์</label>
                                <div class="col-sm-8">
                                    <input type="text" id="tel" class="form-control"  maxlength="10"  placeholder="Tel.">
                                    <!-- check password-->
                                    <div class="text-danger text-right">
                                        <span id='error-tel'></span> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">รหัสผ่าน</label>
                                <div class="col-sm-8">
                                    <input type="password" id="password"  class="form-control" name="passwd" placeholder="Password">
                                    <!-- check password-->
                                    <div class="text-danger text-right">
                                        <span id='error-password'></span> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label  class="col-sm-4 control-label">รหัสผ่านอีกครั้ง</label>
                                <div class="col-sm-8">
                                    <input type="password" id="re-password" class="form-control" name="passwd" placeholder="Re-Password">
                                    <!-- check password-->
                                    <div class="text-danger text-right">
                                        <span id='error-Repassword'></span> 
                                    </div>
                                </div>
                                <br><br>
                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class=" col-sm-8 col-sm-offset-4">
                                        <button id="btn-signup" type="button" class="btn btn-success"><i class="icon-hand-right"></i>  Sign Up</button>
                                        <button id="btn-reset" type="reset" class="btn btn-danger"><i class="icon-hand-right"></i>  Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>   
                    </div>                     
                </div>  
            </div>
        </div>
    </body>
</html>
