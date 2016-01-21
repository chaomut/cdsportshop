<?php

require '../php/connect.php';
$operation = $_GET['operation'];
if ($operation == "update") {
    $admin_id = $_REQUEST['admin_id'];
    $admin_fname = $_REQUEST['admin_fname'];
    $admin_lname = $_REQUEST['admin_lname'];
    $admin_tel = $_REQUEST['admin_tel'];
    $admin_pass = $_REQUEST['admin_pass'];

    $md5pass1 = md5($admin_pass);

    $sql1 = "SELECT admin_pass FROM admin WHERE admin_id = '$admin_id'";

    $result1 = mysqli_query($connect, $sql1);
    $array = mysqli_fetch_array($result1);
    $md5pass2 = $array['admin_pass'];

    if ($md5pass1 == $md5pass2) {
        $sql2 = "UPDATE admin SET admin_fname = '$admin_fname', admin_lname = '$admin_lname', admin_tel = '$admin_tel'
                WHERE admin_id = '$admin_id'";

        $result2 = mysqli_query($connect, $sql2);
        $status['status'] = true;
        mysqli_close($connect);
    } else {
        $status['status'] = false;
    }
    echo json_encode($status);
} else {
    echo "false";
}
?>