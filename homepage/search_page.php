<?php
error_reporting(E_ALL ^ E_WARNING);
require '../cancel_sale.php';
session_start();
require './php/m_checklogin.php';
require './php/select_product_search.php';
require './php/select_type_search.php';
?>
<html>
    <head>
        <title> Search </title>
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
                    <ul class="nav navbar-default navbar-right "> 
                        <?php echo $show_login; ?>
                    </ul>
                </ul>
            </div>
        </nav>
        <img class="img-header" src="../img/header.jpg"> <br><br>  
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-2">
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
            </div><br>
            <div class="col-sm-9">
                <div class="panel panel-info">
                    <div class="panel-heading">Search</div>
                    <div class="panel-body"> 
                        <?php echo $html_search ?>
                    </div>
                </div>

                <div class="features_items">
                    <h2 id='text-head' class="title text-center">Search</h2>
                    <div class="col-sm-12" id="show-product"> 
                        <!-- Content -->
                        <?php
                        if (isset($_GET['search']) && $_GET['search'] == "search") {
                            echo $html3_for_product;
                        }
                        ?>
                    </div> 
                </div>
            </div>   
        </div>
        <script>
            getProducts();
            var checkid = false;
            $("#id-search").blur(function () {
                var textbox = $("#id-search");
                if (textbox.val().length === 6) {
                    textbox.css('border-color', 'green');
                    checkid = true;
                } else if (textbox.val().length === 0) {
                    textbox.removeAttr('style');
                    checkid = false;
                } else {
                    textbox.css('border-color', 'red');
                    checkid = false;
                }

            });
            $("#id-search").keypress(function () {
                var textbox = $("#id-search");
                if (event.which > 31 && event.which < 48 || event.which > 57) {
                    event.preventDefault();
                    textbox.css('border-color', 'red');
                } else {
                    textbox.removeAttr('style');

                }
            });
            function search(page) {
                if (page === undefined) {
                    page = 1;
                }
                var name = $("#name_search");
                var id = $("#id-search");
                var model_id = $("#model-search");
                var brand_id = $("#brand-search");
                var category_id = $("#category-search");
                var price = $("#price_search");
                var url = "./php/select_product_search.php?search=advn&page=" + page;
                var rows = document.getElementsByName('color-search[]');
                var selectedColor = [];
                for (var i = 0, l = rows.length; i < l; i++) {
                    if (rows[i].checked) {
                        selectedColor.push(rows[i].value);
                    }
                }
                if (model_id.val() !== "#"
                        || brand_id.val() !== "#"
                        || category_id.val() !== "#"
                        || price.val() !== "#"
                        || selectedColor.length > 0
                        || name.val() !== ""
                        || id.val() !== "") {
                    if (model_id.val() !== "#") {
                        url = url + "&model=" + model_id.val();
                    }
                    if (price.val() !== "#") {
                        url = url + "&price=" + price.val();
                    }
                    if (brand_id.val() !== "#") {
                        url = url + "&brand=" + brand_id.val();
                    }
                    if (category_id.val() !== "#") {
                        url = url + "&category=" + category_id.val();
                    }
                    if (selectedColor.length !== 0) {
                        url = url + "&color=" + selectedColor;
                    }
                    if (name.val() !== "") {
                        url = url + "&name=" + name.val();
                    }
                    if (id.val() !== "") {
                        if (checkid === true) {
                            url = url + "&id=" + id.val();
                        } else {
                            alert("กรอกข้อมูลไม่ถูกต้อง");
                            id.focus();

                        }
                    }

                    $("#show-product").load(url);

                } else {
                    alert("กรุณาเลือกที่ต้องการค้นหา");
                }
            }

            function addCart(product, value) {
                var json = JSON.stringify(
                        {
                            "product_id": product,
                            "price": value,
                            "amount": 1
                        }
                );
                $.post("./php/cart_manage.php?operation=add", {
                    "product": json
                }, function (data) {

                }, "json");
                location.reload();
            }
            function getProducts() {
                var count = 0;
                $("#show_cart").empty();
                $.post("./php/cart_manage.php?operation=show", {
                }, function (data) {

                    $.each(data, function (index, value) {
                        // ถ้ามันส่งค่ามาอะเชา มันจะเป็นแบบ JSON string
                        // มันเลยเรียก value.product_id ไม่ได้ อ่อ เลยต้องมาทำให้เป็น obj ใช่ๆ ต้องเอามาทำให้เป็น json object
                        var jsonObj = JSON.parse(value); // JSON string -> JSON Object
                        // พอแปลงเสร็จแล้ว เราสามารถเรียกใช้ property ได้แล้ว เช่น jsonObj.product_id
                        // พอเข้าใจมะเชา พอเข้าใจละ 
                        count += 1;
                        $("#show_cart").append((index + 1) + ". " + jsonObj.product_id + ":" + jsonObj.amount + "<br>");
                    });
                    if (count <= 0) {
                        $("#cart_badge").removeClass("badge");
                    } else {
                        $("#cart_badge").addClass("badge");
                        $("#cart_badge").text(count);
                    }
                }, "json");
            }
            function selectModel() {
                var brand = document.getElementById('brand-search').value;
                $.post('./php/select_type_search.php?select_model', {
                    "brand": brand
                }, function (data) {
                    $("#model-search").removeAttr('disabled');
                    $("#model-search").html(data);
                }, 'json');
            }



        </script>

    </body>
</html>


