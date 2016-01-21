<?php
error_reporting(E_ALL^E_WARNING);
require './connect.php';
session_start();
$email = $_REQUEST['email'];
$pass = $_REQUEST['password'];
$md5pass = md5($pass);
$sql = "SELECT * FROM member WHERE member_email='$email' AND member_pass='$md5pass'";

//////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////
$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) > 0) {
    $array = mysqli_fetch_array($result);
    $member_id = $array['member_id'];
    $_SESSION['member_id'] = $member_id;
    $data['status'] = true;
} else {
    $data['status'] = false;
}
//////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////
echo json_encode($data);
mysqli_close($connect);
?>