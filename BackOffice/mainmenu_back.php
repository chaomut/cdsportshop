<?php
session_start();
require '../cancel_sale.php';
require './php/connect.php';
if (!isset($_SESSION['admin_id'])) {
    header("location: login_back.php");
    exit();
}

$sql1 = "SELECT * FROM sports_equipment WHERE amount <= reorder_point";

$result1 = mysqli_query($connect, $sql1);

if(mysqli_num_rows($result1) > 0){
    $html1 = "<img class='icon-menu' src='../img/product-icon_alert.png'>";
}
else{
    $html1 = "<img class='icon-menu' src='../img/product-icon.png'>";
}
?>
<html>
    <head>
        <title>Main Menu - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="css/menu_back.css" rel="stylesheet" type="text/css">
        <script src="js/jquery-2.1.4.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <header class="headertop">
            <span class="navbar-brand">C&D</span>
            <ul class="nav nav-tabs">
                <li><a href="mainmenu_back.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                <li><a href="AdminProfile/admin_profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
                <li><a href="php/logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
            </ul>
        </header>
        <div class="container">
            <h2>MAIN MENU</h2><hr>
            <div class="row">
                <div class="col-sm-3" id="main-menu">
                    <div class="thumbnail">
                        <a href="manage_submenu.php"><img class="icon-menu" src="../img/manage-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary" id="btn-main-menu">จัดการข้อมูลพื้นฐาน</button></center</a>
                    </div>
                </div>
                <div class="col-sm-3" id="main-menu">
                    <div class="thumbnail">
                        <a href="Purchase/purchase_order.php"> <?php echo $html1; ?><br>
                            <center><button type="submit" class="btn btn-primary">รายการสินค้า</button></center></a>
                    </div>
                </div>
                <div class="col-sm-3" id="main-menu">
                    <div class="thumbnail">
                        <a href="Purchase/purchase.php"><img class="icon-menu" src="../img/purchase-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary">รายการสั่งซื้อ</button></center></a>
                    </div>
                </div>
                <div class="col-sm-3" id="main-menu">
                    <div class="thumbnail">
                        <a href="Receive/receive.php"><img class="icon-menu" src="../img/receive-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary">ข้อมูลการรับสินค้า</button></center></a>
                    </div>
                </div>
                <div class="col-sm-3" id="main-menu">
                    <div class="thumbnail">
                        <a href="Sale/sale.php"><img class="icon-menu" src="../img/sale-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary">ข้อมูลการขายสินค้า</button></center></a>
                    </div>
                </div>
                <div class="col-sm-3" id="main-menu">
                    <div class="thumbnail">
                        <a href="Payment/check_payment.php"><img class="icon-menu" src="../img/confirm-payment-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary">ยืนยันการชำระเงิน</button></center></a>
                    </div>
                </div>
                <div class="col-sm-3" id="main-menu">
                    <div class="thumbnail">
                        <a href="Delivery/delivery.php"><img class="icon-menu" src="../img/delivery-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary">บันทึกข้อมูลการจัดส่ง</button></center></a>
                    </div>
                </div>
                <div class="col-sm-3" id="main-menu">
                    <div class="thumbnail">
                        <a href="Report/report.php"><img class="icon-menu" src="../img/reports-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary">ออกรายงาน</button></center></a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
