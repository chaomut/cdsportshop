<?php

error_reporting(E_ALL ^ E_WARNING);
//session_start();
require './php/connect.php';
$check_out_stock = true;
$discount = 0;
$count_img = 1;
/////// Promotion
$sql_for_promotion = "SELECT * FROM promotion WHERE DATE(NOW()) >= start_date AND DATE(NOW()) <= end_date";
$result_for_promotion = mysqli_query($connect, $sql_for_promotion);
$array_for_promotion = mysqli_fetch_array($result_for_promotion);
if (mysqli_num_rows($result_for_promotion) > 0) {
    $discount = $array_for_promotion['discount'];
    $promotion_name = $array_for_promotion['pro_name'];
}

/////// END Promotion
// Select รูปภาพสินค้า
$sql1_for_product = "SELECT * FROM product_pic WHERE product_id='{$product_id}'";
$result1_for_product = mysqli_query($connect, $sql1_for_product);
if (mysqli_num_rows($result1_for_product) > 0) {
/////// Html  HTML Ordered Lists ลิสที่มีอันดับ
    $html_for_productDetail = "<div class='container'>
            <h2 class='title text-center'> Product Detail </h2>
            <br>
            <div class='row'>
                <div class='col-sm-5'>
                    <header id='pic' class='carousel slide'>
                        <ol class='carousel-indicators'>";
    $html_for_productDetail = $html_for_productDetail . "</ol>                         
                <div class='carousel-inner' >";
///////////////////////////////////////////////
    while ($array1_for_product = mysqli_fetch_array($result1_for_product)) {
        if ($count_img == 1) {
            $html_for_productDetail = $html_for_productDetail . "<div class='item active'>
                                <div class=' text-center'><img src='../img/{$array1_for_product['pic']}' width='85%' height='375px'></div>
                                <div class='carousel-caption'>
                                </div>
                        </div>";
            $count_img++;
        } else {
            $html_for_productDetail = $html_for_productDetail . "<div class='item'>
                                <div class=' text-center'><img src='../img/{$array1_for_product['pic']}' width='85%' height='375px'></div>
                                <div class='carousel-caption'>
                                </div>
                        </div>";
        }
    }
///////////////////////////////////////////////
    $html_for_productDetail = $html_for_productDetail . "
                        <a class='left carousel-control'    href='#pic' data-slide='prev'>
                            <span class='glyphicon glyphicon-chevron-left   ' style='color:black;'></span>
                        </a>
                        <a class='right carousel-control'    href='#pic' data-slide='next'>
                            <span class='glyphicon glyphicon-chevron-right' style='color:black;'></span>
                        </a>
                    </header>                        
                </div>";
/////// Select รายละเอียดสินค้า
    $sql2 = "SELECT * FROM sports_equipment
        INNER JOIN product_pic
        INNER JOIN brand
        INNER JOIN model
        INNER JOIN category
        ON sports_equipment.product_id=product_pic.product_id 
        AND sports_equipment.model_id=model.model_id 
        AND sports_equipment.category_id=category.category_id
        AND model.brand_id=brand.brand_id
        WHERE sports_equipment.product_id='{$product_id}'";
    $result2 = mysqli_query($connect, $sql2);
    $array2 = mysqli_fetch_array($result2);
    //// Check จำนวนสินค้าคงเหลือ จากรายการขาย wait for payment
    $sql2_for_check = "SELECT SUM(sale_detail.sale_amount) AS amount_sale,
                        sale_detail.product_id,
                        sports_equipment.amount,
                        sports_equipment.amount-SUM(sale_detail.sale_amount) AS amount_result
                        FROM sale
                        INNER JOIN sale_detail ON sale_detail.sale_id = sale.sale_id
                        INNER JOIN sports_equipment ON sports_equipment.product_id=sale_detail.product_id
                        WHERE sale.sale_status='wait for payment' AND sports_equipment.product_id='{$array2['product_id']}'
                        GROUP BY sale_detail.product_id";
    $result2_for_check = mysqli_query($connect, $sql2_for_check);
    $array2_for_check = mysqli_fetch_array($result2_for_check);
    ///// html
    $html_for_productDetail = $html_for_productDetail . "<div class='col-sm-6'>
                    <h3 style='margin:0;'>{$array2['product_name']} </h3>
                    <small> <strong>Product Id :</strong> {$array2['product_id']} </small>
                    <h4><strong> Brand </strong> <small>{$array2['brand_name']}</small></h4>
                    <h4><strong> Model </strong> <small>{$array2['model_name']}</small></h4>";
    /// Check สี
    if ($array2['color'] == "white") {
        $html_for_productDetail = $html_for_productDetail . "<h4><strong> Color </strong> <small class='text-uppercase' style='color:{$array2['color']}; background-color:#A9A9A9;'>{$array2['color']}</small>  <span style='color:#CFCFCF;' class='glyphicon glyphicon-tint'></span></storng></p></h4><hr>";
    } else {
        $html_for_productDetail = $html_for_productDetail . "<h4><strong> Color </strong> <small class='text-uppercase' style='color:{$array2['color']};'>{$array2['color']}</small>   <span style='color:{$array2['color']};' class='glyphicon glyphicon-tint'></span></storng></p></h4><hr>";
    }
    //// Check ส่วนลด
    if ($discount > 0) {
        $discountPrice = $array2['price'] * $discount / 100;
        $price = $array2['price'] - $discountPrice;
        $html_for_productDetail = $html_for_productDetail . "<h3><strong> ฿ " . number_format($price, 2) . "</strong> <small><s class='text-danger'> ฿" . number_format($array2['price'], 2) . " </s> &nbsp;  save {$discount} % </small></h3>"
                . "<p class='text-success'> <strong> Promotion Today :</strong>  {$promotion_name} Discount {$discount} % </p>";
    } else {
        $html_for_productDetail = $html_for_productDetail . "<h3><strong> ฿ " . number_format($array2['price'], 2) . "</strong></h3>";
    }
    // Check สินค้าคงเหลือจากรายการขายที่ wait for payment
    if (mysqli_num_rows($result2_for_check) > 0) {
        if ($array2_for_check['amount_result'] > 0) {
            $html_for_productDetail = $html_for_productDetail . "<h5 class='text-success'>Product In Stock  {$array2_for_check['amount_result']} piece.</h5><hr>";
        } else {
            $html_for_productDetail = $html_for_productDetail . "<h5 class='text-danger'>Product Out Stock </h5><hr>";
            $check_out_stock = false;
        }
        /// Check สินค้าคงเหลือถ้าสินค้าไม่พ่วงกับรายการขายที่ wait for payment
    } else {
        if ($array2['amount'] > 0) {
            $html_for_productDetail = $html_for_productDetail . "<h5 class='text-success'>Product In Stock {$array2['amount']} piece. </h5><hr>";
        } else {
            $html_for_productDetail = $html_for_productDetail . "<h5 class='text-danger'>Product Out Stock </h5><hr>";
            $check_out_stock = false;
        }
    }
    $html_for_productDetail = $html_for_productDetail . "<div class='col-md-3'> 
                        <div>";
    // Check ว่าสินค้ามีพอให้ขายหรือป่าว ถ้าไม่ไม่สามารถปรับหรือเลือกใส่ตระกร้าได้
    if ($check_out_stock == true) {
        $html_for_productDetail = $html_for_productDetail . "       <select id='amount' class='form-control'>";
    } else {
        $html_for_productDetail = $html_for_productDetail . "       <select id='amount' class='form-control' disabled>";
    }
    // Select Option ตามจำนวนคงเหลือ
    $html_for_productDetail = $html_for_productDetail . "<option value='0'>Quantity</option>";
    // นับจากรายการขายที่ wait for payment
    if (mysqli_num_rows($result2_for_check) > 0) {
        if ($array2_for_check['amount_result'] < 5) {
            for ($i = 1; $i <= $array2_for_check['amount_result']; $i++) {
                $html_for_productDetail = $html_for_productDetail . "<option value = '$i'>$i</option>";
            }
        } else {
            $html_for_productDetail = $html_for_productDetail . "<option value = '1'>1 piece.</option>
                        <option value = '2'>2 piece.</option>
                        <option value = '3'>3 piece.</option>
                        <option value = '4'>4 piece.</option>
                        <option value = '5'>5 piece.</option>";
        }
        // นับจาก จำนวนคงเหลือ
    } else {
        if ($array2['amount'] < 5) {
            for ($i = 1; $i <= $array2['amount']; $i++) {
                $html_for_productDetail = $html_for_productDetail . "<option value = '$i'>$i</option>";
            }
        } else {
            $html_for_productDetail = $html_for_productDetail . "<option value = '1'>1 piece.</option>
                        <option value = '2'>2 piece.</option>
                        <option value = '3'>3 piece.</option>
                        <option value = '4'>4 piece.</option>
                        <option value = '5'>5 piece.</option>";
        }
    }
    $html_for_productDetail = $html_for_productDetail . "</select>
                        </div>
                    </div>";
    /// Check การล็อกอิน
    if (isset($_SESSION['member_id'])) {
        $html_for_productDetail = $html_for_productDetail . "<div class = 'col-sm-3'>
            <button class = 'btn btn-success btn-product' onclick = " . "addCart('{$array2['product_id']}')" . " > <span class = 'glyphicon glyphicon-shopping-cart'/></span> Add to Cart</button>
            </div>";
    } else {
        $html_for_productDetail = $html_for_productDetail . "<button class = 'btn btn-success btn-product' data-toggle = 'modal' data-target = '#pleaselogin2'><span class = 'glyphicon glyphicon-shopping-cart'/></span> Add</button>
                                            <div class = 'modal fade' id = 'pleaselogin2' role = 'dialog'>
                                                <div class = 'modal-dialog  '>
                                                    <div class = 'modal-content'>
                                                            <div class = 'modal-header'>
                                                                <button type = 'button' class = 'close' data-dismiss = 'modal'></button>
                                                                <h4 class = 'modal-title text-danger'>กรุณาเข้าสู่ระบบ</h4>
                                                            </div>
                                                            <div class='modal-body'>
                                                            <a href='login_page.php' target='_blank' class='btn btn-xs btn-warning pull-right'>เข้าสู่ระบบ คลิก !</a>
                                                            <p>ขออภัย ! <strong class='text-danger'> คุณยังไม่ได้ทำการเข้าสู่ระบบ </strong> </p>        
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>";
    }
    $html_for_productDetail = $html_for_productDetail . " <br> <br> <br>
            <div class = 'panel panel-warning col-sm-10'>
                <div class = 'panel-body'>
                    <h4><strong>Detail </strong></h4>
                    <p style = 'text-indent: 30px;'>{$array2['product_detail']}</p>
                </div>
            </div>
        </div>
        </div>
    </div>";
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
