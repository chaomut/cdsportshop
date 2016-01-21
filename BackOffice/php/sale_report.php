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

$sql1 = "SELECT * FROM sale
        WHERE sale_date >= '{$datetime1}' AND sale_date <='{$datetime2}'";
$result1 = mysqli_query($connect, $sql1);

$html1 = "<div class='row'>
            <div class='col-xs-12'>";

if (mysqli_num_rows($result1) > 0) {
    while ($array1 = mysqli_fetch_array($result1)) {
        $report_date = $array1['sale_date'];
        $report_date = date("F, Y", strtotime($report_date));

        $html1 = $html1 . "<div class='panel panel-default'>
                            <div class='panel-heading'>
                                <strong>Sale ID:</strong> {$array1['sale_id']}<br>
                                <strong>Sale Date:</strong> " . date("d-m-Y H:i:s", strtotime($array1['sale_date'])) . "<br>
                                <strong>Member ID:</strong> {$array1['member_id']}<br>    
                                <strong>Total: " . number_format($array1['total_salePrice']) . " ฿</strong>
                            </div>
                            <div class='panel-body'>";

        $sql2 = "SELECT * FROM sale_detail
                    INNER JOIN sports_equipment
                    INNER JOIN category
                    INNER JOIN brand
                    INNER JOIN model
                    ON sale_detail.product_id = sports_equipment.product_id
                    AND sports_equipment.category_id = category.category_id
                    AND sports_equipment.model_id = model.model_id
                    AND brand.brand_id = model.brand_id
                    WHERE sale_detail.sale_id = '{$array1['sale_id']}'
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
                  <td class='text-center' style='border-top: 1px solid;'>{$array2['sale_amount']}</td>   
                  <td class='text-center' style='border-top: 1px solid;'>" . number_format($array2['sale_price'], 2) . "</td></tr>";
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
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="invoice-title">
                        <h2 class="text-center" >C&D SHOP</h2>
                        <h2 class="text-center" >รายงานการขายสินค้า</h2>
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
    $pdf = new mPDF('th', 'A4', '0', '');   //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 

    $pdf->SetAutoFont();

    $pdf->SetDisplayMode('fullpage');
    $stylesheet = file_get_contents('../css/bootstrap.min.css');
    $pdf->WriteHTML($stylesheet, 1);
    $pdf->WriteHTML($html, 2);

    $pdf->Output();
    ?>
</html>