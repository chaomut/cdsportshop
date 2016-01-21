<?php
session_start();
require '../cancel_sale.php';
if (!isset($_SESSION['admin_id'])) {
    header("location: login_back.php");
    exit();
}
?>
<html>
    <head>
        <title>จัดการข้อมูลพื้นฐาน - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="js/jquery-2.1.4.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="css/menu_back.css" rel="stylesheet" type="text/css">
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
            <h2>FUNDAMENTAL DATA</h2><hr>
            <div class="row">
                <div class="col-sm-3" id="sub-menu">
                    <div class="thumbnail">
                        <a href="ManageFundamentalData/category.php"><img class="icon-menu" src="../img/Files-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary">ข้อมูลประเภท</button></center></a>
                    </div>
                </div>
                <div class="col-sm-3" id="sub-menu">
                    <div class="thumbnail">
                        <a href="ManageFundamentalData/brand.php"><img class="icon-menu" src="../img/Files-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary">ข้อมูลยี่ห้อ</button></center></a>
                    </div>
                </div>
                <div class="col-sm-3" id="sub-menu">
                    <div class="thumbnail">
                        <a href="ManageFundamentalData/model.php"><img class="icon-menu" src="../img/Files-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary">ข้อมูลรุ่น</button></center></a>
                    </div>
                </div>
                <div class="col-sm-3" id="sub-menu">
                    <div class="thumbnail">
                        <a href="ManageFundamentalData/product.php"><img class="icon-menu" src="../img/Files-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary">ข้อมูลอุปกรณ์กีฬา</button></center></a>
                    </div>
                </div>
                <div class="col-sm-3" id="sub-menu">
                    <div class="thumbnail">
                        <a href="ManageFundamentalData/promotion.php"><img class="icon-menu" src="../img/Files-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary">ข้อมูลโปรโมชัน</button></center></a>
                    </div>
                </div>
                <div class="col-sm-3" id="sub-menu">
                    <div class="thumbnail">
                        <a href="ManageFundamentalData/supplier.php"><img class="icon-menu" src="../img/supplier-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary">ข้อมูลบริษัทตัวแทนจำหน่าย</button></center></a>
                    </div>
                </div>
                <div class="col-sm-3" id="sub-menu">
                    <div class="thumbnail">
                        <a href="ManageFundamentalData/admin.php"><img class="icon-menu" src="../img/administrator-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary">ผู้ดูแลระบบ</button></center></a>
                    </div>
                </div>
                <div class="col-sm-3" id="sub-menu">
                    <div class="thumbnail">
                        <a href="ManageFundamentalData/member.php"><img class="icon-menu" src="../img/member-icon.png"><br>
                            <center><button type="submit" class="btn btn-primary">สมาชิก</button></center></a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
