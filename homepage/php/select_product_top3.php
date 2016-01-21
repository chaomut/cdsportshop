<?php

error_reporting(E_ALL ^ E_WARNING);
//session_start();
require './php/connect.php';
$html4_for_top_sale = "";
$sql4_for_top_sale = "SELECT SUM(sale_detail.sale_amount) , sports_equipment.product_id , MONTH(sale.sale_date) AS month_date
                        FROM sale
                        INNER JOIN sale_detail ON sale_detail.sale_id = sale.sale_id
                        INNER JOIN sports_equipment ON sports_equipment.product_id=sale_detail.product_id
                        WHERE sale.sale_status='wait for delivery' OR sale.sale_status='delivery success' AND MONTH(sale.sale_date)=MONTH(NOW())
                        GROUP BY sale_detail.product_id
                        ORDER BY SUM(sale_detail.sale_amount) DESC LIMIT 3";
$result4_for_top_sale = mysqli_query($connect, $sql4_for_top_sale);
if (mysqli_num_rows($result4_for_top_sale) > 0) {
    while ($array4_for_top_sale = mysqli_fetch_array($result4_for_top_sale)) {
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
                              AND sports_equipment.product_id='{$array4_for_top_sale['product_id']}'
                        GROUP BY sports_equipment.product_id";
        $result3_for_product = mysqli_query($connect, $sql3_for_product);
        while ($array = mysqli_fetch_array($result3_for_product)) {
            $check_out_stock = true;
            //////////////////////////////////////////////////////////////////
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
            $productId = (string) $array['product_id'];
            $priceBaht = number_format($array['price'], 2);
            $html4_for_top_sale = $html4_for_top_sale .
                    "<div class = 'col-md-3'>
                    <div class = 'thumbnail'>
                        <h4 class = 'text-center'>
                            <span class = 'label label-info'>{$array['brand_name']}</span><br>
                        </h4>
                        <h5 class = 'text-center'>
                            <span class = 'label label-success'>{$array['model_name']}</span>
                        </h5>
                        <img style = 'width=150px; height=150px;' src = '../img/{$array['pic']}' ></img>
                    <div style='height:40px'>
                        <p class = 'text-center' ><strong>{$array['product_name']}</storng>";
            if ($array['color'] == "white") {
                $html4_for_top_sale = $html4_for_top_sale . " <span style='color:#CFCFCF;' class='glyphicon glyphicon-tint'></span></storng></p>";
            } else {
                $html4_for_top_sale = $html4_for_top_sale . " <span style='color:{$array['color']};' class='glyphicon glyphicon-tint'></span></storng></p>";
            }
            $html4_for_top_sale = $html4_for_top_sale . "
                    </div>
                    <div class = 'caption'>
                        <div class = 'row'>
                            <div class = 'col-md-5'>
                                <h6><strong>{$array['category_name']}</storng></h6>
                            </div>
                            <div class = 'col-md-7 price text-right'>
                                <h5><label style = 'color:orange;'>{$priceBaht} ฿</label></h5>
                            </div>
                        </div>
                        <div style='height:40px'>";
            if (mysqli_num_rows($result3_for_check) > 0) {
                if ($array_for_check['amount_result'] > 0) {
                    $html4_for_top_sale = $html4_for_top_sale . " <p class='text-success'>In Stock {$array_for_check['amount_result']} ชิ้น </p> ";
                } else {
                    $check_out_stock = false;
                    $html4_for_top_sale = $html4_for_top_sale . " <p class='text-danger'>Out Stock</p>";
                }
            } else {
                if ($array['amount'] > 0) {
                    $html4_for_top_sale = $html4_for_top_sale . " <p class='text-success'>In Stock {$array['amount']} ชิ้น </p> ";
                } else {
                    $check_out_stock = false;
                    $html4_for_top_sale = $html4_for_top_sale . " <p class='text-danger'>Out Stock</p>";
                }
            }
            $html4_for_top_sale = $html4_for_top_sale . "</div>
                                                <div class = 'row'>
                                                <div class = 'col-md-6'>
                                                <a href = 'product_detail_page.php?product_id={$array['product_id']}' class = 'btn btn-primary btn-product'><span class = 'glyphicon glyphicon-th-list'/></span> Detail</a>
                                                </div>
                                                <div class = 'col-md-6'>";
            if ($check_out_stock == true) {
                if (isset($_SESSION['member_id'])) {
                    $html4_for_top_sale = $html4_for_top_sale . "<button id = 'addCart' onclick=" . "addCart('{$array['product_id']}','{$array['price']}')" . " type = 'button' class = 'btn btn-success btn-product'><span class = 'glyphicon glyphicon-shopping-cart'/></span> Add";
                } else {
                    $html4_for_top_sale = $html4_for_top_sale . "<button class = 'btn btn-success btn-product' data-toggle = 'modal' data-target = '#pleaselogin3'><span class = 'glyphicon glyphicon-shopping-cart'/></span> Add</button>
                                            <div class = 'modal fade' id = 'pleaselogin3' role = 'dialog'>
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
                $html4_for_top_sale = $html4_for_top_sale . "<button class = 'btn btn-success btn-product' data-toggle = 'modal' data-target = '#alertOutStock{$array['product_id']}'><span class = 'glyphicon glyphicon-shopping-cart'/></span> Add</button>
                                            <div class = 'modal fade' id = 'alertOutStock{$array['product_id']}' role = 'dialog'>
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
            $html4_for_top_sale = $html4_for_top_sale .
                    "</div>
        </div>
        </div>
        </div>
        </div>";
        }
    }
} else {
    $html4_for_top_sale = "<div class='alert alert-warning'>
                                <button type='button' class='close' data-dimdiss='alert' aria-hidden='true'>  &nbsp; ×</button>
                                <strong>ไม่มีรายการสินค้าขายดี :</strong> 
                           </div>";
}


