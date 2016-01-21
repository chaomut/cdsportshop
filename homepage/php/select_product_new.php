<?php

error_reporting(E_ALL ^ E_WARNING);
require './php/connect.php';
$num_per_page_new = 4;
if (isset($_GET['page_new'])) {
    $page_new = $_GET['page_new'];
} else {
    $page_new = 1;
}
$start_rows_new = ($page_new - 1) * $num_per_page_new;
$html5_for_new_product = "";
// Command SQL for Select New Product
$sql5_for_new_product = "SELECT * FROM sports_equipment
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
                            AND MONTH(sports_equipment.add_date)=MONTH(NOW())
                            AND YEAR(sports_equipment.add_date)=YEAR(NOW())
                        GROUP BY sports_equipment.product_id";
/////////////////////////////////////////////////////////////////////////
$result5_for_rows_product = mysqli_query($connect, $sql5_for_new_product);
$rows_new = ceil(mysqli_num_rows($result5_for_rows_product) / $num_per_page_new);
$sql5_for_new_product = $sql5_for_new_product . " LIMIT $start_rows_new,$num_per_page_new";
//////////////////////////////////////////////////////////////////////////////
$result5_for_new_product = mysqli_query($connect, $sql5_for_new_product);
if (mysqli_num_rows($result5_for_new_product) > 0) {
    while ($array5_for_top_sale = mysqli_fetch_array($result5_for_new_product)) {
        $sql5_for_product = "SELECT * FROM sports_equipment
                        INNER JOIN product_pic
                        INNER JOIN brand
                        INNER JOIN model
                        INNER JOIN category
                                ON sports_equipment.product_id=product_pic.product_id 
                                AND sports_equipment.model_id=model.model_id 
                                AND sports_equipment.category_id=category.category_id
                                AND model.brand_id=brand.brand_id
                        WHERE sports_equipment.product_status='Enabled' 
                              AND sports_equipment.product_id='{$array5_for_top_sale['product_id']}'
                        GROUP BY sports_equipment.product_id";
        $result5_for_product = mysqli_query($connect, $sql5_for_product);
        while ($array5_for_product = mysqli_fetch_array($result5_for_product)) {
            $check_out_stock = true;
            //////////////////////////////////////////////////////////////////
            $sql5_for_check = "SELECT SUM(sale_detail.sale_amount) AS amount_sale,
                        sale_detail.product_id,
                        sports_equipment.amount,
                        sports_equipment.amount-SUM(sale_detail.sale_amount) AS amount_result
                        FROM sale
                        INNER JOIN sale_detail ON sale_detail.sale_id = sale.sale_id
                        INNER JOIN sports_equipment ON sports_equipment.product_id=sale_detail.product_id
                        WHERE sale.sale_status='wait for payment' AND sports_equipment.product_id='{$array5_for_product['product_id']}'
                        GROUP BY sale_detail.product_id";
            $result5_for_check = mysqli_query($connect, $sql5_for_check);
            $array5_for_check = mysqli_fetch_array($result5_for_check);
            //////////////////////////////////////////////////////////////////
            //$productId = (string) $array5_for_product['product_id'];
            $priceBaht = number_format($array5_for_product['price'], 2);
            $html5_for_new_product = $html5_for_new_product .
                    "<div class = 'col-md-3'>
                    <div class = 'thumbnail'>
                        <h4 class = 'text-center'>
                            <span class = 'label label-info'>{$array5_for_product['brand_name']}</span><br>
                        </h4>
                        <h5 class = 'text-center'>
                            <span class = 'label label-success'>{$array5_for_product['model_name']}</span>
                        </h5>
                        <img width=150px height=150px src = '../img/{$array5_for_product['pic']}' ></img>
                    <div style='height:40px'>
                        <p class = 'text-center' ><strong>{$array5_for_product['product_name']}</storng>";
            if ($array5_for_product['color'] == "white") {
                $html5_for_new_product = $html5_for_new_product . " <span style='color:#CFCFCF;' class='glyphicon glyphicon-tint'></span></storng></p>";
            } else {
                $html5_for_new_product = $html5_for_new_product . " <span style='color:{$array5_for_product['color']};' class='glyphicon glyphicon-tint'></span></storng></p>";
            }
            $html5_for_new_product = $html5_for_new_product . "</div>
                    <div class = 'caption'>
                        <div class = 'row'>
                            <div class ='col-md-5' style='height:40px'>
                                <h6><strong>{$array5_for_product['category_name']}</storng></h6>
                            </div>
                            <div class = 'col-md-7 padding-right'>
                                <h5><label style = 'color:orange;'>{$priceBaht} ฿</label></h5>
                            </div>
                        </div>
                        <div style='height:40px'>";
            if (mysqli_num_rows($result5_for_check) > 0) {
                if ($array5_for_check['amount_result'] > 0) {
                    $html5_for_new_product = $html5_for_new_product . "       <p class='text-success'>In Stock {$array5_for_check['amount_result']} ชิ้น </p> ";
                } else {
                    $check_out_stock = false;
                    $html5_for_new_product = $html5_for_new_product . " <p class='text-danger'>Out Stock</p>";
                }
            } else {
                if ($array5_for_product['amount'] > 0) {
                    $html5_for_new_product = $html5_for_new_product . "    <p class='text-success'>In Stock {$array5_for_product['amount']} ชิ้น </p> ";
                } else {
                    $check_out_stock = false;
                    $html5_for_new_product = $html5_for_new_product . " <p class='text-danger'>Out Stock</p>";
                }
            }
            $html5_for_new_product = $html5_for_new_product . "
                    </div>
                        <div class='row'>
                            <div class='col-md-6'>
                            <a href = 'product_detail_page.php?product_id={$array5_for_product['product_id']}' class = 'btn btn-primary btn-product'><span class = 'glyphicon glyphicon-th-list'/></span> Detail</a>
                        </div>
                    <div class = 'col-md-6'>";
            if ($check_out_stock == true) {
                if (isset($_SESSION['member_id'])) {
                    $html5_for_new_product = $html5_for_new_product . "<button id = 'addCart' onclick=" . "addCart('{$array5_for_product['product_id']}','{$array5_for_product['price']}')" . " type = 'button' class = 'btn btn-success btn-product'><span class = 'glyphicon glyphicon-shopping-cart'/></span> Add";
                } else {
                    $html5_for_new_product = $html5_for_new_product . "<button class = 'btn btn-success btn-product' data-toggle = 'modal' data-target = '#pleaselogin1'><span class = 'glyphicon glyphicon-shopping-cart'/></span> Add</button>
                                            <div class = 'modal fade' id = 'pleaselogin1' role = 'dialog'>
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
                $html5_for_new_product = $html5_for_new_product . "<button class = 'btn btn-success btn-product' data-toggle = 'modal' data-target = '#alertOutStock_new{$array5_for_product['product_id']}'><span class = 'glyphicon glyphicon-shopping-cart'/></span> Add</button>
                                            <div class = 'modal fade' id = 'alertOutStock_new{$array5_for_product['product_id']}' role = 'dialog'>
                                                <div class = 'modal-dialog '>
                                                    <div class = 'modal-content'>
                                                            <div class = 'modal-header'>
                                                                <button type = 'button' class = 'close' data-dimdiss = 'modal'></button>
                                                                <h4 class = 'modal-title text-danger'>สินค้าหมดชั่วคราว</h4>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <p>ขออภัย ! สินค้า <a href='product_detail_page.php?product_id={$array5_for_product['product_id']}'> <strong class='text-info'> {$array5_for_product['product_name']}</strong></a> หมดชั่วคราว </p>
                                                            </div>
                                                    </div>
                                                </div>
                                        </div>";
            }
            $html5_for_new_product = $html5_for_new_product .
                    "</div>
                                    </div>
                                </div>
                            </div>
                        </div>";
        }
    }
    $html5_for_new_product = $html5_for_new_product . "<div class = 'col-md-12 text-center'>
        <ul class = 'pagination'>";
    if ($rows_new > 1) {
        for ($i = 1; $i <= $rows_new; $i++) {
            if ($page_new == $i) {
                $html5_for_new_product = $html5_for_new_product . "<li class = 'active'><a href = '?page_new=$i'>$i</a></li>";
            } else {
                $html5_for_new_product = $html5_for_new_product . "<li><a href = '?page_new=$i'>$i</a></li>";
            }
        }
        $html5_for_new_product = $html5_for_new_product . "</ul>";
    }
    $html5_for_new_product = $html5_for_new_product . "</div>";
} else {
    $html5_for_new_product = "<div class='alert alert-warning'>
                                <button type='button' class='close' data-dimdiss='alert' aria-hidden='true'>  &nbsp; ×</button>
                                <strong>ไม่มีรายการสินค้าใหม่ประจำเดือน :</strong> 
                           </div>";
}



