<?php

require './connect.php';
$operation = $_GET['operation'];
if ($operation == "select") {
    $sql1 = "SELECT * FROM receive
             INNER JOIN admin
             ON receive.admin_id = admin.admin_id";
    
    $sql2 = "SELECT * FROM purchase
            INNER JOIN supplier
            ON purchase.sup_id = supplier.sup_id
            WHERE pur_status = 'Purchased'";

    $result = mysqli_query($connect, $sql1);
    $result2 = mysqli_query($connect, $sql2);

    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . "<thead>
                    <tr>
                        <th style='text-align:center;'>Receive ID</th>
                        <th style='text-align:center;'>Receive Date</th>
                        <th style='text-align:center;'>InvoiceNo</th>
                        <th style='text-align:center;'>Purchase ID</th>
                        <th style='text-align:center;'>Admin</th>
                    </tr>
                </thead>";

    $html2 = "<select class='form-control' id='pur_id' name='pur_id'>";


    while ($array = mysqli_fetch_array($result)) {
        $html1 = $html1 . "<tr>
                        <td>{$array['recv_id']}</td>
                        <td>".date("d-m-Y H:i:s",strtotime($array['recv_date']))."</td>
                        <td>{$array['invoiceNo']}</td>
                        <td>{$array['pur_id']}</td>
                        <td>{$array['admin_fname']}</td> 
                      </tr>";
    }

    while ($array = mysqli_fetch_array($result2)) {
        $html2 = $html2 . "<option value='{$array['pur_id']}'>{$array['pur_id']} : ".date("d-m-Y H:i:s",strtotime($array['pur_date'])) .": {$array['sup_name']}</option>";
    }

    $html1 = $html1 . "</table>";
    $html2 = $html2 . "</select>";
    $array['html1'] = $html1;
    $array['html2'] = $html2;
    echo json_encode($array);
    mysqli_close($connect);
} else if ($operation == "update") {
    $pur_id = $_REQUEST['pur_id'];
    $invoiceNo = $_REQUEST['invoiceNo'];
    $admin_id = $_REQUEST['admin_id'];

    date_default_timezone_set('Asia/Bangkok');
    $recv_date = date("Y-m-d H:i:s");

    $sql1 = "SELECT max(recv_id)+1 as new_recv_id FROM receive";
    $result1 = mysqli_query($connect, $sql1);
    $array = mysqli_fetch_array($result1);

    if ($array['new_recv_id'] == NULL) {
        $new_recv_id = "000001";
    } else {
        $new_recv_id = sprintf('%06s', $array['new_recv_id']);
    }
    $sql2 = "INSERT into receive values ('$new_recv_id','$recv_date','$invoiceNo','$admin_id','$pur_id')";
    $result2 = mysqli_query($connect, $sql2);

    $sql3 = "UPDATE purchase SET pur_status = 'received' WHERE pur_id = '$pur_id'";
    $result3 = mysqli_query($connect, $sql3);

    
    
    //Update Stock//
    $sql4 = "SELECT * FROM purchase_detail WHERE pur_id = '$pur_id'";
    $result4 = mysqli_query($connect, $sql4);
    while ($array = mysqli_fetch_array($result4)) {
        $sql5 = "SELECT amount FROM sports_equipment WHERE product_id = '{$array['product_id']}'";
        $result5 = mysqli_query($connect, $sql5);
        $array2 = mysqli_fetch_array($result5);

        $amount = $array2['amount'] + $array['pur_amount'];

        $sql6 = "UPDATE sports_equipment SET amount = '$amount' WHERE product_id = '{$array['product_id']}'";
        $result6 = mysqli_query($connect, $sql6);
    }
    echo json_encode($result2);
    mysqli_close($connect);
} else {
    echo "false";
}
?>