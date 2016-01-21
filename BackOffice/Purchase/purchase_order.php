<?php
require '../../cancel_sale.php';
require '../php/purchase_order_detail.php';
if (!isset($_SESSION['admin_id'])) {
    header("location: ../login_back.php");
    exit();
}
?>
<html>
    <head>
        <title>Purchase Order - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/scrollBar.css" rel="stylesheet" type="text/css">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/purchase_alert.js"></script>
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
            <h2>PURCHASE ORDER</h2><hr>
            <div class="scrollBar" id="show-product">

            </div>
        </div>

        <div class="container">        
            <div class="row" >
                <!-- panel preview -->
                <div class="col-sm-8" id="show-purchase-order">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-default" id="select-all-product">
                                <span class="glyphicon glyphicon-th-list"></span> All Products
                            </button>
                            <button type="button" class="btn btn-danger" id="select-out-product">
                                <span class="glyphicon glyphicon-th-list"></span> สินค้าเหลือน้อย
                            </button>
                        </div>
                    </div>
                    <br><h4>Purchase Order:</h4>
                    <div class="panel panel-default scrollBar" id="show-purchase-detail">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <?php
                                echo $html1;
                                ?>
                            </div>
                            <div class="form-group">
                                <?php
                                echo $html4;
                                ?>
                                <div class="col-sm-5">
                                    <?php
                                    echo $html2;
                                    ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 text-right">
                                    <?php
                                    echo $html3;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function addPurchase(product_id) {
                var json = JSON.stringify(
                        {
                            "product_id": product_id,
                            "amount": 1,
                            "price": 1
                        }
                );
                $.post("../php/purchase_cart.php?operation=add", {
                    "product_id": json
                }, function(data) {
                    location.reload();
                }
                , "json");


            }

            function updatePurchase(product_id, data) {
                var amount = $("#amount" + product_id);
                var price = $("#price" + product_id);
                
                
                if (parseInt(amount.val()) > 999) {
                    amount.val("999");
                } else if (amount.val() === "0" || amount.val() === "") {
                    amount.val("1");
                }
                else if (price.val() === "0" || price.val() === "") {
                    price.val("1");
                }
                else if (parseInt(price.val()) > 10000000000) {
                    price.val("10000000000");
                }
                var json = JSON.stringify(
                        {
                            "product_id": product_id,
                            "amount": amount.val(),
                            "price": price.val()
                        });
                $.post("../php/purchase_cart.php?operation=edit", {
                    "product_id": json
                }, function(data) {
                    location.reload();
                }
                , "json");

            }

            function delPurchase(product_id) {
                var json = JSON.stringify(
                        {
                            "product_id": product_id
                        }
                );
                $.post("../php/purchase_cart.php?operation=delete", {
                    "product_id": json
                }, function(data) {
                    location.reload();
                }
                , "json");
            }
        </script>
    </body>
</html>
