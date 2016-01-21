<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();
require '../cancel_sale.php';
require './php/m_checklogin.php';
require './php/select_type_search.php';
require './php/select_product_recom.php';
require './php/select_product_top3.php';
require './php/select_product_new.php';
?>
<html>
    <head>
        <title> HOME </title>
        <meta charset="UTF-8">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/css_page.css" rel="stylesheet" type="text/css">
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span> HOME</a></li>
                    <ul class="nav navbar-default navbar-right "> 
                        <?php echo $show_login; ?>
                    </ul>
                </ul>
            </div>
        </nav>
        <img class="img-header" src="../img/header.jpg"> <br><br>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-3">
                <div class='input-group'>
                    <input id="name-search" type='search' class='form-control' placeholder='Search'>
                    <span class='input-group-addon btn' onclick="search();"><i class='glyphicon glyphicon-search'></i></span>
                </div>
                <a href="search_page.php"><p class="text-right"> Advance Search</p></a>
                <div class="left-sidebar text-uppercase">
                    <div class="brands_products"><!--brands_products-->
                        <!-- Css_page >> h2.new -->
                        <h2 class="new">
                            - Brands -
                        </h2>
                        <div class="brands-name">
                            <ul id="show-brand" class="nav">
                                <?php echo $html1_for_brand; ?>
                            </ul>
                        </div>
                    </div>
                </div> <br>
                <div class="left-sidebar text-uppercase">
                    <div class="brands_products"><!--brands_products-->
                        <h2 class="new">
                            - Category -
                        </h2>
                        <div class="category-name">
                            <ul id="show-category" class="nav">
                                <?php echo $html2_for_category; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-sm-9">
                <ul class="nav nav-tabs" role="tablist">
                    <li id='li-product_all' class="active"><a data-toggle="collapse" onclick="$('#product_new').collapse('hide');
                            $('#product_top').collapse('hide');
                            $('#li-product_all').addClass('active');
                            $('#li-product_top').removeClass('active');"
                                                              data-target="#product_all"><h5><span class="glyphicon glyphicon-tag text-success"></span> Product</h5></a></li>

                    <li id='li-product_top'><a data-toggle="collapse" onclick="$('#product_new').collapse('hide');
                            $('#product_all').collapse('hide');
                            $('#li-product_top').addClass('active');
                            $('#li-product_all').removeClass('active');"
                                               data-target="#product_top"><h5><span class="glyphicon glyphicon-thumbs-up text-danger"></span> HOT Product</h5></a></li> 
                </ul>
                <div id="product_top" class="collapse">
                    <h2 id="text-head" class="text-center">สินค้าขายดี</h2>
                    <div class="col-md-12" id="show-product" > 
                        <?php echo $html4_for_top_sale ?>
                    </div> 
                </div>
                <div id="product_all" class="collapse in">
                    <h2 id="text-head" class="text-center">สินค้ามาใหม่ประจำเดือน</h2>
                    <div class="col-md-12" id="show-product" > 
                        <?php echo $html5_for_new_product ?>
                    </div>
                    <h2 id="text-head" class="text-center">สินค้าแนะนำ</h2>
                    <div class="col-md-12" id="show-product" > 
                        <?php echo $html3_for_product ?>
                    </div> 
                </div>
            </div>
        </div>

        <script>
            getProducts();
            function search() {
                var name = $("#name-search");
                var url = "search_page.php?search=search";
                if (name.val() !== "") {
                    if (name.val() !== "") {
                        url = url + "&name=" + name.val();
                    }
                    window.location.href = url;
                } else {
                    alert("กรุณา ! กรอกคำค้นหา");
                }
            }
            function addCart(product) {
                var json = JSON.stringify(
                        {
                            "product_id": product,
                            "amount": 1
                        }
                );
                $.post("./php/cart_manage.php?operation=add", {
                    "product": json
                }, function (data) {
                    if (data.msg === true) {
                        alert("สินค้าอยู่ในตะกร้าแล้ว !");
                    }
                }, "json");
                location.reload();
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
