<?php
error_reporting(E_ALL ^ E_WARNING);
session_start();
require '../cancel_sale.php';
if (!isset($_SESSION['member_id'])) {
    header("Refresh:0;url=index.php");
    exit();
}
require './php/m_checklogin.php';
require './php/connect.php';
$member_id = $_SESSION['member_id'];
if (isset($member_id)) {
    $select_sale_id = "<div class='form-group'>
                        <label class='col-sm-3 control-label' for='card-holder-name'>เลือกรายการ</label>
                        <div class='col-sm-9'>
                        <select type='text' class='form-control' name='sale_id'>
                        <option value=''></option>";
    $sql = "SELECT * FROM sale WHERE member_id='$member_id' AND sale_status='wait for payment'";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($array = mysqli_fetch_array($result)) {
            $sale_detail = $array['sale_id'] . " วันที่สั่งซื้อ : " . $array['sale_date'] . " , ราคารวม : " . number_format($array['total_salePrice'] - $array['discount_price'], 2) . " บาท";
            $select_sale_id = $select_sale_id . "<option value='{$array['sale_id']}'>{$sale_detail}</option>";
        }
        $select_sale_id = $select_sale_id . "</select>
                        </div>
                    </div><div class='form-group'>
                        <label class='col-sm-3 control-label'>วันที่โอน</label>
                        <div class='col-sm-4'>
                            <input type='date' class='form-control' name='date'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label class='col-sm-3 control-label'>เวลาที่โอน</label>
                        <div class='col-sm-3'>
                            <input type='time'  class='form-control' name='time'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label class='col-sm-3 control-label'>จำนวนเงินที่โอน</label>
                        <div class='col-sm-4'>
                            <input type='number' max='10000000000'  class='form-control' name='price'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label class='col-sm-3 control-label'>อัพโหลดไฟล์</label>
                        <div class='col-sm-5'>
                            <input type='file' class='form-control' name='slip'>
                            <label class='col-sm-12' style='color:red;'>รูปภาพชนิด .jpg เท่านั้น</label>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-offset-9 col-sm-6'>
                            <button type='submit' class='btn btn-success' name='Upload' value='Upload'>
                            <span class='glyphicon glyphicon-save-file'></span> Pay Now</button>
                        </div>";
    } else {
        $select_sale_id = "<div class='alert alert-warning'>
            	<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>  &nbsp; × </button>
        <a href='history_page.php' class='btn btn-xs btn-warning pull-right'>  &nbsp; คลิก  &nbsp; </a>
        <strong>คุณไม่มีรายการรอการชำระเงิน :</strong> ตรวจสอบประวัติการสั่งซื้อได้ที่
    </div>";
    }
}
?>
<html>
    <head>
        <title>Payment</title>
        <meta charset="UTF-8">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <link href="css/css_page.css" rel="stylesheet" type="text/css">

    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <ul class="nav nav-tabs">
                    <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> HOME </a></li>
                    <li><a href="profile_page.php"><span class="glyphicon glyphicon-lock"></span> Profile</a></li>
                    <li class="active"><a href="payment_page.php"><span class="glyphicon glyphicon-credit-card"></span> Payment</a></li>
                    <li><a href="history_page.php"><span class="glyphicon glyphicon-user"></span> History </a></li>
                    <ul class="nav navbar-nav navbar-right">
                        <div id='logout' class="nav nav-tabs">
                            <?php echo $show_login ?>
                        </div>
                    </ul>
                </ul>
            </div>
        </nav>
        <div class="container">
            <br><br><br>
            <form class="form-horizontal col-sm-10 col-sm-offset-1" action="php/save_Payment.php" method="post" enctype="multipart/form-data">
                <legend>Payment Detail</legend>

                <div class="panel panel-default">
                    <div>
                        <div class="panel-heading"><h4>Payment</h4></div>
                        <div class="panel-body">
                            <?php echo $select_sale_id ?> 
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">ธนาคาร</th>
                            <th class="text-center">ชื่อบัญชี</th>
                            <th class="text-center">สาขา</th>
                            <th class="text-center">เลขที่บัญชี</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><img src="../img/bank/BANGKOK-2.png"> &nbsp;ธ.กรุงเทพ</td>
                            <td class="text-center"><br>นาย ธราภัท วริศนราทร</td>
                            <td class="text-center"><br>หนองจอก</td>
                            <td class="text-center"><br>232-4-82604-5</td>
                        </tr>
                        <tr>
                            <td><img src="../img/bank/KBANK-2.png"> &nbsp;ธ.กสิกรไทย</td>
                            <td class="text-center"><br>นาย ธราภัท วริศนราทร</td>
                            <td class="text-center"><br>พาราไดช์ ปาร์ค</td>
                            <td class="text-center"><br>232-4-82604-5</td>
                        </tr>
                        <tr>
                            <td><img src="../img/bank/KTB-2.png"> &nbsp;ธ.กรุงไทย</td>
                            <td class="text-center"><br>นาย ณัฐพล สอิ้งทอง</td>
                            <td class="text-center"><br>มีนบุรี</td>
                            <td class="text-center"><br>232-4-82604-5</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
