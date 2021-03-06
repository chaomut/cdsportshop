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
$report_date = date("d/m/Y");


$sql1 = "SELECT * FROM sports_equipment
            INNER JOIN category
            INNER JOIN brand
            INNER JOIN model
            ON sports_equipment.category_id = category.category_id
            AND sports_equipment.model_id = model.model_id
            AND brand.brand_id = model.brand_id
            ORDER BY sports_equipment.product_id";

$result1 = mysqli_query($connect, $sql1);

$html1 = "<table class='table table-striped' border='1'>
                                <thead>
                                    <tr>
                                        <td class='text-center' style='border-bottom: 1px solid;'><strong>Product ID</strong></td>
                                        <td class='text-center' style='border-bottom: 1px solid;'><strong>Product</strong></td>
                                        <td class='text-center' style='border-bottom: 1px solid;'><strong>Amount</strong></td>
                                    </tr>
                                </thead>";

while ($array1 = mysqli_fetch_array($result1)) {
    $html1 = $html1 . "<tr>
              <td class='text-center' style='border-top: 1px solid;'>{$array1['product_id']}</td>
              <td style='border-top: 1px solid;'><strong>Product:</strong> {$array1['product_name']}<br>
                  <strong>Category:</strong> {$array1['category_name']}<br>
                  <strong>Brand:</strong> {$array1['brand_name']}<br>
                  <strong>Model:</strong> {$array1['model_name']}<br>  
              </td>
              <td class='text-center' style='border-top: 1px solid;'>{$array1['amount']}</td>
              </td>
          </tr>";
}
$html1 = $html1 . "</table>";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script src="../js/jquery-2.1.4.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>   
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="invoice-title">
                        <h2 class="text-center" >C&D SHOP</h2>
                        <h2 class="text-center" >รายงานสินค้าคงเหลือ ณ ปัจจุบัน</h2>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>วันที่ออกรายงาน: <?php echo $report_date; ?></strong></h3>
                        </div>
                        <div class="panel-body">

                                    <?php echo $html1; ?>      

                        </div>
                    </div>
                </div>
            </div>
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

    $pdf->Output();         
    ?>
</html>