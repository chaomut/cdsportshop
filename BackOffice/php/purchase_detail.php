<?php

require './connect.php';
$operation = $_GET['operation'];

if ($operation == "select") {

    $sql1 = "SELECT * FROM purchase
            INNER JOIN purchase_detail
            INNER JOIN supplier
            INNER JOIN admin
            ON purchase.pur_id = purchase_detail.pur_id
            AND purchase.sup_id = supplier.sup_id
            AND purchase.admin_id = admin.admin_id
            WHERE purchase.pur_status = 'Purchased'
            GROUP BY purchase.pur_id";

    $result = mysqli_query($connect, $sql1);
    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . "<thead>
                    <tr>
                        <th style='text-align:center;'>Purchase ID</th>
                        <th style='text-align:center;'>Product</th>
                        <th style='text-align:center;'>Purchase Date</th>
                        <th style='text-align:center;'>Total Price</th>
                        <th style='text-align:center;'>Supplier ID</th>
                        <th style='text-align:center;'>Admin</th>
                        <th style='text-align:center;'>Purchase Status</th>
                        <th></th>
                    </tr>
                </thead>";


    while ($array = mysqli_fetch_array($result)) {
        $sql2 = "SELECT * FROM purchase_detail
                 INNER JOIN sports_equipment
                 INNER JOIN product_pic
                 ON purchase_detail.product_id = sports_equipment.product_id
                 AND sports_equipment.product_id = product_pic.product_id
                 WHERE purchase_detail.pur_id = '{$array['pur_id']}'
                 GROUP BY sports_equipment.product_id";
        $result2 = mysqli_query($connect, $sql2);

        $html1 = $html1 . "<tr>
                           <td>{$array['pur_id']}</td>
                            <td>
                                <button type='button' class='btn btn-info' data-toggle='modal' data-target='#{$array['pur_id']}'>Detail</button>                                      
                             <div class='modal fade' id='{$array['pur_id']}' role='dialog'>
                                <div class='modal-dialog'>
                                     <!-- Modal content-->
                                        <div class='modal-content'>
                                            <div class='modal-header'>   
                                            <h4 class='modal-title'>Purchase Detail: {$array['pur_id']}</h4>
                                            </div> ";
        while ($array2 = mysqli_fetch_array($result2)) {
            $html1 = $html1 . "<div class='modal-body'>
                                    <table class='table table-striped'>
                                    <tr>
                                    <td><img src='../../img/{$array2['pic']}' width=100px height=100px><br>
                                        <strong>Product:</strong> {$array2['product_name']}<br>
                                        <strong>Amount:</strong> {$array2['pur_amount']}<br>
                                        <strong>Price:</strong> {$array2['pur_price']} ฿<br>
                                    </td>
                                    </tr>
                                    </table>
                                </div><hr>";
        }
        $html1 = $html1 . "<div class='modal-footer'>
                                <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>";

        $html1 = $html1 . "<td>{$array['pur_date']}</td>
                            <td>{$array['total_Purchase_Price']}</td>
                            <td>{$array['sup_name']}</td>
                            <td>{$array['admin_fname']}</td>
                            <td>{$array['pur_status']}</td>
                            <td>
                                <button type='button' class='btn btn-primary' id='print-purchase' onclick=" . "printPurchase('{$array['pur_id']}')".">
                                <span class='glyphicon glyphicon-print'></span> Print
                                </button>
                            </td>
                        </tr>";

    }

    $html1 = $html1 . "</table>";

    
    $array['html1'] = $html1;

    echo json_encode($array);
    mysqli_close($connect);
} else {
    echo "false";
}
?>