<?php
require '../../cancel_sale.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: ../login_back.php");
    exit();
}
?>
<html>
    <head>
        <title>Promotion - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/scrollBar.css" rel="stylesheet" type="text/css">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/promotion.js"></script> 
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
                    <br><a href="../manage_submenu.php"><button type="button" class="btn btn-info" id="back-to-menu">
                            <span class="glyphicon glyphicon-arrow-left"></span> Back to menu
                        </button></a>
                </div>
            </div>
        </div> 
        <div class="container"> 
            <h2>PROMOTION</h2><hr>
            <div class="scrollBar" id="show-promotion">

            </div>
        </div>      
        <div class="container">
            <div class="row">
                <!-- Add Promotion -->
                <div class="col-sm-6">
                    <h4>Add Promotion:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="pro_name" name="pro_name" maxlength="30">
                                    <span id="errorProName1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Detail:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="pro_detail" name="pro_detail" maxlength="200"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Start Date:</label>
                                <div class="col-sm-7">
                                    <input type="datetime-local" class="form-control" id="start_date" name="start_date">
                                    <span id="errorStart1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">End Date:</label>
                                <div class="col-sm-7">
                                    <input type="datetime-local" class="form-control" id="end_date" name="end_date">
                                    <span id="errorEnd1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Discount:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="discount" name="discount" maxlength="2">
                                    <span id="errorProDiscount1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-default" id="add-promotion">
                                        <span class="glyphicon glyphicon-plus"></span> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--Edit Promotion-->
                <div class="col-sm-6">
                    <h4 id="to-edit">Edit Promotion:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">ID:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="pro_id_edit" name="pro_id" maxlength="6" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="pro_name_edit" name="pro_name" maxlength="50">
                                    <span id="errorProName2"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Detail:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="pro_detail_edit" name="pro_detail" maxlength="200"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Start Date:</label>
                                <div class="col-sm-7">
                                    <input type="datetime-local" class="form-control" id="start_date_edit" name="start_date">
                                    <span id="errorStart2"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">End Date:</label>
                                <div class="col-sm-7">
                                    <input type="datetime-local" class="form-control" id="end_date_edit" name="end_date">
                                    <span id="errorEnd2"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Discount:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="discount_edit" name="discount" maxlength="2">
                                    <span id="errorProDiscount2"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-success" id="edit-promotion">
                                        <span class="glyphicon glyphicon-ok"></span> Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function editPromotion(pro_id) {
                $("#pro_name_edit").removeAttr("style");
                $("#pro_detail_edit").removeAttr("style");
                $("#start_date_edit").removeAttr("style");
                $("#end_date_edit").removeAttr("style");
                $("#discount_edit").removeAttr("style");
                $.post("../php/promotion_mng.php?operation=show_edit", {
                    "pro_id": pro_id
                }, function(data) {
                    $("#pro_id_edit").val(data.pro_id);
                    $("#pro_name_edit").val(data.pro_name);
                    $("#pro_detail_edit").val(data.pro_detail);
                    $("#start_date_edit").val(data.start_date);
                    $("#end_date_edit").val(data.end_date);
                    $("#discount_edit").val(data.discount);
                }
                , "json");
            }
            
            function deletePromotion(pro_id) {
                var con = confirm("ยืนยันการลบข้อมูล");
                if (con === true) {
                    $.post("../php/promotion_mng.php?operation=delete", {
                        "pro_id": pro_id
                    }, function(data) {
                        if (data.status === true) {
                            location.reload();
                        } else {
                            alert("ไม่สามารถลบข้อมูลได้");
                        }
                    }
                    , "json");
                }
            }
        </script>
    </body>
</html>
