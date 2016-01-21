<?php

$checkStock = true;
require './php/m_checklogin.php';
require './php/connect.php';
require './php/datetime.php';
$totalSale = 0;
$discount = 0;
$delivery = 0;
$discountPrice = 0;
$product_id_for_out = "";
$html_for_cart = "";
if (isset($_SESSION['product'])) {
    /////// Promotion
    $sql_for_promotion = "SELECT * FROM promotion WHERE DATE(NOW()) >= start_date AND DATE(NOW()) <= end_date";
    $result_for_promotion = mysqli_query($connect, $sql_for_promotion);
    $array_for_promotion = mysqli_fetch_array($result_for_promotion);
    if (mysqli_num_rows($result_for_promotion) > 0) {
        $discount = $array_for_promotion['discount'];
    }
    $html_for_cart = "
            <div class='row'>
                <div class='col-sm-10 col-sm-offset-1'>
                    <table class='table table-hover'>
                        <thead>
                            <tr>
                                <th class='text-center'>Product ID</th>
                                <th>Product</th>
                                <th>Detail</th>
                                <th>Quantity</th>
                                <th class='text-center'>Price</th>
                                <th class='text-center'>Total</th>
                                <th> </th>
                            </tr>
                        </thead>";

    for ($i = 0; $i < count($_SESSION['product']); $i++) {
        $value = $_SESSION['product'][$i];
        $temp = json_decode($value, true);
        if (isset($temp['product_id'])) {
            // Command SQL for Check Product Amount 
            $sql2 = "SELECT SUM(sale_detail.sale_amount) AS amount_sale,
                        sale_detail.product_id,
                        sports_equipment.amount,
                        sports_equipment.amount-SUM(sale_detail.sale_amount) AS amount_result
                        FROM sale
                        INNER JOIN sale_detail ON sale_detail.sale_id = sale.sale_id
                        INNER JOIN sports_equipment ON sports_equipment.product_id=sale_detail.product_id
                        WHERE sale.sale_status='wait for payment' AND sports_equipment.product_id='{$temp['product_id']}'
                        GROUP BY sale_detail.product_id";
            $result2 = mysqli_query($connect, $sql2);
            $array2 = mysqli_fetch_array($result2);

            //////////////////////////////////////////
            $sql = "SELECT * FROM sports_equipment
                        INNER JOIN product_pic
                        INNER JOIN brand
                        INNER JOIN model
                        INNER JOIN category
                        ON sports_equipment.product_id=product_pic.product_id 
                        AND sports_equipment.model_id=model.model_id 
                        AND sports_equipment.category_id=category.category_id
                        AND model.brand_id=brand.brand_id
                        WHERE sports_equipment.product_id='{$temp['product_id']}'
                        GROUP BY sports_equipment.product_id";
            $result = mysqli_query($connect, $sql);
            $array = mysqli_fetch_array($result);
            $productId = (string) $array['product_id'];
            $totalPrice = $array['price'] * $temp['amount'];
            $totalSale += $totalPrice;
            if ($totalSale >= 1000) {
                $delivery = 0;
            } else {
                $delivery = 80;
                $totalSale += $delivery;
            }
            $priceBaht = number_format($array['price'], 2);
            $html_for_cart = $html_for_cart . "<tr>
                            <td class='col-sm-2 text-center'><strong>{$array['product_id']}</strong></td>
                                <td class='col-sm-2'>
                                    <a class='thumbnail' href='product_detail_page.php?product_id={$array['product_id']}'> <img class='media-object' src='../img/{$array['pic']}' width='120px' height='120px'> </a>
                                </td>
                            <td class='col-sm-6'>
                                <div class='media'>
                                    <div class='media-body'>
                                        <h5 class='media-heading'>{$array['product_name']} </h5>
                                        <h6 class='media-heading'><strong> Brand </strong><a href='search_page.php?search=search&brand={$array['brand_id']}'> {$array['brand_name']} </a></h6>
                                        <h6 class='media-heading'><strong> Model </strong><a href='search_page.php?search=search&model={$array['model_id']}'> {$array['model_name']} </a></h6>
                                       <h6 class='media-heading'><strong> Color </strong><a href='search_page.php?search=search&color={$array['color']}'> {$array['color']}</a> </h6>";
            if (mysqli_num_rows($result2) > 0) {
                if ($array2['amount_result'] > 0) {
                    $product_id_for_out = $array['product_id'];
                    $html_for_cart = $html_for_cart . "<h5><strong>Status : </strong><strong class='text-success'>In Stock {$array2['amount_result']} piece.</strong></h5>
                            </div>
                                </div></td>
                            <td class='col-sm-1 text-center'>
                                <input type='number' min='1' max='{$array2['amount_result']}' id='amount{$productId}'class='form-control' onkeypress='checkAmount()'  onchange=" . "add_Cart_amount('{$productId}',this)" . " value='{$temp['amount']}'>
                            </td> ";
                } else {
                    $checkStock = false;
                    $html_for_cart = $html_for_cart . "<span><h5><strong>Status : </strong> </span><span class='text-danger  '><strong>Out Stock</strong></h5></span>
                            </div>
                                </div></td>
                            <td class='col-sm-1 text-center'>
                                <input readonly type='number' min='1' max='{$array['amount']}' id='amount{$productId}'class='form-control'  onchange=" . "add_Cart_amount('{$productId}')" . " value='{$temp['amount']}'>
                            </td>";
                }
            } else {
                if ($array['amount'] > 0) {
                    $html_for_cart = $html_for_cart . "<h5><strong>Status : </strong><strong class='text-success'>In Stock {$array['amount']} piece.</strong></h5>
                            </div>
                                </div></td>
                            <td class='col-sm-1 text-center'>
                                <input type='number' min='1' max='{$array['amount']}' id='amount{$productId}'class='form-control' onkeypress='checkAmount()' onchange=" . "add_Cart_amount('{$productId}',this)" . " value='{$temp['amount']}'>
                            </td> ";
                } else {
                    $checkStock = false;
                    $html_for_cart = $html_for_cart . "<span><h5><strong>Status : </strong> </span><span class='text-danger  '><strong>Out Stock</strong></h5></span>
                            </div>
                                </div></td>
                            <td class='col-sm-1 text-center'>
                                <input readonly  type='number' min='1' max='{$array['amount']}' id='amount{$productId}'class='form-control' onchange=" . "add_Cart_amount('{$productId}')" . " value='{$temp['amount']}'>
                            </td>";
                }
            }
            $html_for_cart = $html_for_cart . "
                            <td class = 'col-sm-1 text-center'><strong>{$priceBaht}</strong></td>
                            <td class = 'col-sm-1 text-center'><strong>" . number_format($totalPrice, 2) . "</strong></td>
                            <td class = '   col-sm-1'>
                            <button onclick = " . "remove_Cart('{$productId}')" . " type = 'button' class = 'btn btn-danger'>
                            <span class = 'glyphicon glyphicon-trash'></span> Remove
                            </button></td>
                            </tr>";
        }
    }
    $discountPrice = $discount * $totalSale / 100;
    $html_for_cart = $html_for_cart . "<tr> <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Discount</h5></td>
                        <td class = 'text-right'><h5><strong>{$discount} %</strong></h5></td>
                        </tr>
                        <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Discount Pirce</h5></td>
                        <td class = 'text-right'><h5><strong>- " . number_format($discountPrice, 2) . " </strong></h5></td>
                        </tr>
                        <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Delivery Price</h5></td>
                        <td class = 'text-right'><h5><strong>" . number_format($delivery, 2) . "</strong></h5></td>
                        </tr>
                        <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Total Price</h5></td>
                        <td class = 'text-right'><h4><strong>" . number_format($totalSale, 2) . " ฿" . "</strong></h5></td>
                            </tr>
                             <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td><h5>Net. Price</h5></td>
                                
                                <td class='text-right'><h4><strong>" . number_format($totalSale - $discountPrice, 2) . " ฿" . "</strong></h5></td>
                            </tr>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>
                                    <a href='index.php'><button type='button' class='btn btn-default'>
                                        <span class='glyphicon glyphicon-shopping-cart'></span> Continue Shopping
                                    </button></a></td>
                                <td>";
    if ($checkStock == true) {
        $html_for_cart = $html_for_cart . "<a href='checkout_page.php'><button type='button' class='btn btn-success'>
                                        Checkout <span class='glyphicon glyphicon-play'></span>
                                    </button></a></td>";
    } else {
        $html_for_cart = $html_for_cart . "<button type='button' class='btn btn-success' data-toggle = 'modal' data-target = '#alertOutStock'>
                                        Checkout <span class='glyphicon glyphicon-play'></span>
                                    </button>
                                    <div class = 'modal fade' id = 'alertOutStock' role = 'dialog'>
                                                <div class = 'modal-dialog '>
                                                    <div class = 'modal-content'>
                                                            <div class = 'modal-header'>
                                                                <button type = 'button' class = 'close' data-dismiss = 'modal'></button>
                                                                <h4 class = 'modal-title text-warning'>Warning  !</h4>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <p>ขออภัย ! สินค้าหมดชั่วคราว </p>
                                                            </div>
                                                          <div class='modal-footer'>
                                                            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                                          </div>
                                                      </div>
                                                </div></td>";
    }
    $html_for_cart = $html_for_cart . "</tr>
                        </tbody>
                    </table>
                </div>
            </div>";
} else {
    $html_for_cart = "<div class='alert alert-warning'>
        <a href='index.php' class='btn btn-xs btn-warning pull-right'>เลือกซื้อสินค้า</a>
        <strong>คุณไม่มีสินค้าในตระกร้า :</strong> เลือกสินค้าที่ต้องการก่อน !
    </div>";
}
mysqli_close($connect);
