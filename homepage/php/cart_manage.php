<?php
error_reporting(E_ALL^E_WARNING);
session_start();
$operation = $_GET['operation'];

///////////////////////// START Add Cart /////////////////////////
if ($operation == "add_select") {
    $json = $_REQUEST['product'];
    $newProduct = json_decode($json, true);
    $dupplicateProduct = false;
    if (isset($_SESSION['product'])) {
        for ($i = 0; $i < count($_SESSION['product']); $i++) {
            $value = $_SESSION['product'][$i];
            $temp = json_decode($value, true);
            if ($temp['product_id'] == $newProduct['product_id']) {
                $temp['amount'] += $newProduct['amount'];
                $_SESSION['product'][$i] = json_encode($temp);
                $data['msg'] = true;
                echo json_encode($data);
                $dupplicateProduct = true;
                break;
            }
        }
    }
    if ($dupplicateProduct == false) {
        $_SESSION['product'][] = $json;
    }
    ///////////////////////// END Add Cart /////////////////////////
    ///////////////////////// START Delete Cart ////////////////////
} elseif ($operation == "add") {
    $json = $_REQUEST['product'];
    $newProduct = json_decode($json, true);
    $dupplicateProduct = false;
    if (isset($_SESSION['product'])) {
        for ($i = 0; $i < count($_SESSION['product']); $i++) {
            $value = $_SESSION['product'][$i];
            $temp = json_decode($value, true);
            if ($temp['product_id'] == $newProduct['product_id']) {
                $_SESSION['product'][$i] = json_encode($temp);
                $data['msg'] = true;
                echo json_encode($data);
                $dupplicateProduct = true;
                break;
            }
        }
    }
    if ($dupplicateProduct == false) {
        $_SESSION['product'][] = $json;
    }
    ///////////////////////// END Add Cart /////////////////////////
    ///////////////////////// START Delete Cart ////////////////////
} elseif ($operation == "delete") {
    $json = $_REQUEST['product'];
    $reMoveproduct = json_decode($json, true);
    for ($i = 0; $i < count($_SESSION['product']); $i++) {
        $value = $_SESSION['product'][$i];
        $temp = json_decode($value, true);
        if ($temp['product_id'] == $reMoveproduct['product_id']) {
            unset($_SESSION['product'][$i]);
            $_SESSION['product'] = array_values($_SESSION['product']);
            if (count($_SESSION['product']) == 0) {
                unset($_SESSION['product']);
            }
            break;
        }
    }
    ///////////////////////// END Delete Cart ////////////////////
    ///////////////////////// START SHOW Cart ////////////////////
} elseif ($operation == "show") {
    if (isset($_SESSION["product"])) {
        $json = $_SESSION['product'];
        echo json_encode($json);
    }
    ///////////////////////// END SHOW Cart ////////////////////
    ///////////////////////// START Edit Cart /////////////////
} elseif ($operation == "addAmount") {
    $json = $_REQUEST['product'];
    $addAmonut = json_decode($json, true);
    if (isset($_SESSION['product'])) {
        for ($i = 0; $i < count($_SESSION['product']); $i++) {
            $value = $_SESSION['product'][$i];
            $temp = json_decode($value, true);
            if ($temp['product_id'] == $addAmonut['product_id']) {
                $temp['amount'] = $addAmonut['amount'];
                $_SESSION['product'][$i] = json_encode($temp);
                break;
            }
        }
    }
}
///////////////////////// END Edit Cart /////////////////
?>
