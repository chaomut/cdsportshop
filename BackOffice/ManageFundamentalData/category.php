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
        <title>Category - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/scrollBar.css" rel="stylesheet" type="text/css">
        <script src="../js/category.js"></script>

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
            <h2>CATEGORY</h2><hr>
            <div class="scrollBar" id="show-category" >

            </div>
        </div>      
        <div class="container">
            <div class="row">
                <!-- panel preview -->
                <div class="col-sm-6">
                    <h4>Add Category:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="cate_name" name="cate_name" maxlength="50">
                                    <span id="errorCateName1"></span>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="cate_status" name="cate_status">
                                        <option value="Enabled">Enabled</option>
                                        <option value="Disabled">Disabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-default" id="add-category">
                                        <span class="glyphicon glyphicon-plus"></span> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <h4 id="to-edit">Edit Category:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">ID:</label>
                                <div class="col-sm-5">
                                    <!--Category ID -->
                                    <input type="text" class="form-control" id="cate_id_edit" name="cate_id" maxlength="6" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="cate_name_edit" name="cate_name" maxlength="50">
                                    <span id="errorCateName2"></span>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="cate_status_edit" name="cate_status">
                                        <option>Enabled</option>
                                        <option>Disabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-success" id="edit-category">
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
            function editCategory(cate_id) {
                $("#cate_name_edit").removeAttr("style");
                $.post("../php/category_mng.php?operation=show_edit", {
                    "cate_id": cate_id
                }, function (data) {
                    $("#cate_id_edit").val(data.category_id);
                    $("#cate_name_edit").val(data.category_name);
                    $("#cate_status_edit").val(data.category_status);
                }
                , "json");
            }
            function deleteCategory(cate_id) {
                var con = confirm("ยืนยันการลบข้อมูล");
                if (con === true) {
                    $.post("../php/category_mng.php?operation=delete", {
                        "cate_id": cate_id
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
