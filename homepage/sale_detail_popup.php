<?php
error_reporting(E_ALL^E_WARNING);
$sale_id = $_GET['sale_id'];
session_start();
require '../cancel_sale.php';
require './php/connect.php';
$member_id = $_SESSION['member_id'];
$sql = "SELECT sale_status,sale_id
        FROM sale 
        WHERE sale_id='$sale_id' AND member_id='$member_id'";
$result = mysqli_query($connect, $sql);
if (mysqli_num_rows($result) <= 0) {
    echo "<script> window.close()</script>";
    exit();
}
$discount_price = 0;
$delivery_price = 0;
$total_salePrice = 0;
require './php/connect.php';
$sql1_for_product = "SELECT * FROM sale 
                    INNER JOIN sale_detail ON sale.sale_id=sale_detail.sale_id
                    INNER JOIN sports_equipment ON sports_equipment.product_id=sale_detail.product_id
                    INNER JOIN product_pic ON product_pic.product_id=sale_detail.product_id
                    INNER JOIN model ON sports_equipment.model_id=model.model_id
                    INNER JOIN brand ON model.brand_id=brand.brand_id
                    INNER JOIN category ON sports_equipment.category_id=category.category_id
                    WHERE sale.sale_id='$sale_id'
                    GROUP BY sports_equipment.product_id";
$sql2_for_payment = "SELECT payment.payment_date,payment.payment_slip,payment.payment_status,payment.payment_price,sale.sale_date,sale.sale_status
                    FROM sale
                    INNER JOIN payment ON sale.sale_id=payment.sale_id
                    WHERE sale.sale_id='$sale_id'";
$sql3_for_delivery = "SELECT delivery.delivery_date,delivery.ems_id,sale.delivery_address
                    FROM sale
                    INNER JOIN delivery ON delivery.sale_id=sale.sale_id
                    WHERE sale.sale_status = 'delivery success' AND sale.sale_id='$sale_id'";
$sql4_for_receipt = "SELECT * FROM sale 
                    INNER JOIN sale_detail ON sale.sale_id= sale_detail.sale_id
                    INNER JOIN sports_equipment ON sports_equipment.product_id = sale_detail.product_id
                    INNER JOIN member ON member.member_id=sale.member_id
                    WHERE sale.sale_id='$sale_id' AND (sale.sale_status='delivery success' OR sale.sale_status='wait for delivery')";
////////////////////////////////////////////////////////////////////
$result1_for_product = mysqli_query($connect, $sql1_for_product);
$html1_for_product = "<div class='col-sm-2' style='width:100%; height: 75%; overflow-y: scroll'>
    <table class='table table-hover'>
                <thead>
                    <tr>
                        <th><h4>ชื่อสินค้า</h4></th>
                        <th><h4>รายละเอียดสินค้า</h4></th>
                        <th class='text-center'><h4>จำนวน</h4></th>
                        <th class='text-center'><h4>ราคา</h4></th>
                    </tr>
                </thead>
                <tbody>";
