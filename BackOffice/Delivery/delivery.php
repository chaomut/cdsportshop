<?php
require '../../cancel_sale.php';
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: ../login_back.php");
    exit();
}
$admin_id = $_SESSION['admin_id'];
?>
<html>
    <head>
        <title>Delivery - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/scrollBar.css" rel="stylesheet" type="text/css">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/delivery.js"></script>
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
            <h2>DELIVERY</h2><hr>
            <div class="scrollBar" id="show-delivery">

            </div>
        </div> 
        <div class="container">
            <div class="row">
                <!-- panel preview -->
                <div class="col-sm-6">
                    <h4>Delivery:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Sale ID:</label>
                                <div class="col-sm-5" id="select-sale_id">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Delivery Date:</label>
                                <div class="col-sm-7">
                                    <input type="datetime-local" class="form-control" id="delivery_date" name="delivery_date">
                                    <span id="errorDate"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">EMS ID:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="ems_id" name="ems_id" maxlength="13">
                                    <span id="errorEms"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-success" id="submit-delivery">
                                        <span class="glyphicon glyphicon-ok"></span> Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </body>
</html>
