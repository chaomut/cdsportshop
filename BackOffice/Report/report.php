<?php
require '../../cancel_sale.php';
require '../php/connect.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: ../login_back.php");
    exit();
}
?>
<html>
    <head>
        <title>Report - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </head>
    <body>
        <header class="headertop">
            <span class="navbar-brand">C&D</span>
            <ul class="nav nav-tabs">
                <li><a href="../mainmenu_back.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                <li><a href="../AdminProfile/admin_profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
                <li><a href="../php/logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
            </ul>
        </header>
        <div class="container">  
            <div class="form-group">
                <div class="text-left">
                    <br><a href="../mainmenu_back.php"><button type="button" class="btn btn-info" id="back-to-menu">
                            <span class="glyphicon glyphicon-arrow-left"></span> Back to menu
                        </button></a>
                </div>
            </div>
        </div>
        <div class="container">
            <h2>REPORT</h2><hr>
            <div class="scrollBar" id="show-report">

            </div>  
            <div class="row">
                <!-- panel preview -->
                <div class="col-sm-6">
                    <h4>Print Report:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body form-horizontal"> 
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Report List:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="report_list" name="report" onchange="selectReport()">
                                        <option></option>
                                        <option value="purchase_report">รายงานการสั่งซื้อสินค้า</option>
                                        <option value="sale_report">รายงานการขายสินค้า</option>
                                        <option value="product_report">รายงานสินค้าคงเหลือ ณ เวลาปัจจุบัน</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Start Date:</label>
                                <div class="col-sm-9" id="select-start">
                                    <input type="datetime-local" class="form-control" id="start_date" name="start_date">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">End Date:</label>
                                <div class="col-sm-9" id="select-end">
                                    <input type="datetime-local" class="form-control" id="end_date" name="end_date">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-11 text-right">
                                    <button type="button" class="btn btn-primary" id="print_report" onclick="printReport()">
                                        <span class="glyphicon glyphicon-print"></span> Print
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <script>
            function printReport() {
                var report = $("#report_list").val();
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();

                if (report === "purchase_report") {
                    popupWindow = window.open(
                            '../php/purchase_report.php?startdate=' + start_date + "&enddate=" + end_date, 'popUpWindow', 'height=600,width=1000');
                } else if (report === "sale_report") {
                    popupWindow = window.open(
                            '../php/sale_report.php?startdate=' + start_date + "&enddate=" + end_date, 'popUpWindow', 'height=600,width=1000');
                } else if (report === "product_report") {
                    popupWindow = window.open(
                            '../php/product_report.php', 'popUpWindow', 'height=600,width=1000');
                }
            }

            function selectReport() {
                var report = $("#report_list").val();
                if (report === "purchase_report" || report === "sale_report") {
                    $("#select-start").show();
                    $("#select-end").show();
                } else {
                    $("#select-start").hide();
                    $("#select-end").hide();
                }
            }
        </script>

    </body>
</html>
