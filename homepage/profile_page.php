<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();
require '../cancel_sale.php';
require './php/m_checklogin.php';
if (!isset($_SESSION['member_id'])) {
    header("Refresh:0;url=index.php");
    exit();
} else {
    $member_id = $_SESSION['member_id'];
    if (isset($member_id)) {
        require './php/connect.php';
        $sql = "select * from member where member_id='$member_id'";
        $result = mysqli_query($connect, $sql);
        $array = mysqli_fetch_array($result);
        $address = $array['member_address'];
        $newaddress = str_ireplace("แขวง", ",", $address);
        $newaddress = str_ireplace("เขต", ",", $newaddress);
        $newaddress = str_ireplace("จังหวัด", ",", $newaddress);
        $postcode = explode(",", $newaddress);
    }
}
?>
<html>
    <head>
        <title>Profile</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/css_page.css" rel="stylesheet" type="text/css">
        <script src="js/changeProfile.js" type="text/javascript"></script>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <ul class="nav nav-tabs">
                    <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> HOME </a></li>
                    <li class="active"><a href="profile_page.php"><span class="glyphicon glyphicon-lock"></span> Profile</a></li>
                    <li><a href="payment_page.php"><span class="glyphicon glyphicon-credit-card"></span> Payment</a></li>
                    <li><a href="history_page.php"><span class="glyphicon glyphicon-user"></span> History</a></li>
                    <ul class="nav navbar-nav navbar-right">
                        <?php echo $show_login; ?>
                    </ul>
                </ul>
            </div>
        </nav>
        <br>
        <div class="container">    
            <div style="margin-top:50px;" class="col-md-8 col-md-offset-2">                    
                <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div id="profile" class="panel-title">Profile   </div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px"></div>
                    </div>     
                    <div style="padding-top:30px" class="panel-body" >
                        <form id="profile_form" class="form-horizontal" role="form" method="POST">
                            <div style="margin-bottom: 20px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> รหัสสมาชิก</span>
                                <input readonly id="id-profile" type="text" class="form-control" value="<?php echo $array['member_id'] ?>"> 
                            </div>
                            <div style="margin-bottom: 20px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i> อีเมลล์</span>
                                <input readonly id="email-profile" type="text" class="form-control" value="<?php echo $array['member_email'] ?>">                                        
                            </div>   
                            <div style="margin-bottom: 20px">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i> เบอร์</span>
                                    <input readonly id="tel" type="tel" class="form-control" maxlength="10" value="<?php echo $array['member_tel'] ?>"> 
                                </div>
                                <div class="text-danger text-right">
                                    <span id='error-tel'></span> 
                                </div>
                            </div>
                            <div style="margin-bottom: 20px">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> ชื่อ</span>
                                    <input readonly id="fname" type="text" class="form-control" value="<?php echo $array['member_fname'] ?>">  
                                </div>
                                <div class="text-danger text-right">
                                    <span id='error-fname'></span> 
                                </div>

                            </div>
                            <div style="margin-bottom: 20px">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> นามสกุล</span>
                                    <input readonly id="lname" type="text" class="form-control" value="<?php echo $array['member_lname'] ?>"> 
                                </div>
                                <div class="text-danger text-right">
                                    <span id='error-lname'></span> 
                                </div>

                            </div>
                            <div style="margin-bottom: 20px">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i> ที่อยู่</span>
                                    <textarea readonly rows="3" id="address" class="form-control"><?php
                                        if (isset($postcode[0])) {
                                            echo trim($postcode[0]);
                                        }
                                        ?></textarea>  
                                </div>
                                <div class="text-danger text-right">
                                    <span id='error-address'></span> 
                                </div>
                            </div>
                            <div style="margin-bottom: 20px">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i> แขวง</span>
                                    <input readonly id="Subdistrict" type="text" class="form-control"   value="<?php
                                    if (isset($postcode[1])) {
                                        echo trim($postcode[1]);
                                    }
                                    ?>">
                                </div>
                                <div class="text-danger text-right">
                                    <span id='error-Subdistrict'></span> 
                                </div>
                            </div>
                            <div style="margin-bottom: 20px">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i> เขต</span>
                                    <input readonly id="District" type="text" class="form-control"  value="<?php
                                    if (isset($postcode[2])) {
                                        echo trim($postcode[2]);
                                    }
                                    ?>">
                                </div>
                                <div class="text-danger text-right">
                                    <span id='error-District'></span> 
                                </div>
                            </div>
                            <div style="margin-bottom: 20px">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i> จังหวัด</span>
                                    <input readonly id="Proviance" type="text" class="form-control" value="<?php
                                    if (isset($postcode[3])) {
                                        echo trim($postcode[3]);
                                    }
                                    ?>">
                                </div>
                                <div class="text-danger text-right">
                                    <span id='error-Proviance'></span> 
                                </div>
                            </div>
                            <div style="margin-bottom: 20px">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i> รหัสไปรษณีย์</span>
                                    <input readonly id="postcode" type="text" class="form-control" maxlength="5"  value="<?php
                                    if (isset($postcode[4])) {
                                        echo trim($postcode[4]);
                                    }
                                    ?>">
                                </div>
                                <div class="text-danger text-right">
                                    <span id='error-postcode'></span> 
                                </div>
                            </div>
                            <div style="margin-bottom: 25px">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock" ></i> รหัสผ่าน</span>
                                    <input id="password" type="password" class="form-control" placeholder="Password" > 
                                </div>
                                <div class="text-danger text-right">
                                    <span id='error-password'></span> 
                                </div>

                            </div>
                            <div style="margin-top:10px" class="form-group ">
                                <div class="col-md-12 controls ">
                                    <button id="edit-profile" type="button" class="btn btn-default">
                                        <span class="glyphicon glyphicon-ban-circle"></span> Edit</button>
                                    <button id="update_profile" type="button" class="btn btn-success">
                                        <span class="glyphicon glyphicon-edit"></span> Submit</button>
                                    <a class="text-warning" href="recoverypassword_page.php"><u>Recovery Password</u></a>  
                                </div>
                            </div>
                        </form>    
                    </div>                     
                </div>  
            </div>
        </div>
        <script>
            getProducts();
            function getProducts() {
                $("#show_cart").empty();
                $.post("./php/cart_manage.php?operation=show", {
                }, function (data) {
                    if (data.length <= 0) {
                        $("#cart_badge").removeClass("badge");
                    } else {
                        $("#cart_badge").addClass("badge");
                        $("#cart_badge").text(data.length);
                    }
                }, "json");
            }
        </script>
    </body>
</html>
