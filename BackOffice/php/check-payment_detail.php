<?php

require './connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];
$operation = $_GET['operation'];
if ($operation == "select") {

    $sql1 = "SELECT * FROM payment
            INNER JOIN sale
            INNER JOIN member
            ON payment.sale_id = sale.sale_id AND sale.member_id = member.member_id
            WHERE sale_status = 'wait for checking payment' AND payment_status = 'not payment'";

    $result = mysqli_query($connect, $sql1);
    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . "<thead>
                    <tr>
                        <th style='text-align:center;'>Payment ID</th>
                        <th style='text-align:center;'>Sale ID</th>
                        <th style='text-align:center;'>Member</th>
                        <th style='text-align:center;'>Payment Date</th>
                        <th style='text-align:center;'>Slip</th>
                        <th style='text-align:center;'>Payment Price</th>
                        <th style='text-align:center;'>Total Price</th>
                        <th style='text-align:center;'>Payment Status</th>
                        <th></th>
                    </tr>
                </thead>";
    $html2 = "<select class='form-control' id='payment_id' name='payment_id'>";

    while ($array = mysqli_fetch_array($result)) {
        $total_price = $array['total_salePrice'] - $array['discount_price'];
        $html1 = $html1 . "<tr>
                        <td>{$array['payment_id']}</td>
                        <td>{$array['sale_id']}</td>
                        <td>{$array['member_fname']}</td>
                        <td>".date("d-m-Y H:i:s",strtotime($array['payment_date']))."</td>
                        <td><img src='../../img/{$array['payment_slip']}' width=180px height=200px></td>
                        <td>".number_format($array['payment_price'],2)."</td>    
                        <td>".number_format($total_price,2)."</td>
                        <td>{$array['payment_status']}</td>
                        <td>
                        <button type='button' class='btn btn-primary' onclick=" . "updatePayment('{$array['payment_id']}','{$array['sale_id']}')" . ">
                            <span class='glyphicon glyphicon-ok'></span> Submit
                        </button>
                        <button type='button' class='btn btn-danger' onclick=" . "cancelPayment('{$array['sale_id']}')" . ">
                            <span class='glyphicon glyphicon-remove'></span> Cancel
                        </button>
                        </td> 
                      </tr>";
    }

    $html1 = $html1 . "</table>";

    $array['html1'] = $html1;
    echo json_encode($array);
    mysqli_close($connect);
} else if ($operation == "update") {
    $payment_id = $_REQUEST['payment_id'];
    $sale_id = $_REQUEST['sale_id'];

    $sql1 = "UPDATE sale SET sale_status = 'wait for delivery' WHERE sale_id = '$sale_id'";
    $result1 = mysqli_query($connect, $sql1);

    $sql2 = "UPDATE payment SET payment_status = 'payment', admin_id = '$admin_id' WHERE payment_id = '$payment_id'";
    $result2 = mysqli_query($connect, $sql2);

    $sql3 = "SELECT * FROM sale_detail WHERE sale_id = '$sale_id'";
    $result3 = mysqli_query($connect, $sql3);

    while ($array = mysqli_fetch_array($result3)) {
        $sql4 = "SELECT amount FROM sports_equipment WHERE product_id = '{$array['product_id']}'";
        $result4 = mysqli_query($connect, $sql4);
        $array2 = mysqli_fetch_array($result4);

        $amount = $array2['amount'] - $array['sale_amount'];

        $sql5 = "UPDATE sports_equipment SET amount = '$amount' WHERE product_id = '{$array['product_id']}'";
        $result5 = mysqli_query($connect, $sql5);
    }
} else if ($operation == "cancel") {
    $sale_id = $_REQUEST['sale_id'];

    $sql1 = "UPDATE sale SET sale_status = 'wait for payment' WHERE sale_id = '$sale_id'";
    $result1 = mysqli_query($connect, $sql1);

} else {
    echo "false";
}
?>
