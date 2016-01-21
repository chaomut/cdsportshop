<?php

session_start();
require './connect.php';
$email = $_POST['email'];
$pass = $_POST['password'];

$md5pass = md5($pass);
$sql = "SELECT * FROM admin WHERE admin_email='$email' AND admin_pass ='$md5pass'";
$result = mysqli_query($connect, $sql);

$array = mysqli_fetch_array($result);
$admin_id = $array['admin_id'];

if (mysqli_num_rows($result) > 0) {
    $_SESSION['admin_id'] = $admin_id;
    header("Refresh:0;url=../mainmenu_back.php");
} else {
    $message = "E-mail or Password incorrect";
    echo "<script type='text/javascript'>alert('$message');</script>";
    header("Refresh:0;url=../login_back.php");
}
?>
