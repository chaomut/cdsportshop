<?php
error_reporting(E_ALL^E_WARNING);
session_start();
require '../cancel_sale.php';
if (isset($_SESSION['member_id']) AND isset($_SESSION['product'])) {
    require './php/connect.php';
    require './php/m_checklogin.php';
    require './php/checkout_php.php';
} else {
    header("Refresh:0;url=index.php");
    exit();
}
?>
<html>
    <head>
        <title> CheckOut </title>
        <meta charset="UTF-8">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/css_page.css" rel="stylesheet" type="text/css">
        <script src="js/save_SaleDetail.js" type="text/javascript"></script>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <ul class="nav nav-tabs">
                    <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> HOME</a></li>
                    <ul class="nav navbar-nav navbar-right">
                        <?php echo $show_login; ?>
                    </ul>
                </ul>
            </div>
        </nav>
        <br><br><br>
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <h2 class="title text-center">ที่อยู่ในการจัดส่ง</h2>

                    <div class="radio">
                        <label><input type="radio" name="optradio" checked="checked" value="<?php echo $member_address ?>">
                            <p> <?php echo $member_name ?> </p>
                        </label>
                        <textarea readonly  rows="4" id="address-profile" class="form-control" ><?php echo $member_address ?></textarea> 
                    </div>
                    <?php
                    echo $html
                    ?> 
                    <div class="col-sm-12 text-right padding-right">
                        <button id="btn-old-address" class="btn btn-success">สั่งซื้อสินค้า</button>
                    </div>
                </div>      
                <div class="col-sm-7">
                    <h2 class="title text-center">New Address</h2>
                    <a class="btn btn-primary" data-toggle="collapse" onclick="$('#product_sale').collapse('hide');" data-target="#otherAddress"><span class="glyphicon glyphicon-home"></span> ใช้ที่อยู่อื่น</a>
                    <a class="btn btn-info" data-toggle="collapse" onclick="$('#otherAddress').collapse('hide');" data-target="#product_sale"><span class="glyphicon glyphicon-shopping-cart"></span> สรุปการสั่งซื้อ</a>
                    <div id="otherAddress" class="collapse in">
                        <div class="panel-body" >             
                            <form id="signupform" class="form-horizontal" role="form" method="POST">
                                <div class="form-group">
                                    <label for="firstname" class="col-sm-3 control-label">ชื่อ</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="fname" class="form-control"  maxlength="25" placeholder="ชื่อ">
                                        <div class="text-danger text-right">
                                            <span id='error-fname'></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="col-sm-3 control-label">นามสกุล</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="lname" class="form-control" maxlength="25"  placeholder="นามสกุล">
                                        <div class="text-danger text-right">
                                            <span id='error-lname'></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address" class="col-sm-3 control-label">ที่อยู่</label>
                                    <div class="col-sm-9">
                                        <textarea rows="3" id="address"class="form-control" maxlength="80" placeholder="ที่อยู่"></textarea>
                                        <div class="text-danger text-right">
                                            <span id='error-address'></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="col-sm-3 control-label">ตำบล / แขวง</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="Subdistrict" class="form-control" maxlength="30" placeholder="ตำบล / แขวง">
                                        <div class="text-danger text-right">
                                            <span id='error-Subdistrict'></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="col-sm-3 control-label">อำเภอ / เขต</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="District" class="form-control" maxlength="30" placeholder="อำเภอ / เขต">
                                        <div class="text-danger text-right">
                                            <span id='error-District'></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="col-sm-3 control-label">จังหวัด</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="Proviance" class="form-control" maxlength="30" placeholder="จังหวัด">
                                        <div class="text-danger text-right">
                                            <span id='error-Proviance'></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="col-sm-3 control-label">รหัสไปรษณีย์</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="postcode" maxlength="5" class="form-control" name="lastname" placeholder="รหัสไปรษณีย์">
                                        <div class="text-danger text-right">
                                            <span id='error-postcode'></span> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tel" class="col-sm-3 control-label">Tel. Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="tel" class="form-control"  maxlength="10" name="telephone" placeholder="Tel.">
                                        <div class="text-danger text-right">
                                            <span id='error-tel'></span> 
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-sm-offset-3 col-sm-9">
                                        <button id="btn-new-address" type="button" class="btn btn-success"><i class="icon-hand-right"></i> สั่งซื้อสินค้า</button>
                                        <button id="btn-reset" type="reset" class="btn btn-danger"><i class="icon-hand-right"></i>  Reset</button>
                                    </div>
                                </div>
                            </form>   
                        </div>
                    </div>
                    <div id="product_sale" class="collapse">
                        <?php echo $html2;
                        ?>
                    </div>
                </div>
            </div>  
        </div>
    </body>
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
</html>