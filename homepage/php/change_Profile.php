<?php

error_reporting(E_ALL ^ E_WARNING);
session_start();
require './connect.php';

$member_id = $_SESSION['member_id'];
$member_fname = $_REQUEST['fname'];
$member_lname = $_REQUEST['lname'];
$member_tel = $_REQUEST['tel'];
$member_address = $_REQUEST['address'];
$password = $_REQUEST['password'];
$passmd5 = md5($password);
// Command SQL for Select Check Member
$sql1 = "SELECT * FROM member WHERE member_id='$member_id'";
$result = mysqli_query($connect, $sql1);
$array = mysqli_fetch_array($result);

if (mysqli_num_rows($result) == 1 && $passmd5 == $array['member_pass']) {
    $sql2 = "UPDATE member 
             SET member_fname='$member_fname',member_lname='$member_lname',member_address='$member_address',member_tel='$member_tel'
             WHERE member_id='$member_id'";
    $result2 = mysqli_query($connect, $sql2);
    if ($result2 == true) {
        $data['status'] = true;
    } else {
        $data['status'] = false;
    }
} else {
    $data['status'] = false;
}
echo json_encode($data);
mysqli_close($connect);
?>