<?php

////////////////////////////////////////////////////////
require "./connect.php";
$email = $_REQUEST["email"];
$fname = $_REQUEST["fname"];
$lname = $_REQUEST["lname"];
$address = $_REQUEST["address"];
$tel = $_REQUEST["tel"];
$pass = $_REQUEST["password"];
////////////////////////////////////////////////////////
$sql = 'select max(member_id)+1 as nextmember_id from member';
$result = mysqli_query($connect, $sql);
$array = mysqli_fetch_array($result);

if ($array['nextmember_id'] == NULL) {
    $newmember = '000001';
} else {
    $newmember = sprintf('%06s', $array['nextmember_id']);
}
////////////////////////////////////////////////////////
///
//////////////////////////////////////////////////////
$passmd5 = md5($pass);
$sql2 = "INSERT INTO member VALUES ('$newmember', '$fname', '$lname', '$address', '$email', '$tel', '$passmd5')";
$result = mysqli_query($connect, $sql2);
if ($result == "true") {
    $data['msg'] = "true";
    $data['member_id'] = $newmember;
} else {
    $data['msg'] = "false";
}
echo json_encode($data);
mysqli_close($connect);
?>
