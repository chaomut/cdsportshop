
<html>
    <head>
        <title>Forgot your password - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <link href="../css/scrollBar.css" rel="stylesheet" type="text/css">
        <script src="../js/forgot_password.js"></script>

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
            <h2>FORGOT PASSWORD?</h2><hr>

        </div>
        <div class="container"> 
            <div class="row">
                <!-- panel preview -->
                <div class="col-sm-6">
                    <h4>New Password:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="admin_email" name="admin_email" maxlength="50" placeholder="ex. admin@cdsport.com">
                                    <span id="errorAdminEmail1"></span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tel:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="admin_tel" name="admin_tel" maxlength="10">
                                    
                                    <span id="errorAdminTel1"></span>
                                </div>
                            </div> 

                            <div class="form-group">
                                <label class="col-sm-3 control-label">New Password:</label>

                                <div class="col-sm-7">
                                    <input type="password" class="form-control" id="admin_pass" name="admin_pass" maxlength="24">
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
                                    <button type="button" class="btn btn-success" id="save-new-password">
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

