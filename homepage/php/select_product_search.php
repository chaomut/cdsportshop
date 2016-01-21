<?php
session_start();
error_reporting(E_ALL ^ E_WARNING);
if (isset($_GET['search'])) {
    if ($_GET['search'] == "search") {
        require './php/connect.php';
    } else {
        require './connect.php';
    }
} else {
    require './php/connect.php';
}
$num_per_page = 8;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
$start_rows = ($page - 1) * $num_per_page;
$sql1_for_brand = "SELECT brand.brand_id,brand.brand_name ,COUNT(sports_equipment.product_id) AS product_amount
        FROM brand
        INNER JOIN model ON model.brand_id=brand.brand_id
        INNER JOIN sports_equipment ON sports_equipment.model_id=model.model_id
        WHERE brand_status='Enabled'
        GROUP BY brand.brand_id";
$sql2_for_category = "SELECT category.category_id,category.category_name ,COUNT(sports_equipment.product_id) AS product_amount
         FROM category 
         INNER JOIN sports_equipment ON sports_equipment.category_id=category.category_id
         WHERE category_status='Enabled'
         GROUP BY category.category_id";
$sql3 = "SELECT *
                FROM sports_equipment, product_pic, brand, model, category
                WHERE sports_equipment.product_id=product_pic.product_id
                AND sports_equipment.model_id=model.model_id 
                AND sports_equipment.category_id=category.category_id 
                AND model.brand_id=brand.brand_id
                AND sports_equipment.product_status='Enabled'
                ";
$html1_for_brand = "";
$html2_for_category = "";
$html3_for_product = "";

$result1 = mysqli_query($connect, $sql1_for_brand);
while ($array = mysqli_fetch_array($result1)) {
    $html1_for_brand = $html1_for_brand . "<li><a href='search_page.php?search=search&brand={$array['brand_id']}'>{$array['brand_name']} ({$array['product_amount']})</a></li>";
}

$result2 = mysqli_query($connect, $sql2_for_category);
while ($array = mysqli_fetch_array($result2)) {
    $html2_for_category = $html2_for_category . "<li><a href='search_page.php?search=search&category={$array['category_id']}'>{$array['category_name']} ({$array['product_amount']})</a></li>";
}
///////////// START SEARCH //////////////
if (isset($_GET['search'])) {
    if (isset($_GET['brand'])) {
        $brand_id = $_GET['brand'];
        $sql3 = $sql3 . " AND brand.brand_id='$brand_id'";
    }if (isset($_GET['category'])) {
        $category_id = $_GET['category'];
        $sql3 = $sql3 . " AND category.category_id='$category_id'";
    }if (isset($_GET['model'])) {
        $model_id = $_GET['model'];
        $sql3 = $sql3 . " AND model.model_id='$model_id'";
    } if (isset($_GET['name'])) {
        $name = $_GET['name'];
        $sql3 = $sql3 . " AND sports_equipment.product_name LIKE '%{$name}%'";
    } if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql3 = $sql3 . " AND sports_equipment.product_id='{$id}'";
    }if (isset($_GET['color'])) {
        $color = explode(",", $_GET['color']);
        for ($i = 0; $i < count($color); $i++) {
            if ($i == 0) {
                $sql3 = $sql3 . " AND (sports_equipment.color='$color[$i]'";
            } else {
                $sql3 = $sql3 . " OR sports_equipment.color='$color[$i]'";
            }
        }
        $sql3 = $sql3 . ") ";
    }if (isset($_GET['price'])) {
        $price = explode(",", $_GET['price']);
        if (count($price) > 1) {
            $sql3 = $sql3 . " AND sports_equipment.price BETWEEN {$price[0]} AND {$price[1]}";
        } else {
            $sql3 = $sql3 . " AND sports_equipment.price > {$price[0]}";
        }
    }
    $sql3 = $sql3 . " GROUP BY sports_equipment.product_id";
}
///////////// END SEARCH //////////////
//
//
///////////// START SELECT SEARCH ///////////
//echo $sql3;

$result4 = mysqli_query($connect, $sql3);
$rows = ceil(mysqli_num_rows($result4) / $num_per_page);
if (!isset($_GET['search']) || $_GET['search'] == "advn") {
    $sql3 = $sql3 . " LIMIT $start_rows,$num_per_page";
}

