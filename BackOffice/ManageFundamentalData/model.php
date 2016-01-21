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
        <title>Model - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="../js/model.js"></script>
        <link href="../css/scrollBar.css" rel="stylesheet" type="text/css">

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
            <h2>MODEL</h2><hr>
            <div id="show-model" class="scrollBar">

            </div>
        </div>      
        <div class="container">
            <div class="row">
                <!-- panel preview -->
                <div class="col-sm-6">
                    <h4>Add Model:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Brand List:</label>
                                <div class="col-sm-5" id="select-brand">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="model_name" name="model_name" maxlength="50">
                                    <span id="errorModelName1"></span>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="model_status" name="model_status">
                                        <option value="Enabled">Enabled</option>
                                        <option value="Disabled">Disabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-default" id="add-model">
                                        <span class="glyphicon glyphicon-plus"></span> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h4 id="to-edit">Edit Model:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">ID:</label>
                                <div class="col-sm-5">
                                    <!--Category ID -->
                                    <input type="text" class="form-control" id="model_id_edit" name="model_id" maxlength="6" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Brand:</label>
                                <div class="col-sm-5" id="select-brand-edit">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="model_name_edit" name="model_name" maxlength="50">
                                    <span id="errorModelName2"></span>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="model_status_edit" name="model_status">
                                        <option>Enabled</option>
                                        <option>Disabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-success" id="edit-model">
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
            function editModel(model_id) {
                $("#model_name_edit").removeAttr("style");
                $.post("../php/model_mng.php?operation=show_edit", {
                    "model_id": model_id
                }, function (data) {
                    $("#model_id_edit").val(data.model_id);
                    $("#brand_list_edit").val(data.brand_id);
                    $("#model_name_edit").val(data.model_name);
                    $("#model_status_edit").val(data.model_status);
                }
                , "json");
            }
            function deleteModel(model_id) {
                var con = confirm("ยืนยันการลบข้อมูล");
                if (con === true) {
                    $.post("../php/model_mng.php?operation=delete", {
                        "model_id": model_id
                    }, function (data) {
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
