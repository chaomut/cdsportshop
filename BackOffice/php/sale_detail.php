<?php

require './connect.php';
$operation = $_GET['operation'];

if ($operation == "select") {
    $sql1 = "SELECT * FROM sale
            INNER JOIN member
            ON sale.member_id = member.member_id";
    $result = mysqli_query($connect, $sql1);
    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . "<thead>
                    <tr>
                        <th style='text-align:center;'>Sale ID</th>
                        <th style='text-align:center;'>Member</th>
                        <th style='text-align:center;'>Sale Date</th>
                        <th style='text-align:center;'>Total Sale Price</th>
                        <th style='text-align:center;'>Discount Price</th>
                        <th style='text-align:center;'>Delivery Address</th>
                        <th style='text-align:center;'>EMS Price</th>
                        <th style='text-align:center;'>Sale Status</th>
                        <th></th>
                    </tr>
                </thead>";

    while ($array = mysqli_fetch_array($result)) {
        $sql2 = "SELECT * FROM sale_detail
                 INNER JOIN sports_equipment
                 INNER JOIN product_pic
                 ON sale_detail.product_id = sports_equipment.product_id
                 AND sports_equipment.product_id = product_pic.product_id
                 WHERE sale_detail.sale_id = '{$array['sale_id']}'
                 GROUP BY sports_equipment.product_id";
        $result2 = mysqli_query($connect, $sql2);
        $html1 = $html1 . "<tr>
                        <td>{$array['sale_id']}</td>
                        <td>{$array['member_fname']}</td>
                        <td>".date("d-m-Y H:i:s",strtotime($array['sale_date']))."</td>
                        <td>{$array['total_salePrice']}</td>
                        <td>{$array['discount_price']}</td>
                        <td>{$array['delivery_address']}</td>
                        <td>{$array['ems_price']}</td>
                        <td>{$array['sale_status']}</td>
                        <td><button type='button' class='btn btn-info' data-toggle='modal' data-target='#{$array['sale_id']}'>Detail</button>
                            <div class='modal fade' id='{$array['sale_id']}' role='dialog'>
                                <div class='modal-dialog'>
                                     <!-- Modal content-->
                                        <div class='modal-content'>
                                            <div class='modal-header'>   
                                            <h4 class='modal-title'>Sale Detail: {$array['sale_id']}</h4>
                                            </div> ";
        while ($array2 = mysqli_fetch_array($result2)) {
            $html1 = $html1 . "<div class='modal-body'>
                <table class='table table-striped'>
                <tr>
                <td><img src='../../img/{$array2['pic']}' width=100px height=100px><br>
                <strong>Product:</strong> {$array2['product_name']}<br>
                    <strong>Amount:</strong> {$array2['sale_amount']}<br>
                    <strong>Price:</strong> {$array2['sale_price']}<br>
                </td>
                <tr>
                
            </table></div><hr>";
        }
        $html1 = $html1 . "<div class='modal-footer'>
                            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </td>";
    }

    $html1 = $html1 . "</table>";

    $array['html1'] = $html1;

    echo json_encode($array);
    mysqli_close($connect);
} else {
    echo "false";
}
?>