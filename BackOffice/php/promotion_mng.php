<?php

require './connect.php';
$operation = $_GET['operation'];

if ($operation == "select") {

    $sql1 = "SELECT * FROM promotion";

    $result = mysqli_query($connect, $sql1);

    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . "<thead>
                    <tr>
                        <th style='text-align:center;'>Promotion ID</th>
                        <th style='text-align:center;'>Name</th>
                        <th style='text-align:center;'>Promotion Detail</th>
                        <th style='text-align:center;'>Start Date</th>
                        <th style='text-align:center;'>End Date</th>
                        <th style='text-align:center;'>Discount</th>
                        <th></th>
                    </tr>
                </thead>";
    
    while ($array = mysqli_fetch_array($result)) {
        $html1 = $html1 . "<tr>
                        <td>{$array['pro_id']}</td>
                        <td>{$array['pro_name']}</td>
                        <td><textarea readonly>{$array['pro_detail']}</textarea></td>
                        <td>".date("d-m-Y H:i:s",strtotime($array['start_date']))."</td>
                        <td>".date("d-m-Y H:i:s",strtotime($array['end_date']))."</td>
                        <td>{$array['discount']}</td>
                        <td><a href='#to-edit'><button type='button' class='btn btn-default' onclick=" . "editPromotion('{$array['pro_id']}')" . ">
                                <span class='glyphicon glyphicon-edit'></span> Edit
                            </button></a>
                            <button type='button' class='btn btn-danger' id='delete-promotion' onclick=" . "deletePromotion('{$array['pro_id']}')>
                                <span class='glyphicon glyphicon-remove'></span> Delete
                            </button>
                        </td>
                    </tr>";
    }


    $html1 = $html1 . "</table>";
    $array['html1'] = $html1;

    echo json_encode($array);
    mysqli_close($connect);
} else if ($operation == "insert") {
    $pro_name = $_REQUEST['pro_name'];
    $pro_detail = $_REQUEST['pro_detail'];
    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];
    $discount = $_REQUEST['discount'];


//Time format
    $datetime1 = str_replace("T", " ", $start_date);
    $datetime1 = $datetime1 . ':00';

    $datetime2 = str_replace("T", " ", $end_date);
    $datetime2 = $datetime2 . ':00';

    $sql1 = "SELECT max(pro_id)+1 as new_pro_id FROM promotion";
    $result = mysqli_query($connect, $sql1);

    $array = mysqli_fetch_array($result);

    if ($array['new_pro_id'] == NULL) {
        $new_pro_id = "000001";
    } else {
        $new_pro_id = sprintf('%06s', $array['new_pro_id']);
    }

    $sql2 = "INSERT into promotion values ('$new_pro_id','$pro_name','$pro_detail','$datetime1','$datetime2','$discount')";
    $result2 = mysqli_query($connect, $sql2);
    echo json_encode($result2);
} else if ($operation == "update") {
    $pro_id = $_REQUEST['pro_id'];
    $pro_name = $_REQUEST['pro_name'];
    $pro_detail = $_REQUEST['pro_detail'];
    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];
    $discount = $_REQUEST['discount'];

//Time format
    $datetime1 = str_replace("T", " ", $start_date);
    $datetime1 = $datetime1 . ':00';

    $datetime2 = str_replace("T", " ", $end_date);
    $datetime2 = $datetime2 . ':00';

    $sql1 = "UPDATE promotion SET pro_name = '$pro_name', pro_detail = '$pro_detail', start_date = '$start_date'"
            . ",end_date = '$end_date', discount='$discount' WHERE pro_id = '$pro_id'";
    $result = mysqli_query($connect, $sql1);
    echo json_encode($result);

    mysqli_close($connect);
} else if ($operation == "delete") {
    $pro_id = $_REQUEST['pro_id'];

    $sql1 = "DELETE FROM promotion WHERE pro_id = '$pro_id'";
    $result = mysqli_query($connect, $sql1);
    if ($result == true) {
        $status['status'] = true;
    } else {
        $status['status'] = false;
    }
    echo json_encode($status);
    mysqli_close($connect);
} else if ($operation == "show_edit") {
    $pro_id = $_REQUEST['pro_id'];
    $sql = "SELECT * FROM promotion where pro_id='$pro_id'";

    $result = mysqli_query($connect, $sql);
    $array = mysqli_fetch_array($result);
    $array['start_date'] = str_replace(" ", "T", $array['start_date']);
    $array['end_date'] = str_replace(" ", "T", $array['end_date']);

    echo json_encode($array);
    mysqli_close($connect);
}
?>