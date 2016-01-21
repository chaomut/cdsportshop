<?php

require './connect.php';
$operation = $_GET['operation'];
if ($operation == "update") {
    $admin_email = $_REQUEST['admin_email'];
    $admin_tel = $_REQUEST['admin_tel'];
    $admin_pass = $_REQUEST['admin_pass'];

    $md5pass = md5($admin_pass);

    $sql1 = "SELECT * FROM admin WHERE admin_email = '$admin_email' AND admin_tel = '$admin_tel'";
    $result1 = mysqli_query($connect, $sql1);

    if (mysqli_num_rows($result1) < 0) {
        $data['status'] = false;
    } else {

        $sql2 = "UPDATE admin SET admin_pass = '$md5pass' WHERE admin_email = '$admin_email' AND admin_tel = '$admin_tel'";
        $result2 = mysqli_query($connect, $sql2);
        $data['status'] = true;
    }

    echo json_encode($data);
    mysqli_close($connect);
}
?>