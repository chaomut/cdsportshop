<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();
require '../cancel_sale.php';
require './php/m_checklogin.php';
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    require './php/select_product_detail.php';
} else {
    $html_for_productDetail = "<div class='row'>
                                    <div class='col-sm-10 col-sm-offset-1'>
                                        <div class='alert alert-warning'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>  &nbsp; ×</button>
                                            <strong>ไม่มีรายการสินค้า :</strong> 
                                        </div>
                                    </div>
                              </div>";
}
?>
<html>
    <head>
        <title> Product Detail </title>
        <meta charset="UTF-8">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/css_page.css" rel="stylesheet" type="text/css">
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <ul class="nav nav-tabs">
                    <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> HOME</a></li>
                    <ul class="nav navbar-default navbar-right">         
                        <?php echo $show_login; ?>
                    </ul>
                </ul>
            </div>
        </nav>
        <br>
        <br> <br>
        <?php echo $html_for_productDetail ?>
        <script>
            getProducts();
            function addCart(product) {
                var amount = $("#amount");
                if (amount.val() !== "0") {
                    var json = JSON.stringify(
                            {
                                "product_id": product,
                                "amount": amount.val()}
                    );
                    $.post("./php/cart_manage.php?operation=add_select", {
                        "product": json
                    }, function (data) {

                    }, "json");
                    location.reload();
                } else {
                    alert("กรุณาเลือกจำนวน");
                }
            }
            function getProducts() {

                $("#show_cart").empty();
                $.post("./php/cart_manage.php?operation=show", {
                }, function (data) {

                    if (data.length <= 0) {
                        $("#cart_badge").removeClass("badge");
                    } else {
                        $("#cart_badge").addClass("badge");
                        $("#cart_badge").text(data.length);
                    }
                }, "json");
            }

        </script>
    </body>
</html>
