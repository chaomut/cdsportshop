<?php
error_reporting(E_ALL^E_WARNING);
session_start();
require '../cancel_sale.php';
if (!isset($_SESSION['member_id'])) {
    header("Refresh:0;url=index.php");
    exit();
}
require './php/connect.php';
require './php/m_checklogin.php';
require './php/datetime.php';
$numberDays = 0;
$member_id = $_SESSION['member_id'];
if (isset($_GET['sale_id'])) {
    if ($_GET['sale_id'] == "show_all") {
        $sql = "SELECT * FROM sale WHERE member_id='$member_id'";
    } elseif ($_GET['sale_id'] == "cancel") {
        $sql = "SELECT * FROM sale WHERE member_id='$member_id' AND sale_status<>'cancel'";
    } else {
        $sql = "SELECT * FROM sale WHERE member_id='$member_id' AND sale_id='{$_GET['sale_id']}'";
    }
} else {
    $sql = "SELECT * FROM sale WHERE member_id='$member_id'";
}
$sql_for_select_sale = "SELECT * FROM sale WHERE member_id='$member_id'";
$result_for_select_sale = mysqli_query($connect, $sql_for_select_sale);
if (mysqli_num_rows($result_for_select_sale) > 0) {
    $html_for_sale_select = "<select class='form-control' id='id-sale' onchange='search_sale();'>
                        <option value='#'>เลือกรหัสการสั่งซื้อ</option>
                        <option value='show_all'>แสดงรายการทั้งหมด</option>
                        <option value='cancel'>ยกเว้นรายการที่ยกเลิก</option>";
    while ($array_for_select_sale = mysqli_fetch_array($result_for_select_sale)) {

        $html_for_sale_select = $html_for_sale_select . "<option value='{$array_for_select_sale['sale_id']}'>{$array_for_select_sale['sale_id']}</option>";
    }
    $html_for_sale_select = $html_for_sale_select . "</select>";
}
////////////////////////////////////////////////////////
$result = mysqli_query($connect, $sql);
if (mysqli_num_rows($result) > 0) {
    $html_sale_detail = "<table class='table table-hover'>
                <thead>
                    <tr>
                        <th class='text-center'>รหัสสั่งซื้อ</th>
                        <th class='text-center'>วัน-เวลาที่สั่งซื้อ</th>
                        <th class='text-center'>ราคาทั้งหมด</th>
                        <th class='text-center'>ส่วนลด</th>
                        <th class='text-center'>รวม</th>
                        <th class='text-center'>ที่อยู่ในการจัดส่ง</th>
                        <th class='text-center'>สถานะ</th>
                        <th class='text-center'>รายละเอียด</th>
                    </tr>
                </thead>
                <tbody>";
    while ($array = mysqli_fetch_array($result)) {
        $sale_status = $array['sale_status'];
        $html_sale_detail = $html_sale_detail . "<tr>
                    <td class='text-center'><h5>{$array['sale_id']}</h5></td>
                    <td class='text-center'><h5>{$array['sale_date']}</h5></td>
                    <td class='text-center'><h5>" . number_format($array['total_salePrice'], 2) . "</h5></td>
                    <td class='text-center'><h5>" . number_format($array['discount_price'], 2) . "</h5></td>
                    <td class='text-center'><h5>" . number_format($array['total_salePrice'] - $array['discount_price'], 2) . "</h5></td>
                    <td ><textarea style='font-size:14px' readonly rows='2' cols='40'>{$array['delivery_address']}</textarea></td>";
        if ($sale_status == "cancel") {
            $msg_status = "ยกเลิก";
            $html_sale_detail = $html_sale_detail . "<td class='text-center text-danger'><h5> {$msg_status}</h5></td>";
        } elseif ($sale_status == "wait for payment") {
            $Sale_dateEnd = date("d-m-Y H:i", strtotime($array['sale_date'] . "+3 days"));
            $msg_status = "รอการชำระเงิน";
            $html_sale_detail = $html_sale_detail . "<td class='text-center text-warning'><a href='payment_page.php'><h5>{$msg_status}</a></h5>
                             <span class='label label-danger' style='font-size:10px'>ชำระก่อนวันที่  $Sale_dateEnd </span></td>";
        } elseif ($sale_status == "wait for checking payment") {
            $msg_status = "รอตรวจสอบการชำระเงิน";
            $html_sale_detail = $html_sale_detail . "<td class='text-center text-info'><h5>{$msg_status}</h5></td>";
        } elseif ($sale_status == "wait for delivery") {
            $msg_status = "รอการส่ง";
            $html_sale_detail = $html_sale_detail . "<td class='text-center text-primary'><h5>{$msg_status}</h5></td>";
        } elseif ($sale_status == "delivery success") {
            $msg_status = "การส่งสำเร็จ";
            $html_sale_detail = $html_sale_detail . "<td class='text-center text-success'><h5>{$msg_status}</h5 ></td>";
        }
        $html_sale_detail = $html_sale_detail . "<td class='text-center'>       
                        <a href='JavaScript:Sale_Detail(\"sale_detail_popup.php?sale_id={$array['sale_id']}\");' target='_self'><button type='button' class='btn btn-primary  btn-sm'>
                                <span class='glyphicon glyphicon-zoom-in'></span>
                            </button></a>
                    </td>
                </tr>";
    }
    $html_sale_detail = $html_sale_detail . "</tbody>
                        </table>";
} else {
    $html_sale_detail = "<br><br><div class='alert alert-warning'>
        <a href='index.php' class='btn btn-xs btn-warning pull-right'>เลือกซื้อสินค้า</a>
        <strong>ยังไม่มีการสั่งซื้อ :</strong> เลือกสินค้าที่ต้องการก่อน !
    </div>";
}
?>
<html>
    <head>
        <title>Profile</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
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
                    <li><a href="payment_page.php"><span class="glyphicon glyphicon-credit-card"></span> Payment</a></li>
                    <li class="active"><a href="history_page.php"><span class="glyphicon glyphicon-user"></span> History</a></li>
                    <ul class="nav navbar-nav navbar-right">
                        <?php echo $show_login ?>
                    </ul>
                </ul>
            </div>
        </nav>
        <br><br>

        <div class="container">
            <h2 id="text-head" class="title text-center">History</h2>
            <h2>ประวัติการสั่งซื้อ</h2>
            <div class="col-sm-2">
                <div class='input-group'>
                    <?php
                    if (isset($html_for_sale_select)) {
                        echo $html_for_sale_select;
                    }
                    ?>     
                </div>
            </div>
            <?php echo $html_sale_detail ?>
        </div>  
        <script>
            function Sale_Detail(url) {
                popupWindow = window.open(
                        url, 'History', 'height=600,width=1100');
            }
            function search_sale() {
                var id_sale = $("#id-sale");
                if (id_sale.val() === "show_all")
                {
                    window.location.href = "history_page.php";
                } else {
                    var url = "history_page.php?sale_id=";
                    if (id_sale.val() !== "" && id_sale.val().length === 6) {
                        if (id_sale.val() !== "") {
                            url = url + id_sale.val();
                        }
                        window.location.href = url;
                    } else {
                        alert("กรุณากรอกข้อมูลให้ครบถ้วน");
                    }
                }

            }

        </script>
    </body>
</html>
