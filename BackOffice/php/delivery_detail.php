<?php
require './connect.php';

session_start();
$admin_id = $_SESSION['admin_id'];

$operation = $_GET['operation'];
if ($operation == "select") {
    $sql1 = "SELECT * FROM delivery
            INNER JOIN admin
            ON delivery.admin_id = admin.admin_id";
    
    $sql2 = "SELECT sale.sale_id , member.member_fname FROM sale 
            INNER JOIN member
            ON sale.member_id = member.member_id
            WHERE sale_status='wait for delivery'";

    $result1 = mysqli_query($connect, $sql1);
    $result2 = mysqli_query($connect, $sql2);

    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . " <thead>
                    <tr>
                        <th style='text-align:center;'>Delivery ID</th>
                        <th style='text-align:center;'>Delivery Date</th>
                        <th style='text-align:center;'>EMS ID</th>
                        <th style='text-align:center;'>Sale ID</th>
                        <th style='text-align:center;'>Admin</th>
                    </tr>
                </thead>";

    $html2 = "<select class='form-control' id='sale_id' name='sale_id'>"
            . "<option></option>";


    while ($array = mysqli_fetch_array($result1)) {
        $html1 = $html1 . "<tr>
                        <td>{$array['delivery_id']}</td>
                        <td>". date("d-m-Y H:i:s",strtotime($array['delivery_date']))."</td>
                        <td>{$array['ems_id']}</td>
                        <td>{$array['sale_id']}</td>
                        <td>{$array['admin_fname']}</td>
                       </tr>";
    }

    while ($array = mysqli_fetch_array($result2)) {
        $html2 = $html2 . "<option value='{$array['sale_id']}'>{$array['sale_id']} : {$array['member_fname']}</option>";
    }

    $html1 = $html1 . "</table>";
    $html2 = $html2 . "</select>";
    
    $array['html1'] = $html1;
    $array['html2'] = $html2;
    echo json_encode($array);
    mysqli_close($connect);
} else if($operation == "update"){
    $sale_id = $_REQUEST['sale_id'];
    $delivery_date = $_REQUEST['delivery_date'];
    $ems_id = $_REQUEST['ems_id'];
    
    $datetime = str_replace("T", " ", $delivery_date);
    $datetime = $datetime . ':00';
    
    $sql1 = "SELECT max(delivery_id)+1 as new_delivery_id FROM delivery";
    $result1 = mysqli_query($connect, $sql1);
    $array = mysqli_fetch_array($result1);

    if ($array['new_delivery_id'] == NULL) {
        $new_delivery_id = "000001";
    } else{
        $new_delivery_id = sprintf('%06s', $array['new_delivery_id']);
    }
    $sql2 = "INSERT into delivery values ('$new_delivery_id','$datetime','$ems_id','$sale_id','$admin_id')";
    $result2 = mysqli_query($connect, $sql2);
    
    $sql3 = "UPDATE sale SET sale_status = 'delivery success' WHERE sale_id = '$sale_id'";
    $result3 = mysqli_query($connect, $sql3);
    
    echo json_encode($result2);
    mysqli_close($connect);
}
else {
    echo "false";
}
?>