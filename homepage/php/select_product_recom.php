<?php
// Check Finnish
error_reporting(E_ALL ^ E_WARNING);
require './php/connect.php';
/// Command SQL Select Brand
$sql1_for_brand = "SELECT brand.brand_id,brand.brand_name ,COUNT(sports_equipment.product_id) AS product_amount
                   FROM brand
                   INNER JOIN model ON model.brand_id=brand.brand_id
                   INNER JOIN sports_equipment ON sports_equipment.model_id=model.model_id
                   WHERE brand_status='Enabled'
                   GROUP BY brand.brand_id";
/// Command SQL Select Category
$sql2_for_category = "SELECT category.category_id,category.category_name ,COUNT(sports_equipment.product_id) AS product_amount
                      FROM category 
                      INNER JOIN sports_equipment ON sports_equipment.category_id=category.category_id
                      WHERE category_status='Enabled'
                      GROUP BY category.category_id";
/// Command SQL Select สินค้าแนะนำโดยการสุ่ม
$sql3_for_product = "SELECT * FROM sports_equipment
                     INNER JOIN product_pic
                     INNER JOIN brand
                     INNER JOIN model
                     INNER JOIN category
                        ON sports_equipment.product_id=product_pic.product_id 
                            AND sports_equipment.model_id=model.model_id 
                            AND sports_equipment.category_id=category.category_id
                            AND model.brand_id=brand.brand_id
                    WHERE sports_equipment.product_status='Enabled'
                        AND brand.brand_status='Enabled' 
                        AND model.model_status='Enabled'
                        AND category.category_status='Enabled'
                    GROUP BY sports_equipment.product_id
                    ORDER BY RAND() LIMIT 8";
