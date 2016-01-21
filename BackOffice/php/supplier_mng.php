<?php

require './connect.php';
$operation = $_GET['operation'];
if ($operation == "select") {
    $sql1 = "SELECT * FROM supplier";

    $result = mysqli_query($connect, $sql1);
    $result2 = mysqli_query($connect, $sql1);
    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . "<thead>
                    <tr>
                        <th style='text-align:center;'>Supplier ID</th>
                        <th style='text-align:center;'>Name</th>
                        <th style='text-align:center;'>Address</th>
                        <th style='text-align:center;'>Email</th>
                        <th style='text-align:center;'>Tel</th>
                        <th style='text-align:center;'>Status</th>
                        <th></th>
                    </tr>
                </thead>";

    while ($array = mysqli_fetch_array($result)) {
        $html1 = $html1 . "<tr>
                        <td>{$array['sup_id']}</td>
                        <td>{$array['sup_name']}</td>
                        <td><textarea readonly>{$array['sup_address']}</textarea></td>
                        <td>{$array['sup_email']}</td>
                        <td>{$array['sup_tel']}</td>
                        <td>{$array['sup_status']}</td>
                        <td>
                            <a href='#to-edit'><button type='button' class='btn btn-default' onclick=" . "editSupplier('{$array['sup_id']}')" . ">
                                <span class='glyphicon glyphicon-edit'></span> Edit
                            </button></a>
                            <button type='button' class='btn btn-danger' id='delete-supplier' onclick=" . "deleteSupplier('{$array['sup_id']}')>
                                <span class='glyphicon glyphicon-remove'></span> Delete
                            </button>
                        </td>
                    </tr>";
    }

    $html1 = $html1 . "</table>";

    $array['html1'] = $html1;
    
    echo json_encode($array);
    mysqli_close($connect);
} elseif ($operation == "insert") {
    $sup_name = $_REQUEST['sup_name'];
    $sup_address = $_REQUEST['sup_address'];
    $sup_email = $_REQUEST['sup_email'];
    $sup_tel = $_REQUEST['sup_tel'];
    $sup_status = $_REQUEST['sup_status'];

    $sql1 = "SELECT max(sup_id)+1 as new_sup_id FROM supplier";
    $result = mysqli_query($connect, $sql1);
    $array = mysqli_fetch_array($result);


    if ($array['new_sup_id'] == NULL) {
        $new_sup_id = "000001";
    } else {
        $new_sup_id = sprintf('%06s', $array['new_sup_id']);
    }

    $sql2 = "INSERT into supplier values ('$new_sup_id','$sup_name','$sup_address','$sup_email','$sup_tel','$sup_status')";
    $result2 = mysqli_query($connect, $sql2);
    echo json_encode($result2);
    mysqli_close($connect);
} elseif ($operation == "update") {
    $sup_id = $_REQUEST['sup_id'];
    $sup_name = $_REQUEST['sup_name'];
    $sup_address = $_REQUEST['sup_address'];
    $sup_email = $_REQUEST['sup_email'];
    $sup_tel = $_REQUEST['sup_tel'];
    $sup_status = $_REQUEST['sup_status'];


    $sql1 = "UPDATE supplier SET sup_name = '$sup_name', sup_address = '$sup_address', sup_email= '$sup_email', "
            . "sup_tel='$sup_tel', sup_status = '$sup_status' WHERE sup_id = '$sup_id'";
    $result = mysqli_query($connect, $sql1);

    echo json_encode($result);
    mysqli_close($connect);
} elseif ($operation == "delete") {
    $sup_id = $_REQUEST['sup_id'];

    $sql1 = "DELETE FROM supplier WHERE sup_id = '$sup_id'";
    $result = mysqli_query($connect, $sql1);

    if ($result == true) {
        $status['status'] = true;
    } else {
        $status['status'] = false;
    }
    echo json_encode($status);
    mysqli_close($connect);
} elseif ($operation == "show_edit") {

    $sup_id = $_REQUEST['sup_id'];
    $sql = "SELECT * from supplier WHERE sup_id='$sup_id'";
    $result = mysqli_query($connect, $sql);
    $array = mysqli_fetch_array($result);

    echo json_encode($array);
} else {
    echo "false";
}
?>