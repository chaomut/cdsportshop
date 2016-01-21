<?php

error_reporting(E_ALL ^ E_WARNING);
session_start();
require '../php/datetime.php';
require '../php/connect.php';
$newsale = "";
$totalSale = 0;
$discount = 0;
$delivery = 0;
$discountPrice = 0;
$Price = 0;
$check_out_stock = true;
$address = $_REQUEST['address'];
///////////// Start Promotion /////////////
/////// Promotion
$sql_for_promotion = "SELECT * FROM promotion WHERE DATE(NOW()) >= start_date AND DATE(NOW()) <= end_date";
$result_for_promotion = mysqli_query($connect, $sql_for_promotion);
$array_for_promotion = mysqli_fetch_array($result_for_promotion);
if (mysqli_num_rows($result_for_promotion) > 0) {
    $discount = $array_for_promotion['discount'];
    $promotion_id = (string) $array_for_promotion['pro_id'];
}
///////////// END Promotion /////////////
//
//
//
//
//
///////////// Start Product ////////////
for ($i = 0; $i < count($_SESSION['product']); $i++) {
    $value = $_SESSION['product'][$i];
    $temp = json_decode($value, true);
    if (isset($temp['product_id'])) {
        $sql2_for_check = "SELECT SUM(sale_detail.sale_amount) AS amount_sale,sale_detail.product_id,sports_equipment.amount,sports_equipment.price,sports_equipment.amount-SUM(sale_detail.sale_amount) AS amount_result
                            FROM sale
                                INNER JOIN sale_detail ON sale_detail.sale_id = sale.sale_id
                                INNER JOIN sports_equipment ON sports_equipment.product_id=sale_detail.product_id
                            WHERE sale.sale_status='wait for payment' AND sports_equipment.product_id='{$temp['product_id']}'
                            GROUP BY sale_detail.product_id";
        $result2_for_check = mysqli_query($connect, $sql2_for_check);
        $array2_for_check = mysqli_fetch_array($result2_for_check);
        if (mysqli_num_rows($result2_for_check) > 0) {
            if ($array2_for_check['amount_result'] < 0 || $array2_for_check['amount_result'] < $temp['amount']) {
                $data['status'] = false;
                $data['msg'] = "ขออภัย ! สินค้าที่เลือกหมดชั่วคราว";
                $check_out_stock = false;
            } else {
                $check_out_stock = true;
            }
        } else {
            $sql2_for_product = "SELECT * FROM sports_equipment
                                    INNER JOIN product_pic
                                    INNER JOIN brand
                                    INNER JOIN model
                                    INNER JOIN category
                                        ON sports_equipment.product_id=product_pic.product_id 
                                            AND sports_equipment.model_id=model.model_id 
                                            AND sports_equipment.category_id=category.category_id
                                            AND model.brand_id=brand.brand_id
                                    WHERE sports_equipment.product_status='Enabled' 
                                        AND sports_equipment.product_id='{$temp['product_id']}'
                                    GROUP BY sports_equipment.product_id";
            $result2_for_product = mysqli_query($connect, $sql2_for_product);
            $array2_for_product = mysqli_fetch_array($result2_for_product);
            if ($array2_for_product['amount'] <= 0 || $array2_for_product['amount'] < $temp['amount']) {
                $check_out_stock = false;
                $data['status'] = false;
                $data['msg'] = "ขออภัย ! สินค้าที่เลือกหมดชั่วคราว";
            } else {
                $check_out_stock = true;
            }
        }
        if ($check_out_stock == true) {
            $sql2_for_product = "SELECT * FROM sports_equipment
                                INNER JOIN product_pic
                                INNER JOIN brand
                                INNER JOIN model
                                INNER JOIN category
                                ON sports_equipment.product_id=product_pic.product_id 
                                AND sports_equipment.model_id=model.model_id 
                                AND sports_equipment.category_id=category.category_id
                                AND model.brand_id=brand.brand_id
                                WHERE sports_equipment.product_status='Enabled' 
                                AND sports_equipment.product_id='{$temp['product_id']}'
                                GROUP BY sports_equipment.product_id";
            $result2_for_product = mysqli_query($connect, $sql2_for_product);
            $array2_for_product = mysqli_fetch_array($result2_for_product);
            $totalPrice = $array2_for_product['price'] * $temp['amount'];
            $totalSale += $totalPrice;
            if ($totalSale >= 1000) {
                $delivery = 0;
            } else {
                $delivery = 80;
                $totalSale += $delivery;
            }
        }
    }
}
//
////////
////////////  START INSERT SALE  ////////////
if ($check_out_stock == true) {
    $sql3 = 'select max(sale_id)+1 as nextsale_id from sale';
    $result3 = mysqli_query($connect, $sql3);
    $array3 = mysqli_fetch_array($result3);
    $member_id = (string) $_SESSION['member_id'];
    if ($array3['nextsale_id'] == NULL) {
        $newsale = '000001';
    } else {
        $newsale = sprintf('%06s', $array3['nextsale_id']);
    }
    if (isset($promotion_id)) {
        $discountPrice = $discount * $totalSale / 100;
        $sql4 = "INSERT INTO sale VALUES ('$newsale', 'wait for payment', '$currentdate', '$totalSale','$discountPrice', '$address', '$delivery', '$promotion_id' ,'$member_id')";
    } else {
        $sql4 = "INSERT INTO sale 
                (sale_id,sale_status,sale_date,total_salePrice,discount_price,delivery_address,ems_price,member_id)
                VALUES ('$newsale', 'wait for payment', '$currentdate', '$totalSale','$discountPrice', '$address', '$delivery','$member_id')";
    }
    $result4 = mysqli_query($connect, $sql4);
    if ($result4 == true) {
        ////////////  START INSERT SALE DETAIL  ////////////
        for ($i = 0; $i < count($_SESSION['product']); $i++) {
            $value = $_SESSION['product'][$i];
            $temp = json_decode($value, true);
            if (isset($temp['product_id'])) {
                $sql5 = "SELECT * FROM sports_equipment
                        WHERE product_id='{$temp['product_id']}'";
                $result5 = mysqli_query($connect, $sql5);
                $array5 = mysqli_fetch_array($result5);
                $price = $array5['price'];
                $product_id = (string) $array5['product_id'];
                $amount = $temp['amount'];
                $sql6 = "INSERT INTO sale_detail VALUES ('$newsale','$product_id','$amount','$price') ";
                $result6 = mysqli_query($connect, $sql6);
            }
        }
        $data['status'] = true;
    } else {
        echo "<script type='text/javascript'>alert('ไม่สามารถทำรายการได้ !');</script>";
        header("Refresh:0;url=../payment_page.php");
    }
    echo json_encode($data);


////////////  END INSERT SALE DETAIL  ////////////
}
mysqli_close($connect);
?>

