<?php
require '../mpdf/mpdf.php';
require './connect.php';
ob_start();
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: ../login_back.php");
    exit();
}

date_default_timezone_set('Asia/Bangkok');
$report_date2 = date("d/m/Y");


$startdate = $_GET['startdate'];
$enddate = $_GET['enddate'];

$datetime1 = str_replace("T", " ", $startdate);
$datetime1 = $datetime1 . ':00';

$datetime2 = str_replace("T", " ", $enddate);
$datetime2 = $datetime2 . ':00';

$report_date = date('d-m-Y h:i:s',strtotime($datetime1)). " to " . date('d-m-Y h:i:s',strtotime($datetime2));


$sql1 = "SELECT * FROM purchase
            INNER JOIN supplier
            INNER JOIN admin
            ON purchase.sup_id = supplier.sup_id
            AND purchase.admin_id = admin.admin_id
            WHERE purchase.pur_date >= '{$datetime1}' AND purchase.pur_date <= '{$datetime2}'";
$result1 = mysqli_query($connect, $sql1);

$html1 = "<div class='row'>
            <div class='col-xs-12'>";

if (mysqli_num_rows($result1) > 0) {
    while ($array1 = mysqli_fetch_array($result1)) {
        
        $html1 = $html1 . "<div class='panel panel-default'>
                            <div class='panel-heading'>
                                <strong>Purchase ID:</strong> {$array1['pur_id']}<br>
                                <strong>Purchase Date:</strong> {$array1['pur_date']}<br>
                                <strong>Supplier:</strong> {$array1['sup_name']}<br>
                                <strong>Admin:</strong> {$array1['admin_fname']} {$array1['admin_lname']}<br>    
                                <strong>Total: " . number_format($array1['total_Purchase_Price']) . " ฿</strong>
                                    
                            </div>
                            <div class='panel-body'>";
                                
        $sql2 = "SELECT * FROM purchase_detail
                 INNER JOIN sports_equipment
                 INNER JOIN category
                 INNER JOIN brand
                 INNER JOIN model
                 ON purchase_detail.product_id = sports_equipment.product_id
                 AND sports_equipment.category_id = category.category_id
                 AND brand.brand_id = model.brand_id
                 AND sports_equipment.model_id = model.model_id
                 WHERE purchase_detail.pur_id = '{$array1['pur_id']}'
                 GROUP BY sports_equipment.product_id";

        $result2 = mysqli_query($connect, $sql2);

        $html1 = $html1 . "<table class='table table-striped' border='1'>
            <thead>
                <tr>
                    <td class='text-center' style='border-bottom: 1px solid;'><strong>Product ID</strong></td>
                    <td class='text-center' style='border-bottom: 1px solid;'><strong>Product</strong></td>
                    <td class='text-center' style='border-bottom: 1px solid;'><strong>Amount</strong></td>
                    <td class='text-center' style='border-bottom: 1px solid;'><strong>Price</strong></td>
                </tr>
           </thead>";
        while ($array2 = mysqli_fetch_array($result2)) {
            $html1 = $html1 . "<tr><td class='text-center' style='border-top: 1px solid;'>{$array2['product_id']}</td>
                   <td style='border-top: 1px solid;'><strong>Product:</strong> {$array2['product_name']}<br>
                  <strong>Category:</strong> {$array2['category_name']}<br>
                  <strong>Brand:</strong> {$array2['brand_name']}<br>
                  <strong>Model:</strong> {$array2['model_name']}<br>
                  </td>    
                  <td class='text-center' style='border-top: 1px solid;'>{$array2['pur_amount']}</td>   
                  <td class='text-center' style='border-top: 1px solid;'>" . number_format($array2['pur_price'], 2) . "</td></tr>";
        }
        $html1 = $html1 . "</table></div></div>";
    }
}
$html1 = $html1 . "</div>
                </div>";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/purchase.js"></script>    
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="invoice-title">
                        <h2 class="text-center" >C&D SHOP</h2>
                        <h2 class="text-center" >รายงานการสั่งซื้อสินค้า</h2>
                        <h3 class="text-center"><?php echo $report_date; ?></h3>
                    </div>
                    <hr> 
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>วันออกรายงาน:</strong> <?php echo $report_date2; ?><br>
                        <br><br>
                    </address>
                </div>
            </div>
            <?php echo $html1; ?>     
        </div>
    </body>
    <?php
    $html = ob_get_contents();        //เก็บค่า html ไว้ใน $html
    ob_end_clean();
    $pdf = new mPDF('th', 'A4', '0', '');   //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L

    $pdf->SetAutoFont();

    $pdf->SetDisplayMode('fullpage');
    $stylesheet = file_get_contents('../css/bootstrap.min.css');
    $pdf->WriteHTML($stylesheet, 1);
    $pdf->WriteHTML($html, 2);

    $pdf->Output();         // เก็บไฟล์ html ที่แปลงแล้วไว้ใน MyPDF/MyPDF.pdf ถ้าต้องการให้แสด
    ?>
</html>