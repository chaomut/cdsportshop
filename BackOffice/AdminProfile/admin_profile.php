<?php
require '../../cancel_sale.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: ../login_back.php");
    exit();
}
$admin_id = $_SESSION['admin_id'];
if (isset($admin_id)) {
    require '../php/connect.php';
    $sql = "SELECT * FROM admin WHERE admin_id='$admin_id'";
    $result = mysqli_query($connect, $sql);
    $array = mysqli_fetch_array($result);
    $html1 = '<div class="container">    
            <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
                <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div id="profile" class="panel-title">Admin Profile   </div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px"></div>
                    </div>     
                    <div style="padding-top:30px" class="panel-body" >
                        <form id="profile_form" class="form-horizontal" role="form" method="POST">

                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input readonly id="admin_id" type="text" class="form-control" value=' . $array['admin_id'] . '>
                                    
                            </div>
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input readonly id="admin_email" type="text" class="form-control" value="' . $array['admin_email'] . '">                                        
                            </div>
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
                                <input readonly id="admin_tel" type="tel" class="form-control"  value="' . $array['admin_tel'] . '" maxlength="10">
                                <span id="errorAdminTel1"></span>
                            </div>
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input readonly id="admin_fname" type="text" class="form-control" value="' . $array['admin_fname'] . '" maxlength="50">
                                <span id="errorAdminFname1"></span>
                            </div>
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input readonly id="admin_lname" type="text" class="form-control" value="' . $array['admin_lname'] . '" maxlength="50">
                                <span id="errorAdminLname1"></span>    
                            </div>
               
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock" ></i></span>
                                <input id="admin_pass" type="password" class="form-control" placeholder="Password" > 
                                <span id="errorAdminPass"></span>
                            </div>
                            <div style="margin-top:10px" class="form-group ">
                                <div class="col-sm-12 controls ">
                                    <button id="edit-profile" type="button" class="btn btn-default">
                                    <span class="glyphicon glyphicon-edit"></span> Edit
                                    </button>
                                    <button id="update-profile" type="button" class="btn btn-success">
                                    <span class="glyphicon glyphicon-ok"></span> Submit
                                    </button>    
                                </div>
                            </div>
                        </form>    
                    </div>                     
                </div>  
            </div>
        </div>';
}
?>
<html>
    <head>
        <title>Admin Profile</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/admin_profile.js"></script>
    </head>
    <body>
        <header class="headertop">
            <span class="navbar-brand">C&D</span>
            <ul class="nav nav-tabs">
                <li><a href="../mainmenu_back.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                <li><a href="admin_profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
                <li><a href="../php/logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
            </ul>
        </header>
        <div class="container" id="show-admissn">        

        </div>
        <?php
        if (isset($html1)) {
            echo $html1;
        }
        ?>

    </body>
</html>