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
        <title>Member - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/scrollBar.css" rel="stylesheet" type="text/css">
        <script src="../js/member.js"></script>
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
            <h2>MEMBER</h2><hr>
            <div class="scrollBar" id="show-member">

            </div>   
        </div>  
    </body>
</html>
