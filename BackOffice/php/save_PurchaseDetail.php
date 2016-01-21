<?php

require './connect.php';

session_start();
date_default_timezone_set('Asia/Bangkok');
$pur_date = date("Y-m-d H:i:s");
$totalPrice = 0;
$totalPurshasePrice = 0;
$new_pur_id = "";
$admin_id = $_SESSION['admin_id'];
$sup_id = $_REQUEST['sup_id'];


//Save to Purchase
for ($i = 0; $i < count($_SESSION['purchase']); $i++) {
    $value = $_SESSION['purchase'][$i];
    $temp = json_decode($value, true);

    $totalPrice = $temp['price'] * $temp['amount'];
    $totalPurshasePrice += $totalPrice;
}

$sql1 = "SELECT max(pur_id)+1 as new_pur_id FROM purchase";
$result = mysqli_query($connect, $sql1);

$array = mysqli_fetch_array($result);

if ($array['new_pur_id'] == NULL) {
    $new_pur_id = "000001";
} else {
    $new_pur_id = sprintf('%06s', $array['new_pur_id']);
}
$sql2 = "INSERT INTO purchase values ('$new_pur_id','$pur_date','purchased','$totalPurshasePrice','$sup_id','$admin_id')";
$result2 = mysqli_query($connect, $sql2);



//Save to Purchase Detail
for ($i = 0; $i < count($_SESSION['purchase']); $i++) {
    $value = $_SESSION['purchase'][$i];
    $temp = json_decode($value, true);

    if (isset($temp['product_id'])) {
        $product_id = $temp['product_id'];
        $pur_amount = $temp['amount'];
        $pur_price = $temp['price'];

        $sql3 = "INSERT INTO purchase_detail values ('$new_pur_id','$product_id','$pur_amount','$pur_price')";
        $result3 = mysqli_query($connect, $sql3);
    }
}

if ($result3 == true) {
    unset($_SESSION['purchase']);
    echo json_encode($result3);
}

