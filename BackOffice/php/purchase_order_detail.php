<?php
////////////////////Show Purshase Order/////////////////////////////////////////
session_start();
require '../php/connect.php';
$html1 = "";
$html2 = "";
$html3 = "";
$html4 = "";
$totalPurshasePrice = 0;
$totalPrice = 0;
if (isset($_SESSION['purchase'])) {

    $html1 = "<table class='table table-striped'>"
            . "<thead>
                    <tr>
                        <th style='text-align:center;'>Product ID</th>
                        <th style='text-align:center;'>Product Pic</th>
                        <th style='text-align:center;'>Amount</th>
                        <th style='text-align:center;'>Price</th>
                        <th style='text-align:center;'>Total Price</th>
                        <th></th>            
                    </tr>
                </thead>";
    if (isset($_SESSION['purchase'])) {
        for ($i = 0; $i < count($_SESSION['purchase']); $i++) {
            $value = $_SESSION['purchase'][$i];
            $temp = json_decode($value, true);
            
            if (isset($temp['product_id'])) {
                $sql1 = "SELECT * FROM sports_equipment
                        INNER JOIN product_pic
                        ON sports_equipment.product_id = product_pic.product_id
                        WHERE  sports_equipment.product_id = {$temp['product_id']}";

                $result1 = mysqli_query($connect, $sql1);
                $array = mysqli_fetch_array($result1);
                
                $totalPrice = $temp['price'] * $temp['amount'];
                $totalPurshasePrice += $totalPrice;
                
                $html1 = $html1 . "<tr>
                        <td>{$array['product_id']}</td>
                        <td><img src='../../img/{$array['pic']}' width=50px height=50px></td>
                        <td><input type='number' min='1' id='amount{$array['product_id']}' max='999' class='form-control' value='{$temp['amount']}'
                                            onchange=" . "updatePurchase('{$array['product_id']}')></td>
                        <td><input type='number' id='price{$array['product_id']}' class='form-control' max = '10000000000' 
                                            onchange=" . "updatePurchase('{$array['product_id']}')". 
                                            " value='{$temp['price']}'></td>
                        <td><input readonly type='text' class='form-control' value='{$totalPrice}'></td>
                        <td><button type='button' class='btn btn-danger' onclick=" . "delPurchase('{$array['product_id']}')" . ">
                                        <span class='glyphicon glyphicon-remove'></span> Delete
                                    </button></td>
                      </tr>";
            }
        }
    }
    
    $sql2 = "SELECT * FROM supplier WHERE sup_status = 'Enabled'";
    $result2 = mysqli_query($connect, $sql2);
    $html2 = "<select class='form-control' id='sup_id' name='sup_id'>"
            . "<option></option>";
    while ($array = mysqli_fetch_array($result2)) {
        $html2 = $html2 . "<option value='{$array['sup_id']}'>{$array['sup_name']}</option>";
    }
    
    $html1 = $html1 . "<tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><h5><strong>Total Purchase Price:</strong></h5></td>
                        <td><h5><strong>".number_format($totalPurshasePrice,2)." ฿</strong></h5>
                        <input type='text' id='totalPurshasePrice' hidden value= {$totalPurshasePrice}>    
                        </td>
                       </tr></table>";

    $html2 = $html2 . "</select>";

    $html3 = "<button type='button' class='btn btn-success' id='save-purchase'>
                     <span class='glyphicon glyphicon-file'></span> Purchase
              </button>";
    $html4 = "<label class='col-sm-2 control-label'>Supplier:</label>";
}
?>

