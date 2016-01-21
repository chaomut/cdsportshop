<?php

error_reporting(E_ALL ^ E_WARNING);
session_start();
require './connect.php';
// Operation Delete Payment 
if (isset($_GET['del'])) {
    $path_file = "";
    $sale_id = $_REQUEST['sale_id'];
    $sql5_for_select = "SELECT payment_slip FROM payment WHERE sale_id='$sale_id' AND payment_status='not payment'";
    $result5_for_select = mysqli_query($connect, $sql5_for_select);
    if (mysqli_num_rows($result5_for_select) > 0) {
        $array5_for_select = mysqli_fetch_array($result5_for_select);
        $path_file = "../../img/" . $array5_for_select['payment_slip'];
    }
    $sql5_for_del = "DELETE FROM payment WHERE sale_id='$sale_id' AND payment_status='not payment'";
    $result5_for_del = mysqli_query($connect, $sql5_for_del);
    if ($result5_for_del == true) {
        $sql5_for_update = "UPDATE sale
                            SET sale_status='wait for payment'
                            WHERE sale_id='$sale_id'";
        $result5_for_update = mysqli_query($connect, $sql5_for_update);
        unlink($path_file);
    } else {
        echo "  <script>
                    alert('ไม่สามารถทำรายการลบได้');
                </script>";
    }
    echo json_encode($data);
} else {

    // Fucntion Save Img Slip
    function SaveImage($name, $newwidth, $newheight) {
        // เช็คว่าในช่อง browse ของฟอมมีการกดหรือรึเปล่า
        if ($_FILES['slip']['error'] != 4) {
            // ไฟล์ที่อัพเข้ามาเป็ นรูปภาพชนิด jpg 
            if ($_FILES['slip']['type'] == "image/jpeg") {
                $newname = $name . ".jpg";
                $newname_thumb = $name . ".jpg";
                // ก๊อบปี ้ไฟล์รูปภาพเก็บพักไว้ในระบบก่อน
                copy($_FILES['slip']['tmp_name'], $newname);
                // เรียกดูขนาดของไฟล์ภาพ Picture.jpg แล้วเก็บไว้ใน $width กบ $height
                list($width, $height) = getimagesize($newname);
                // สร้างกรอบให้รูปภาพที่จะท าใหม่โดยอ้างอิงขนาดใหม่จาก $newwidth, $newheight
                $thumb = imagecreatetruecolor($newwidth, $newheight);
                // สร้างรูปภาพชนิด jpg จาก Picture.jpg
                $source = imagecreatefromjpeg($newname);
                // ปรับขนาดรูปภาพ ตรงนี ้ต้องจ า $newwidth, $newheight คือ ขนาดใหม่ที่เราจะให้มันปรับ
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                // สร้างรูปภาพชนิด jpg โดยตั้งชื่อใหม่ว่า $newname_thumb
                imagejpeg($thumb, "../../img/slipPayment/" . $newname_thumb);
                unlink($newname);
            } else {
                echo "  <script>
                            alert('อัพโหลดรูปภาพชนิด Jpeg เท่านั้น');
                        </script>";
                header("Refresh:0;url=../payment_page.php");
                exit();
            }
        } else {
            echo "  <script>
                            alert('อัพโหลดรูปภาพเพื่อยืนยันการชำระเงิน');
                        </script>";
            header("Refresh:0;url=../payment_page.php");
            exit();
        }
    }

    $sale_id = $_POST['sale_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $price = $_POST['price'];
    if ($sale_id != "" && $date != "" && $time != "" && $price != "") {
        $member_id = $_SESSION['member_id'];
        $fileName = $sale_id . "_" . $member_id . "_Slip";
        $pathName = "slipPayment/" . $fileName . ".jpg";
        $newwidth = 400;
        $newheight = 400;
        $dateTime = $date . " " . $time;
        if (file_exists($pathName)) {
            echo "The file $fileName exists";
            header("Refresh:0;url=../payment_page.php");
            exit();
        } else {
            SaveImage($fileName, $newwidth, $newheight);
        }
        /////////////// SELECT MAX id PAYMENT ///////////////
        $sql2 = 'select max(payment_id)+1 as nextpayment_id from payment';
        $result2 = mysqli_query($connect, $sql2);
        $array2 = mysqli_fetch_array($result2);
        if ($array2['nextpayment_id'] == NULL) {
            $newpayment = "000001";
        } else {
            $newpayment = sprintf('%06s', $array2['nextpayment_id']);
        }
        /////////////// SELECT MAX id PAYMENT ///////////////
        $sql3 = "INSERT INTO payment VALUES ('$newpayment','$dateTime', '$pathName', '$price', 'not payment', '$sale_id', '000001')";
        $result3 = mysqli_query($connect, $sql3);
        if ($result3 == true) {
            $sql4 = "UPDATE sale SET sale_status='wait for checking payment' WHERE sale_id='$sale_id'";
            $result4 = mysqli_query($connect, $sql4);
        }
    } else {
        echo "<script type='text/javascript'>alert('กรุณากรอกข้อมูลให้ครบ !');</script>";
        header("Refresh:0;url=../payment_page.php");
        exit();
    }
    header("Refresh:0;url=../save_detail_page.php?save=payment");
}
mysqli_close($connect);
?>