while ($array1_for_product = mysqli_fetch_array($result1_for_product)) {
    $delivery_price = $array1_for_product['ems_price'];
    $discount_price = $array1_for_product['discount_price'];
    $total_salePrice = $array1_for_product['total_salePrice'];
    $totalPrice = $array1_for_product['sale_price'] * $array1_for_product['sale_amount'];
    $html1_for_product = $html1_for_product . "<tr>
                        <td><h5>{$array1_for_product['product_name']}</h5></td>
                        <td></td>
                        <td class='text-center'><h5>{$array1_for_product['sale_amount']}</h5></td>
                        <td class='text-right'><h5>" . number_format($totalPrice, 2) . "</h5></td>
                    </tr>
                     <tr>
                        <td>
                            <a href='product_detail_page.php?product_id={$array1_for_product['product_id']}'>
                                <img src='../img/{$array1_for_product['pic']}' width='150px' height='150px'>
                            </a>
                        </td>
                        <td>
                             <h5><strong>Name</strong> : {$array1_for_product['product_name']}</h5> 
                             <h5><strong>Brand</strong> : {$array1_for_product['brand_name']}</h5> 
                             <h5><strong>Model</strong> : {$array1_for_product['model_name']}</h5> 
                             <h5><strong>Category</strong> : {$array1_for_product['category_name']}</h5> 
                             <h5><p style='color:{$array1_for_product['color']}'><strong>Color</strong> {$array1_for_product['color']}</h5> </p>                     
                        </td>                                      
                    </tr>";
}
$html1_for_product = $html1_for_product . "<tr>
                    <td></td>          
                    <td></td>
                    <td class='text-right'><h5>ส่วนลดโปรโมชั่น</h5></td>
                    <td class='text-right'><h5><strong>" . number_format($discount_price, 2) . "</strong></h5> </td>
                </tr>
                <tr>
                    <td></td>                 
                    <td></td>
                    <td class='text-right'><h5>ค่าจัดส่ง</h5></td>
                    <td class='text-right'><h5><strong>" . number_format($delivery_price, 2) . "</strong</h5></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class='text-right'><h5>ยอดรวมสุทธิ</h5></td>
                    <td class='text-right'><h5><strong>" . number_format($total_salePrice - $discount_price, 2) . "</strong></h5></td>
                </tr>
         </tbody>
    </table></div>";
////////////////////////////////////////////////////////////////////

$result2_for_payment = mysqli_query($connect, $sql2_for_payment);
if (mysqli_num_rows($result2_for_payment) > 0) {
    $array2_for_payment = mysqli_fetch_array($result2_for_payment);
    $html2_for_payment = "<h4>หลักฐานการโอนเงิน</h4><hr>
                        <div class='col-sm-6'>
                            <img src='../img/{$array2_for_payment['payment_slip']}' width='100%' height='75%'>
                        </div>
                        <div class='col-sm-6'>
                            <h5><strong>รหัสการสั่งซื้อ : </strong> {$sale_id}</h5><hr>
                            <h5><strong>วัน-เวลาที่สั่งซื้อ : </strong> {$array2_for_payment['sale_date']}</h5><hr>
                            <h5><strong>วัน-เวลาที่ชำระเงิน : </strong> {$array2_for_payment['payment_date']}</h5><hr>
                            <h5><strong>จำนวนเงินที่โอน : </strong>" . number_format($array2_for_payment['payment_price'], 2) . "</h5><hr>";
    if ($array2_for_payment['payment_status'] == "payment" || $array2_for_payment['sale_status'] == "delivery success" || $array2_for_payment['sale_status'] == "wait for delivery") {
        $html2_for_payment = $html2_for_payment . "<h5><strong>สถานะการชำระเงิน :</strong> ตรวจสอบเรียบร้อย...</h5><hr>
                        </div>";
    } else {
        $html2_for_payment = $html2_for_payment . "<h5><strong>สถานะการชำระเงิน :</strong> รอการตรวจสอบ...</h5><hr>
                            <button class='btn btn-danger' onclick=" . "delPayment('$sale_id')" . "><span class='glyphicon glyphicon-remove'> ยกเลิกการชำระเงิน </span></button>
                        </div>";
    }
} else {
    $html2_for_payment = "<br>
        <div class='alert alert-warning'>
        <a href='payment_page.php' target='_blank' onclick='window.close();' class='btn btn-xs btn-warning pull-right'>แจ้งชำระเงิน</a>
        <strong>ขออภัย ! :</strong> กรุณาชำระเงินภายในวันที่กำหนด หากชำระเงินแล้วกรุณาแจ้งชำระเงิน !
        </div>";
}
/////////////////////////////////////////////////////////////////////////
$result3_for_delivery = mysqli_query($connect, $sql3_for_delivery);
if (mysqli_num_rows($result3_for_delivery) > 0) {
    $array3_for_delivery = mysqli_fetch_array($result3_for_delivery);
    $html3_for_delivery = " <h4>ข้อมูลการจัดส่ง</h4>
                        <div class='col-sm-6'>
                            <iframe src='http://emsbot.com/#/?s=" . strtoupper($array3_for_delivery['ems_id']) . "' height='70%' width='85%'></iframe>
                        </div>
                        <div class='col-sm-6'>
                            <h5><strong>รหัสการสั่งซื้อ : </strong> {$sale_id}</h5><hr>
                            <h5><strong>วัน-เวลาส่งสินค้า : </strong> {$array3_for_delivery['delivery_date']}</h5><hr>
                            <h5><strong>ที่อยู่ในการรับสินค้า :</strong> {$array3_for_delivery['delivery_address']} </h5><hr>
                            <h4><strong>EMS : </strong>" . strtoupper($array3_for_delivery['ems_id']) . "</h4><hr>
                        </div>";
} else {
    $html3_for_delivery = "<br>
        <div class='alert alert-info'>
        <a href='payment_page.php' target='_blank' onclick='window.close();' class='btn btn-xs btn-info pull-right'>ตรวจสอบสถานะ</a>
        <strong>ขออภัย ! : </strong> อยู่ระหว่างรอการจัดส่ง
        </div>";
}
////////////////////////////////////////////////////////////////////////////////
$html4_for_receipt = "<button class='btn btn-info' onclick='printReceipt();' ><span class='glyphicon glyphicon-print'></span> Print</button>
                        <div id='receipt'>
                            <div class='container'>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                        <div class='invoice-title'>";
