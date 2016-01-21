<?php

require "./connect.php";
$email = $_REQUEST["email"];
$sql = "SELECT * FROM member WHERE member_email='$email'";
$result = mysqli_query($connect, $sql);


if (mysqli_num_rows($result) <= 0) {
    $result1["status"] = true;
    $result1['msg'] = "E-mail : นี้สามารถใช้ได้";
} else {
    $result1["status"] = false;
    $result1['msg'] = "E-mail : นี้มีผู้ใช้แล้วโปรดตรวจสอบความถูกต้อง";
}
echo json_encode($result1);



mysqli_close($connect);
?>