$result3 = mysqli_query($connect, $sql3);
if (mysqli_num_rows($result3) > 0) {
    while ($array = mysqli_fetch_array($result3)) {
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
        /////////////////////////////////////////////////////////////////////////
        $productId = (string) $array['product_id'];
        $priceBaht = number_format($array['price'], 2);
        $html3_for_product = $html3_for_product .
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
                        <p class ='text-center'><strong>{$array['product_name']} </strong>";
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
                            <div class = 'col-md-7 padding-right'>
                                <h5><label style = 'color:orange;'>{$priceBaht} ฿</label></h5>
                            </div>
                    </div>
                        <div style='height:40px'>";
        if (mysqli_num_rows($result3_for_check) > 0) {
            if ($array_for_check['amount_result'] > 0) {
                $html3_for_product = $html3_for_product . "       <p class='text-success'>In Stock</p> ";
            } else {
                $check_out_stock = false;
                $html3_for_product = $html3_for_product . " <p class='text-danger'>Out Stock</p>";
            }
        } else {
            if ($array['amount'] > 0) {
                $html3_for_product = $html3_for_product . "    <p class='text-success'>In Stock</p> ";
            } else {
                $check_out_stock = false;
                $html3_for_product = $html3_for_product . " <p class='text-danger'>Out Stock</p>";
            }
        }
        $html3_for_product = $html3_for_product . "</div>
                            <div class = 'row'>
                                 <div class = 'col-md-6'>
                                    <a href = 'product_detail_page.php?product_id={$array['product_id']}' class = 'btn btn-primary btn-product'><span class = 'glyphicon glyphicon-th-list'/></span> Detail</a>
                            </div>
                                 <div class = 'col-md-6'>";
        if ($check_out_stock == true) {
            if (isset($_SESSION['member_id'])) {
                $html3_for_product = $html3_for_product . "<button id = 'addCart' onclick=" . "addCart('{$array['product_id']}','{$array['price']}')" . " type = 'button' class = 'btn btn-success btn-product'><span class = 'glyphicon glyphicon-shopping-cart'/></span> Add";
            } else {
                $html3_for_product = $html3_for_product . "<button class = 'btn btn-success btn-product' data-toggle = 'modal' data-target = '#pleaselogin_search'><span class = 'glyphicon glyphicon-shopping-cart'/></span> Add</button>
                                            <div class = 'modal fade' id = 'pleaselogin_search' role = 'dialog'>
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
            $html3_for_product = $html3_for_product . "<button class = 'btn btn-success btn-product' data-toggle = 'modal' data-target = '#alertOutStock{$array['product_id']}'><span class = 'glyphicon glyphicon-shopping-cart'/></span> Add</button>
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
        $html3_for_product = $html3_for_product .
                "</div>
        </div>
        </div>
        </div>
        </div>
        ";
    }
    ///////////////////////////////////////////
    $html3_for_product = $html3_for_product . "<div class='col-md-12 text-center'>
                                            <ul class='pagination'>";
    if (!isset($_GET['search']) || $_GET['search'] == "advn") {
        if ($rows > 1) {
            for ($i = 1; $i <= $rows; $i++) {
                if ($page == $i) {
                    $html3_for_product = $html3_for_product . "<li class='active'><button class='btn btn-success' onclick = " . "search($i)" . " >$i</button></li>&nbsp";
                } else {
                    $html3_for_product = $html3_for_product . "<li><button class='btn btn-info' onclick = " . "search($i)" . " >$i</button></li> &nbsp";
                }
            }
            $html3_for_product = $html3_for_product . "</ul>
                                           </div>";
        }
    }
} else {
    $html3_for_product = $html3_for_product . "<div class='alert alert-warning'>
            	<button type='button' class='close' data-dimdiss='alert' aria-hidden='true'>  &nbsp; ×</button>
        <strong>ไม่มีรายการสินค้าที่ค้นหา :</strong> 
    </div>";
}

///////////// END SELECT SEARCH ///////////
if (isset($_GET['search'])) {
    if ($_GET['search'] == "advn") {
        echo $html3_for_product;
    }
}

mysqli_close($connect);
?>