$result4_for_receipt = mysqli_query($connect, $sql4_for_receipt);
$result5_for_receipt = mysqli_query($connect, $sql4_for_receipt);
if (mysqli_num_rows($result4_for_receipt) > 0) {
    $array4_for_receipt = mysqli_fetch_array($result4_for_receipt);
    $member_name = $array4_for_receipt['member_fname'] . " " . $array4_for_receipt['member_lname'];
    $address1 = $array4_for_receipt['member_address'];
    $newaddress1 = str_ireplace("แขวง", "<br/>แขวง", $address1);
    $newaddress1 = str_ireplace("เขต", "<br/>เขต", $newaddress1);
    $newaddress1 = str_ireplace("จังหวัด", "<br/>จังหวัด", $newaddress1);
    $address2 = $array4_for_receipt['delivery_address'];
    $newaddress2 = str_ireplace("แขวง", "<br/>แขวง", $address2);
    $newaddress2 = str_ireplace("เขต", "<br/>เขต", $newaddress2);
    $newaddress2 = str_ireplace("จังหวัด", "<br/>จังหวัด", $newaddress2);
    $html4_for_receipt = $html4_for_receipt . "<h3 class='pull-right'>Sale # {$array4_for_receipt['sale_id']}</h3>
                                                    </div>
                                                    <hr>
                                                    <div class='row'>
                                                        <div class='col-xs-6'>
                                                        <strong>Receipt TO:</strong><br>  {$member_name} <br>" . nl2br($newaddress1) .
            "</div>
                                                    <div class='col-xs-6'>
                                                        <div class='text-right'>
                                                            <strong>Shipping TO:</strong><br>" . nl2br($newaddress2) .
            "<br><br>
                                                            <strong>Order Date:</strong><br> {$array4_for_receipt['sale_date']}
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='col-sm-12'>
                                                <div class='panel panel-default'>
                                                    <div class='panel-heading'>
                                                        <h3 class='panel-title'><strong>รายการสั่งซื้อ</strong></h3>
                                                    </div>
                                                    <div class='panel-body'>

                                                        <table class='table table-hover'>
                                                            <thead>
                                                                <tr>
                                                                    <td class='text-center'><strong>รหัสสินค้า</strong></td>
                                                                    <td class='text-center'><strong>ชื่อสินค้า</strong></td>
                                                                    <td class='text-center'><strong>จำนวน</strong></td>
                                                                    <td class='text-right'><strong>ราคา</strong></td>
                                                                    <td class='text-right'><strong>รวม</strong></td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>";
    while ($array5_for_receipt = mysqli_fetch_array($result5_for_receipt)) {
        $html4_for_receipt = $html4_for_receipt . "<tr>
                                                        <td class='text-left'><h5>{$array5_for_receipt['product_id']}</h5></td>
                                                        <td class='text-left'><h5>{$array5_for_receipt['product_name']}</h5> </td>
                                                        <td class='text-center'><h5>{$array5_for_receipt['sale_amount']}</h5></td>
                                                        <td class='text-right'><h5>" . number_format($array5_for_receipt['sale_price'], 2) . "</h5></td>
                                                        <td class='text-right'><h5>" . number_format(($array5_for_receipt['sale_price'] * $array5_for_receipt['sale_amount']), 2) . "</h5></td>
                                                    </tr>";
    }
    $html4_for_receipt = $html4_for_receipt . "<tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class='text-right'><h5><strong>ส่วนลด</strong></h5></td>
                                                    <td class='text-right'><h5>" . number_format($array4_for_receipt['discount_price'], 2) . "</h5></td>
                                               </tr>
                                               <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class='text-right'><h5><strong>ค่าจัดส่ง</strong></h5></td>
                                                    <td class='text-right'><h5>" . number_format($array4_for_receipt['ems_price'], 2) . "</h5></td>
                                               </tr>                        
                                               <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class='text-right'><h5><strong>ทั้งหมด</strong></h5></td>
                                                    <td class='text-right'><h5>" . number_format($array4_for_receipt['total_salePrice'] - $array4_for_receipt['discount_price'], 2) . "</h5></td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>";
} else {
    $html4_for_receipt = "<br>
                            <div class='alert alert-warning'>
                            <a href='history_page.php?sale_id={$sale_id}' target='_blank' onclick='window.close();' class='btn btn-xs btn-warning pull-right'>ตรวจสอบสถานะคลิก</a>
                            <strong>ขออภัย ! :</strong> กำลังตรวจสอบการชำระเงิน..  หรือ  การสั่งซื้อของคุณยังไม่ได้ชำระเงิน , ถูกยกเลิกการสั่งซื้อ
                            </div>";
}
?>
<html>
    <head>
        <title> Sale Detail</title>
        <meta charset="UTF-8">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container">
            <div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#product" aria-controls="product" role="tab" data-toggle="tab">รายการสินค้า</a></li>
                    <li role="presentation"><a href="#payment" aria-controls="payment" role="tab" data-toggle="tab">การชำระเงิน</a></li>
                    <li role="presentation"><a href="#delivery" aria-controls="delivery" role="tab" data-toggle="tab">หมายเลข EMS</a></li>
                    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Print</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="product">
                        <?php echo $html1_for_product; ?>
                    </div>
                    <div  class="tab-pane" id="payment">
                        <?php echo $html2_for_payment ?>
                    </div>
                    <div  class="tab-pane" id="delivery">
                        <?php echo $html3_for_delivery ?>
                    </div>
                    <div  class="tab-pane" id="settings">
                        <?php echo $html4_for_receipt ?>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
</div>
</div>
</div>
<script>
    function printReceipt() {
        var divContents = $("#receipt").html();
        var printWindow = window.open('', '', 'height=650,width=1000');
        printWindow.document.write('<html><head><title>Receipt</title>');
        printWindow.document.write('<link' + ' ' + 'href="css/bootstrap.min.css"' + ' ' + 'rel="stylesheet"' + ' ' + 'type="text/css">');
        printWindow.document.write('<script' + ' ' + 'src="js/jquery-1.11.3.min.js"' + ' ' + 'type="text/javascript">' + ' ' + '<' + '/' + 'script>');
        printWindow.document.write('<script' + ' ' + 'src="js/bootstrap.min.js""' + ' ' + 'type="text/javascript">' + ' ' + '<' + '/' + 'script>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
    function  delPayment(sale_id) {
        var login = confirm("คำเตือน ! ต้องการลบข้อมูลการชำระเงิน จริงหรือไม่");
        if (login === true) {
            $.post("./php/save_Payment.php?del", {
                "sale_id": sale_id
            }, function (data) {
            }, "json");
            location.reload();
        }
    }
</script>
</body>
</html>
