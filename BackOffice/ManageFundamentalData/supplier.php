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
        <title>Supplier - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/scrollBar.css" rel="stylesheet" type="text/css">
        <script src="../js/supplier.js"></script>
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
            <h2>SUPPLIER</h2><hr>
            <div class="scrollBar" id="show-supplier">

            </div>
        </div>      
        <div class="container">
            <div class="row">
                <!-- Add Supplier -->
                <div class="col-sm-6">
                    <h4>Add Supplier:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="sup_name" name="sup_name" maxlength="50">
                                    <span id="errorSupName1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Address:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="sup_address" name="sup_address" maxlength="200"></textarea>
                                    <span id="errorSupAddress1"></span>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email:</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="sup_email" name="sup_email" maxlength="50" placeholder="ex. supplier@cdsport.com">
                                    <span id="errorSupEmail1"></span>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tel:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="sup_tel" name="sup_tel" maxlength="10">
                                    <span style="color: grey;">ex. 02XXXXXXX หรือ 08XXXXXXXX</span><br>
                                    <span id="errorSupTel1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="sup_status" name="sup_status">
                                        <option value="Enabled">Enabled</option>
                                        <option value="Disabled">Disabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-default" id="add-supplier">
                                        <span class="glyphicon glyphicon-plus"></span> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--Edit Supplier-->
                <div class="col-sm-6">
                    <h4 id="to-edit">Edit Supplier:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">ID:</label>
                                <div class="col-sm-5">
                                    <!--Supplier ID-->
                                    <input type="text" class="form-control" id="sup_id_edit" name="sup_id" maxlength="6" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="sup_name_edit" name="sup_name" maxlength="50">
                                    <span id="errorSupName2"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Address:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="sup_address_edit" name="sup_address" maxlength="200"></textarea>
                                    <span id="errorSupAddress2"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email:</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="sup_email_edit" name="sup_email" maxlength="50" placeholder="ex. supplier@cdsport.com">
                                    <span id="errorSupEmail2"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tel:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="sup_tel_edit" name="sup_tel" maxlength="10">
                                    <span style="color: grey;">ex. 02XXXXXXX หรือ 08XXXXXXXX</span><br>
                                    <span id="errorSupTel2"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="sup_status_edit" name="sup_status">
                                        <option>Enabled</option>
                                        <option>Disabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-success" id="edit-supplier">
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
            function editSupplier(sup_id) {
                $("#sup_name_edit").removeAttr("style");
                $("#sup_address_edit").removeAttr("style");
                $("#sup_email_edit").removeAttr("style");
                $("#sup_tel_edit").removeAttr("style");
                $.post("../php/supplier_mng.php?operation=show_edit", {
                    "sup_id": sup_id
                }, function(data) {
                    $("#sup_id_edit").val(data.sup_id);
                    $("#sup_name_edit").val(data.sup_name);
                    $("#sup_address_edit").val(data.sup_address);
                    $("#sup_email_edit").val(data.sup_email);
                    $("#sup_tel_edit").val(data.sup_tel);
                    $("#sup_status_edit").val(data.sup_status);
                }
                , "json");
            }
            function deleteSupplier(sup_id) {
                var con = confirm("ยืนยันการลบข้อมูล");
                if (con === true) {
                    $.post("../php/supplier_mng.php?operation=delete", {
                        "sup_id": sup_id
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