$html1_for_brand = "";
$html2_for_category = "";
$html3_for_product = "";
$html4_for_new_product = "";
/// query Brand
$result1_for_brand = mysqli_query($connect, $sql1_for_brand);
while ($array = mysqli_fetch_array($result1_for_brand)) {
    $html1_for_brand = $html1_for_brand . "<li><a href='search_page.php?search=search&brand={$array['brand_id']}'>{$array['brand_name']} ({$array['product_amount']})</a></li>";
}
/// query Category
$result2_for_category = mysqli_query($connect, $sql2_for_category);
while ($array = mysqli_fetch_array($result2_for_category)) {
    $html2_for_category = $html2_for_category . "<li><a href='search_page.php?search=search&category={$array['category_id']}'>{$array['category_name']} ({$array['product_amount']})</a></li>";
}
/// query Product
$result3_for_product = mysqli_query($connect, $sql3_for_product);
while ($array = mysqli_fetch_array($result3_for_product)) {
    $check_out_stock = true;
    /// Command SQL for Check Stock
    $sql3_for_check = "SELECT SUM(sale_detail.sale_amount) AS amount_sale,
                        sale_detail.product_id,
                        sports_equipment.amount,
                        sports_equipment.amount-SUM(sale_detail.sale_amount) AS amount_result
                        FROM sale
                        INNER JOIN sale_detail ON sale_detail.sale_id = sale.sale_id
                        INNER JOIN sports_equipment ON sports_equipment.product_id=sale_detail.product_id
                        WHERE sale.sale_status='wait for payment' AND sports_equipment.product_id='{$array['product_id']}'
                        GROUP BY sale_detail.product_id";
    $result3_for_check = mysqli_query($connect, $sql3_for_check);
    $array_for_check = mysqli_fetch_array($result3_for_check);
    //////////////////////////////////////////////////////////////////
    //$productId = (string) $array['product_id'];
    $priceBaht = number_format($array['price'], 2);
    $html3_for_product = $html3_for_product .
            "<div class='col-md-3'>
                    <div class='thumbnail'>
                        <h4 class='text-center'>
                            <span class='label label-info'>{$array['brand_name']}</span><br>
                        </h4>
                        <h5 class='text-center'>
                            <span class='label label-success'>{$array['model_name']}</span>
                        </h5>
                        <img width=150px height=150px src = '../img/{$array['pic']}' ></img>
                    <div style='height:40px'>
                        <p class='text-center'><strong>{$array['product_name']}</storng>";
    if ($array['color'] == "white") {
        $html3_for_product = $html3_for_product . " <span style='color:#CFCFCF;' class='glyphicon glyphicon-tint'></span></storng></p>";
    } else {
        $html3_for_product = $html3_for_product . " <span style='color:{$array['color']};' class='glyphicon glyphicon-tint'></span></storng></p>";
    }
    $html3_for_product = $html3_for_product . "
                    </div>
                    <div class = 'caption'>
                        <div class = 'row'>
                            <div class = 'col-md-5' style='height:40px'>
                                <h6><strong>{$array['category_name']}</storng></h6>
                            </div>
                            <div class = 'col-md-7  padding-right'>
                                <h5><label style = 'color:orange;'>{$priceBaht} ฿</label></h5>
                            </div>
                        </div>
                    <div style='height:40px'>";
    if (mysqli_num_rows($result3_for_check) > 0) {
        if ($array_for_check['amount_result'] > 0) {
            $html3_for_product = $html3_for_product . "<p class='text-success'>In Stock {$array_for_check['amount_result']} ชิ้น </p>";
        } else {
            $check_out_stock = false;
            $html3_for_product = $html3_for_product . "<p class='text-danger'>Out Stock</p>";
        }
    } else {
        if ($array['amount'] > 0) {
            $html3_for_product = $html3_for_product . "<p class='text-success'>In Stock {$array['amount']} ชิ้น </p>";
        } else {
            $check_out_stock = false;
            $html3_for_product = $html3_for_product . "<p class='text-danger'>Out Stock</p>";
        }
    }
    $html3_for_product = $html3_for_product . "</div>
        <div class = 'row'>
            <div class = 'col-md-6'>
                <a href = 'product_detail_page.php?product_id={$array['product_id']}' class = 'btn btn-primary btn-product'><span class = 'glyphicon glyphicon-th-list'/></span> Detail</a>
            </div>";
    if ($check_out_stock == true) {
        if (isset($_SESSION['member_id'])) {
            $html3_for_product = $html3_for_product . "<button id = 'addCart' onclick=" . "addCart('{$array['product_id']}','{$array['price']}')" . " type = 'button' class = 'btn btn-success btn-product'><span class = 'glyphicon glyphicon-shopping-cart'/></span> Add";
        } else {
            $html3_for_product = $html3_for_product . "<button class = 'btn btn-success btn-product' data-toggle = 'modal' data-target = '#pleaselogin2'><span class = 'glyphicon glyphicon-shopping-cart'/></span> Add</button>
                                            <div class = 'modal fade' id = 'pleaselogin2' role = 'dialog'>
                                                <div class = 'modal-dialog  '>
                                                    <div class = 'modal-content'>
                                                            <div class = 'modal-header'>
                                                                <button type = 'button' class = 'close' data-dimdiss = 'modal'></button>
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
    } else {
        $html3_for_product = $html3_for_product . "<button class = 'btn btn-success btn-product' data-toggle = 'modal' data-target = '#alertOutStock_recom{$array['product_id']}'><span class = 'glyphicon glyphicon-shopping-cart'/></span> Add</button>
                                            <div class = 'modal fade' id = 'alertOutStock_recom{$array['product_id']}' role = 'dialog'>
                                                <div class = 'modal-dialog '>
                                                    <div class = 'modal-content'>
                                                            <div class = 'modal-header'>
                                                                <button type = 'button' class = 'close' data-dimdiss = 'modal'></button>
                                                                <h4 class = 'modal-title text-danger'>สินค้าหมดชั่วคราว</h4>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <p>ขออภัย ! สินค้า <a href='product_detail_page.php?product_id={$array['product_id']}'> <strong class='text-info'> {$array['product_name']}</strong></a> หมดชั่วคราว </p>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>";
    }
    $html3_for_product = $html3_for_product ."</div>
                                        </div>
                                    </div>
                                </div>";
}
mysqli_close($connect);
?>
