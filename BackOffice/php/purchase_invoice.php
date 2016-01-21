<?php
require_once('../mpdf/mpdf.php');
require './connect.php';
ob_start();
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: ../login_back.php");
    exit();
}


$pur_id = $_GET['pur_id'];

$sql1 = "SELECT * FROM purchase
            INNER JOIN supplier
            ON purchase.sup_id = supplier.sup_id
            WHERE purchase.pur_id = '{$pur_id}'";

$result1 = mysqli_query($connect, $sql1);
$array1 = mysqli_fetch_array($result1);

$sql2 = "SELECT * FROM purchase_detail
                 INNER JOIN sports_equipment
                 INNER JOIN category
                 INNER JOIN brand
                 INNER JOIN model
                 ON purchase_detail.product_id = sports_equipment.product_id
                 AND sports_equipment.category_id = category.category_id
                 AND brand.brand_id = model.brand_id
                 AND sports_equipment.model_id = model.model_id
        WHERE purchase_detail.pur_id = '{$pur_id}'
        GROUP BY sports_equipment.product_id";

$result2 = mysqli_query($connect, $sql2);
$html1 = "";

while ($array2 = mysqli_fetch_array($result2)) {
    $total = $array2['pur_amount'] * $array2['pur_price'];

    $html1 = $html1 . "<tr>
              <td style='border-top: 1px solid;'><br><strong>Product:</strong> {$array2['product_name']}<br>
                  <strong>Category:</strong> {$array2['category_name']}<br>
                  <strong>Brand:</strong> {$array2['brand_name']}<br>
                  <strong>Model:</strong> {$array2['model_name']}<br>  
              </td>
              <td class='text-center' style='border-top: 1px solid;'>" . number_format($array2['pur_price'], 2) . "</td>
              <td class='text-center' style='border-top: 1px solid;'>{$array2['pur_amount']}</td>
              <td class='text-right' style='border-top: 1px solid;'>" . number_format($total, 2) . "</td>
          </tr>";
}
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
                <div class="col-sm-12">
                    <div class="invoice-title">
                        <h2>C&D SHOP</h2><h3 class="text-right">Purchase ID: <?php echo $array1['pur_id'] ?></h3>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <address>
                                <strong>Billed To:</strong><br>
                                <?php echo $array1['sup_name'] ?><br>
                                <?php echo $array1['sup_address'] ?><br>
                                Email: <?php echo $array1['sup_email'] ?><br>
                                Tel: <?php echo $array1['sup_tel'] ?>
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <address>
                                <strong>Purchase Date:</strong><br>
                                <?php echo date("d-m-Y H:i:s", strtotime($array1['pur_date'])); ?><br><br>
                            </address>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>Purchase Order</strong></h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="border-bottom: 1px solid;"><strong>Item</strong></th>
                                        <th class="text-center" style="border-bottom: 1px solid;"><strong>Price</strong></th>
                                        <th class="text-center" style="border-bottom: 1px solid;"><strong>Amount</strong></th>
                                        <th class="text-right" style="border-bottom: 1px solid;"><strong>Totals</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $html1; ?>      
                                    <tr>
                                        <td style="border-top: 2px solid;"></td>
                                        <td style="border-top: 2px solid;"></td>
                                        <td style="border-top: 2px solid;"></td>
                                        <td style="border-top: 2px solid;"></td>
                                    </tr>    
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <h4><strong>Total: </strong><?php echo number_format($array1['total_Purchase_Price'], 2); ?> ฿</h4>
                                </div>
                            </div>
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

    $pdf->Output();         // เก็บไฟล์ html ที่แปลงแล้วไว้ใน MyPDF/MyPDF.pdf ถ้าต้องการให้แสด
    ?>
</html>