<?php
require '../../cancel_sale.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: ../login_back.php");
    exit();
}
$admin_id = ($_SESSION['admin_id']);
?>
<html>
    <head>
        <title>Admin - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <link href="../css/scrollBar.css" rel="stylesheet" type="text/css">
        <script src="../js/admin_mng.js"></script>

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
            <h2>ADMIN</h2><hr>
            <div class="scrollBar" id="show-admin">

            </div>   
        </div>
        <div class="container"> 
            <div class="row">
                <!-- panel preview -->
                <?php if ($admin_id == '000001') { ?>
                    <div class="col-sm-6" id="show-add-admin">
                        <h4 id="to-edit">Add Admin:</h4>
                        <div class="panel panel-default">
                            <div class="panel-body form-horizontal">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">First Name:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="admin_fname" name="admin_fname" maxlength="50">
                                        <span id="errorAdminFname1"></span>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Last Name:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="admin_lname" name="admin_lname" maxlength="50">
                                        <span id="errorAdminLname1"></span>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Tel:</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="admin_tel" name="admin_tel" maxlength="10">
                                        <span style="color: grey;">ex. 02XXXXXXX หรือ 08XXXXXXXX</span><br>
                                        <span id="errorAdminTel1"></span>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Email:</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="admin_email" name="admin_email" maxlength="50" placeholder="ex. admin@cdsport.com">
                                        <span id="errorAdminEmail1"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Password:</label>

                                    <div class="col-sm-7">
                                        <input type="password" class="form-control" id="admin_pass" name="admin_pass" maxlength="24">
                                        <span style="color: grey;">กรอกรหัสผ่าน 8-24 ตัว (A-Z,a-z,0-9, @#[])</span><br>
                                        <span id="errorAdminPass"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Re Password:</label>

                                    <div class="col-sm-7">
                                        <input type="password" class="form-control" id="admin_repass" name="admin_repass" maxlength="24">
                                        <span id="errorAdminRePass"></span>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="col-sm-12 text-right">
                                        <button type="button" class="btn btn-default" id="add-admin">
                                            <span class="glyphicon glyphicon-plus"></span> add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-----------------Edit------------------------->
                    <div class="col-sm-6" id="show-edit-admin">
                        <h4 id="to-edit">Edit Admin:</h4>
                        <div class="panel panel-default">
                            <div class="panel-body form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">ID:</label>
                                    <div class="col-sm-5">
                                        <!--Brand ID -->
                                        <input type="text" class="form-control" id="admin_id_edit" name="admin_id" maxlength="6" readonly>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">First Name:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="admin_fname_edit" name="admin_fname" maxlength="50">
                                        <span id="errorAdminFname2"></span>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Last Name:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="admin_lname_edit" name="admin_lname" maxlength="50">
                                        <span id="errorAdminLname2"></span>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Tel:</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="admin_tel_edit" name="admin_tel" maxlength="10">
                                        <span style="color: grey;">ex. 02XXXXXXX หรือ 08XXXXXXXX</span><br>
                                        <span id="errorAdminTel2"></span>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Email:</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" id="admin_email_edit" name="admin_email" maxlength="50" readonly>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <div class="col-sm-12 text-right">
                                        <button type="button" class="btn btn-success" id="edit-admin">
                                            <span class="glyphicon glyphicon-ok"></span> Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <script>
            function editAdmin(admin_id) {
                $("#admin_fname_edit").removeAttr("style");
                $("#admin_lname_edit").removeAttr("style");
                $("#admin_tel_edit").removeAttr("style");
                $("#admin_email_edit").removeAttr("style");
                $.post("../php/admin_mng.php?operation=show_edit", {
                    "admin_id": admin_id
                }, function(data) {
                    $("#admin_id_edit").val(data.admin_id);
                    $("#admin_fname_edit").val(data.admin_fname);
                    $("#admin_lname_edit").val(data.admin_lname);
                    $("#admin_tel_edit").val(data.admin_tel);
                    $("#admin_email_edit").val(data.admin_email);
                }
                , "json");
            }
            function deleteAdmin(admin_id) {
                var con = confirm("ยืนยันการลบข้อมูล");
                if (con === true) {
                    $.post("../php/admin_mng.php?operation=delete", {
                        "admin_id": admin_id
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

