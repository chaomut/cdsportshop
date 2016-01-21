<?php

require './connect.php';
$operation = $_GET['operation'];

if ($operation == "admin") {
    $admin_email = $_REQUEST['admin_email'];

    $sql1 = "SELECT admin_email FROM admin WHERE admin_email = '$admin_email'";
    $result1 = mysqli_query($connect, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        $duplicate['status'] = false;
    } else {
        $duplicate['status'] = true;
    }
    echo json_encode($duplicate);
    mysqli_close($connect);
} else if ($operation == "supplier") {
    $sup_email = $_REQUEST['sup_email'];

    $sql1 = "SELECT sup_email FROM supplier WHERE sup_email = '$sup_email'";
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
    $sup_email = $_REQUEST['sup_email'];

    $sql1 = "SELECT sup_email FROM supplier WHERE sup_email = '$sup_email' AND sup_id <> '$sup_id'";
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

