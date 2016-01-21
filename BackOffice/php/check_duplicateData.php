<?php

require './connect.php';
$operation = $_GET['operation'];

if ($operation == "category") {
    $cate_name = $_REQUEST['cate_name'];

    $sql1 = "SELECT category_name FROM category WHERE category_name = '$cate_name'";
    $result1 = mysqli_query($connect, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }
    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "category_edit") {
    $cate_id = $_REQUEST['cate_id'];
    $cate_name = $_REQUEST['cate_name'];

    $sql1 = "SELECT category_name FROM category WHERE category_name = '$cate_name' AND category_id <> '$cate_id'";
    $result1 = mysqli_query($connect, $sql1);
    if (mysqli_num_rows($result1) > 0) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }
    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "brand") {
    $brand_name = $_REQUEST['brand_name'];

    $sql1 = "SELECT brand_name FROM brand WHERE brand_name = '$brand_name'";
    $result1 = mysqli_query($connect, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }
    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "brand_edit") {
    $brand_id = $_REQUEST['brand_id'];
    $brand_name = $_REQUEST['brand_name'];

    $sql1 = "SELECT brand_name FROM brand WHERE brand_name = '$brand_name' AND brand_id <> '$brand_id'";
    $result1 = mysqli_query($connect, $sql1);
    if (mysqli_num_rows($result1) > 0) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }
    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "model") {
    $model_name = $_REQUEST['model_name'];

    $sql1 = "SELECT model_name FROM model WHERE model_name = '$model_name'";
    $result1 = mysqli_query($connect, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }
    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "model_edit") {
    $model_id = $_REQUEST['model_id'];
    $model_name = $_REQUEST['model_name'];

    $sql1 = "SELECT model_name FROM model WHERE model_name = '$model_name' AND model_id <> '$model_id'";
    $result1 = mysqli_query($connect, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }
    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "product") {
    $product_name = $_REQUEST['product_name'];

    $sql1 = "SELECT product_name FROM sports_equipment WHERE product_name = '$product_name'";
    $result1 = mysqli_query($connect, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }
    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "product_edit") {
    $product_id = $_REQUEST['product_id'];
    $product_name = $_REQUEST['product_name'];

    $sql1 = "SELECT product_name FROM sports_equipment WHERE product_name = '$product_name' AND product_id <> '$product_id'";
    $result1 = mysqli_query($connect, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }
    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "promotion") {
    $pro_name = $_REQUEST['pro_name'];

    $sql1 = "SELECT pro_name FROM promotion WHERE pro_name = '$pro_name'";
    $result1 = mysqli_query($connect, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }
    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "promotion_edit") {
    $pro_id = $_REQUEST['pro_id'];
    $pro_name = $_REQUEST['pro_name'];

    $sql1 = "SELECT pro_name FROM promotion WHERE pro_name = '$pro_name' AND pro_id <> '$pro_id'";
    $result1 = mysqli_query($connect, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }
    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "promotion_start") {
    $start_date = $_REQUEST['start_date'];

    $start_date = str_replace("T", " ", $start_date);

    $sql1 = "SELECT * FROM promotion ORDER BY pro_id DESC LIMIT 1";
    $result1 = mysqli_query($connect, $sql1);

    $array = mysqli_fetch_array($result1);

    if ($array['end_date'] > $start_date) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }

    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "promotion_start_edit") {
    $pro_id = $_REQUEST['pro_id'];
    $start_date = $_REQUEST['start_date'];
    $start_date = str_replace("T", " ", $start_date);

    $sql1 = "SELECT * FROM promotion WHERE pro_id <> '{$pro_id}'";
    $result1 = mysqli_query($connect, $sql1);
    $duplicatePromotion = false;

    while ($array = mysqli_fetch_array($result1)) {
        $old_startdate = $array['start_date'];
        $old_enddate = $array['end_date'];
        if (strtotime($old_startdate) <= strtotime($start_date) && strtotime($old_enddate) >= strtotime($start_date)) {
            $duplicatePromotion = true;
        }
    }

    if ($duplicatePromotion == true) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }

    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "promotion_end_edit") {
    $pro_id = $_REQUEST['pro_id'];
    $end_date = $_REQUEST['end_date'];
    $end_date = str_replace("T", " ", $end_date);

    $sql1 = "SELECT * FROM promotion WHERE pro_id <> '$pro_id'";
    $result1 = mysqli_query($connect, $sql1);
    $dupplicatePromotion = false;

    while ($array = mysqli_fetch_array($result1)) {
        $old_startdate = $array['start_date'];
        $old_enddate = $array['end_date'];
        if (strtotime($old_startdate) <= strtotime($end_date) && strtotime($old_enddate) >= strtotime($end_date)) {
            $dupplicatePromotion = true;
        }
    }

    if ($dupplicatePromotion == true) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }

    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "supplier") {
    $sup_name = $_REQUEST['sup_name'];

    $sql1 = "SELECT sup_name FROM supplier WHERE sup_name = '$sup_name'";
    $result1 = mysqli_query($connect, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }
    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "supplier_edit") {
    $sup_id = $_REQUEST['sup_id'];
    $sup_name = $_REQUEST['sup_name'];

    $sql1 = "SELECT sup_name FROM supplier WHERE sup_name = '$sup_name' AND sup_id <> '$sup_id'";
    $result1 = mysqli_query($connect, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }
    echo json_encode($duplicate);
    mysqli_close($connect);
}

?>

