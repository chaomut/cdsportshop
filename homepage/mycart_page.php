<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();
require '../cancel_sale.php';
if (!isset($_SESSION['member_id'])) {
    header("Refresh:0;url=index.php");
    exit();
} else {
    require './php/myCart.php';
}
?>
?>
<html>
    <head>
        <title> Cart </title>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="15">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/css_page.css" rel="stylesheet" type="text/css">
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <ul class="nav nav-tabs">
                    <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> HOME </a></li>
                    <li><a href="profile_page.php"><span class="glyphicon glyphicon-lock"></span> Profile</a></li>
                    <li><a href="payment_page.php"><span class="glyphicon glyphicon-credit-card"></span> Payment</a></li>
                    <li><a href="history_page.php"><span class="glyphicon glyphicon-user"></span> History</a></li>
                    <ul class="nav navbar-nav navbar-right">
                        <div id='logout' class="nav nav-tabs">
                            <?php echo $show_login ?>
                        </div>
                    </ul>
                </ul>
            </div>
        </nav>

        <br><br>  <br><br>  
        <div class='container'>
            <?php echo $html_for_cart; ?>
        </div>
    </body>
    <script>
        getProducts();
        function  add_Cart_amount(product_id, object) {
            if (parseInt(object.value) > parseInt(object.max)) {
                alert("สินค้ามีเพียง : " + parseInt(object.max)) + " ชิ้น";
                object.value = (parseInt(object.max));
            } else if (parseInt(object.value) === 0) {
                object.value = 1;
            }
            var amount_cart = $("#amount" + product_id);
            var json = JSON.stringify(
                    {
                        "product_id": product_id,
                        "amount": amount_cart.val()
                    }
            );
            $.post("./php/cart_manage.php?operation=addAmount", {
                "product": json
            }, function (data) {

            }, "json");
            location.reload();

        }
        function checkAmount(errortel, textbox) {
            if (event.which > 31 && event.which < 48 || event.which > 57) {
                event.preventDefault();
            }
        }
        function remove_Cart(product_id) {

            var json = JSON.stringify(
                    {
                        "product_id": product_id
                    }
            );
            $.post("./php/cart_manage.php?operation=delete", {
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
                $.each(data, function (product_id, value) {
                    // ถ้ามันส่งค่ามาอะเชา มันจะเป็นแบบ JSON string
                    // มันเลยเรียก value.product_id ไม่ได้ อ่อ เลยต้องมาทำให้เป็น obj ใช่ๆ ต้องเอามาทำให้เป็น json object
                    //var jsonObj = JSON.parse(value); // JSON string -> JSON Object
                    // พอแปลงเสร็จแล้ว เราสามารถเรียกใช้ property ได้แล้ว เช่น jsonObj.product_id
                    // พอเข้าใจมะเชา พอเข้าใจละ 
                    //alert(jsonObj.product_id);
                    // $("#test").append(jsonObj.product_id +  " : "+ jsonObj.amount + "<br>");
                    count++;
                });
                if (count <= 0) {
                    $("#cart_badge").removeClass("badge");
                } else {
                    $("#cart_badge").addClass("badge");

                    $("#cart_badge").text(count);
                }
            }, "json");
        }

    </script>

</html>
