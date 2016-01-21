<?php
////////////////////////////////////////////////////////

require './connect.php';
$email = $_REQUEST['email'];
$tel = $_REQUEST['tel'];
$pass = $_REQUEST['password'];
$sql = "SELECT * FROM member WHERE member_email='$email'";
$result = mysqli_query($connect, $sql);
$row = mysqli_num_rows($result);
////////////////////////////////////////////////////////
if ($row == 1) {
    $array = mysqli_fetch_array($result);
    if ($array['member_tel'] == $tel) {
        $passmd5 = md5($pass);
        $sql2 = "UPDATE member 
        SET member_pass='$passmd5'
        WHERE member_email='$email'";
        $result2 = mysqli_query($connect, $sql2);
        $data['status'] = true;
    } else {
        $data['status'] = false;
    }
} else {
    $data['status'] = false;
}
////////////////////////////////////////////////////////
echo json_encode($data);

mysqli_close($connect);

