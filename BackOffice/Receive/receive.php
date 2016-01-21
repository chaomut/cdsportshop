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
        <title>Receive - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/scrollBar.css" rel="stylesheet" type="text/css">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/receive.js"></script>
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
            <h2>RECEIVE DETAIL</h2><hr>
            <div class="scrollBar" id="show-receive">

            </div>
        </div>
  
            <div class="container">
                <div class="row">
                    <!-- panel preview -->
                    <div class="col-sm-6">
                        <h4>Receive Order:</h4>
                        <div class="panel panel-default">
                            <div class="panel-body form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Purchase ID:</label>
                                    <div class="col-sm-9" id="select-pur">
                                        
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">InvoiceNo:</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="invoiceNo" name="invoiceNo" maxlength="13">
                                        <span id="errorInvoice"></span>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-12 text-center">
                                        <button type="button" class="btn btn-primary" id="save-changes-receive">
                                            <span class="glyphicon glyphicon-inbox"></span> Receive
                                        </button>
                                    </div>
                                </div>
                                <!--admin-->
                                <input type="text" id="admin_id" value="<?php echo $admin_id; ?>" hidden>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>
</html>
