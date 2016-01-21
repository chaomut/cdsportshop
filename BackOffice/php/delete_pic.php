<?php

require '../php/connect.php';
$operation = $_GET['operation'];

if ($operation == "delete") {
    $pic_id = $_REQUEST['pic_id'];
    $product_id = $_REQUEST['product_id'];
    $sql1 = "DELETE FROM product_pic WHERE pic_id = '$pic_id'";
    $result = mysqli_query($connect, $sql1);
    $fileDelete = unlink("../../img/product/" . $pic_id . $product_id . ".jpg");
    if ($result == true) {
        $status['status'] = true;
    } else {
        $status['status'] = false;
    }
    echo json_encode($status);
    mysqli_close($connect);
}


