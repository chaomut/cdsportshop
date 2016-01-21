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
        <title>Product - Back Office</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/scrollBar.css" rel="stylesheet" type="text/css">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/product.js"></script>
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
        <div class="container" >        
            <h2>PRODUCT</h2><hr>
            <div class="scrollBar" id="show-product">

            </div>
        </div>      
        <div class="container">
            <div class="row">
                <!-- Add Product-->
                <div class="col-sm-6">
                    <h4>Add Product:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Category List:</label>
                                <div class="col-sm-9" id="select-cate1">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Model List:</label>
                                <div class="col-sm-9" id="select-model1">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="product_name" name="product_name" maxlength="50">
                                    <span id="errorProductName1"></span>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Detail:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="product_detail" name="product_detail" maxlength="200"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Color:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="product_color" name="product_color">
                                        <option value="red">Red</option>
                                        <option value="green">Green</option>
                                        <option value="blue">Blue</option>
                                        <option value="yellow">Yellow</option>
                                        <option value="black">Black</option>
                                        <option value="white">White</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Price:</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="product_price" name="product_price" min = "1" max="10000000000" onchange="checkFormat(this)">
                                    <span id="errorPrice1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Amount:</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="product_amount" name="product_amount" min = "1" max="999" onchange="checkFormat(this)" onkeypress="checkNumber()">
                                    <span id="errorAmount1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Reorder Point:</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="reorder_point" name="reorder_point" min = "1" max="999" onchange="checkFormat(this)" onkeypress="checkNumber()">
                                    <span id="errorReorder1"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="product_status" name="product_status">
                                        <option value="Enabled">Enabled</option>
                                        <option value="Disabled">Disabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-default" id="add-product" data-toggle="collapse" data-target="#upload-pic">
                                        <span class="glyphicon glyphicon-plus"></span> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Edit Product-->
                <div class="col-sm-6">
                    <h4 id="to-edit">Edit Product:</h4>
                    <div class="panel panel-default">
                        <div class="panel-body form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">ID:</label>
                                <div class="col-sm-5">
                                    <!--Product ID -->
                                    <input type="text" class="form-control" id="product_id_edit" name="product_id" maxlength="6" readonly>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Category List:</label>
                                <div class="col-sm-9" id="select-cate2">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Model List:</label>
                                <div class="col-sm-9" id="select-model2">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="product_name_edit" name="product_name" maxlength="50">
                                    <span id="errorProductName2"></span>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Detail:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="product_detail_edit" name="product_detail" maxlength="200"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Picture:</label>
                                <div class="col-sm-9">
                                    <img id="product_pic_edit" width="150px" height="150px"><br><br>

                                    <button type="button" class="btn btn-info" id="edit-pic">
                                        <span class="glyphicon glyphicon-edit"></span> Edit Picture
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Color:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="product_color_edit" name="product_color">
                                        <option value="red">Red</option>
                                        <option value="green">Green</option>
                                        <option value="blue">Blue</option>
                                        <option value="yellow">Yellow</option>
                                        <option value="black">Black</option>
                                        <option value="white">White</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Price:</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="product_price_edit" name="product_price" min = "1" max="10000000000" onchange="checkFormat(this)">
                                    <span id="errorPrice2"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Amount:</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="product_amount_edit" name="product_amount" min = "1" max="999" onchange="checkFormat(this)" onkeypress="checkNumber()">
                                    <span id="errorAmount2"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Reorder Point:</label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" id="reorder_point_edit" name="reorder_point" min = "1" max="999" onchange="checkFormat(this)" onkeypress="checkNumber()">
                                    <span id="errorReorder2"></span>
                                </div>   
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="product_status_edit" name="product_status">
                                        <option>Enabled</option>
                                        <option>Disabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 text-right">
                                    <button type="button" class="btn btn-success" id="edit-product">
                                        <span class="glyphicon glyphicon-ok"></span> Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function editProduct(product_id) {
                $("#product_name_edit").removeAttr("style");
                $.post("../php/product_mng.php?operation=show_edit", {
                    "product_id": product_id
                }, function(data) {
                    $("#product_id_edit").val(data.product_id);
                    $("#cate_list_edit").val(data.category_id);
                    $("#model_list_edit").val(data.model_id);
                    $("#product_name_edit").val(data.product_name);
                    $("#product_detail_edit").val(data.product_detail);
                    $("#product_color_edit").val(data.color);
                    $("#product_price_edit").val(data.price);
                    $("#product_amount_edit").val(data.amount);
                    $("#reorder_point_edit").val(data.reorder_point);
                    $("#product_status_edit").val(data.product_status);
                    $("#product_pic_edit").attr('src', '../../img/' + data.pic);
                }
                , "json");
            }
            function deleteProduct(product_id) {
                var con = confirm("ยืนยันการลบข้อมูล");
                if (con === true) {
                    $.post("../php/product_mng.php?operation=delete", {
                        "product_id": product_id
                    }, function(data) {
                        if (data.status === true) {
                            location.reload();
                        } else {
                            alert("ไม่สามารถลบข้อมูลได้");
                        }
                    }
                    , "json");
                }
            }
            
            function checkFormat(number){
                if (parseInt(number.value) > parseInt(number.max)) {
                    number.value = number.max;
                } else if (parseInt(number.value) < parseInt(number.min)) {
                    number.value = number.min;
                }        
            }
            
            function checkNumber() {
                if (event.which < 48 || event.which > 57) {
                    event.preventDefault();
                }
            }
        </script>
    </body>
</html>
