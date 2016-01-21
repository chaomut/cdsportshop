<?php
/////////////////Update Purchase Order///////////////////////////////////////

session_start();
$operation = $_GET['operation'];


if ($operation == "add") {
    $json = $_REQUEST['product_id'];
    $_SESSION['purchase'][] = $json;
    $data = $_SESSION['purchase'];
    echo json_encode($data);
} else if ($operation == "delete") {
    $json = $_REQUEST['product_id'];
    $delete = json_decode($json, true);
    for ($i = 0; $i < count($_SESSION['purchase']); $i++) {
        $value = $_SESSION['purchase'][$i];
        $temp = json_decode($value, true);
        if ($temp['product_id'] == $delete['product_id']) {
            unset($_SESSION['purchase'][$i]);
            $_SESSION['purchase'] = array_values($_SESSION['purchase']);
            if (count($_SESSION['purchase']) == 0) {
                unset($_SESSION['purchase']);
                break;
            }
        }
    }
    echo json_encode($value);
} else if ($operation == "edit") {
    $json = $_REQUEST['product_id'];
    $addAmount = json_decode($json, true);
    if (isset($_SESSION['purchase'])) {
        for ($i = 0; $i < count($_SESSION['purchase']); $i++) {
            $value = $_SESSION['purchase'][$i];
            $temp = json_decode($value, true);
            if ($temp['product_id'] == $addAmount['product_id']) {
                $temp['amount'] = $addAmount['amount'];
                $temp['price'] = $addAmount['price'];
                $_SESSION['purchase'][$i] = json_encode($temp);
            }
        }
    }
    echo json_encode($value);
}

