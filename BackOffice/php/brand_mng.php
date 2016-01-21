<?php
require './connect.php';
$operation = $_GET['operation'];

if ($operation == "select") {
    $sql1 = "SELECT * FROM brand";
    $result = mysqli_query($connect, $sql1);
    
    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . " <thead>
                    <tr>
                        <th style='text-align:center;'>Brand ID</th>
                        <th style='text-align:center;'>Name</th>
                        <th style='text-align:center;'>Status</th>
                        <th></th>
                    </tr>
                </thead>";

    while ($array = mysqli_fetch_array($result)) {
        $html1 = $html1 . "<tr>
                        <td>{$array['brand_id']}</td>
                        <td>{$array['brand_name']}</td>
                        <td>{$array['brand_status']}</td>
                        <td><a href='#to-edit'><button type='button' class='btn btn-default' onclick=" . "editBrand('{$array['brand_id']}')" . ">
                                <span class='glyphicon glyphicon-edit'></span> Edit
                            </button></a>
                            <button type='button' class='btn btn-danger' id='delete-brand' onclick=" . "deleteBrand('{$array['brand_id']}')>
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
    $brand_name = $_REQUEST['brand_name'];
    $brand_status = $_REQUEST['brand_status'];

    $sql1 = "SELECT max(brand_id)+1 as new_brand_id FROM brand";
    $result = mysqli_query($connect, $sql1);

    $array = mysqli_fetch_array($result);

    if ($array['new_brand_id'] == NULL) {
        $new_brand_id = "000001";
    } else {
        $new_brand_id = sprintf('%06s', $array['new_brand_id']);
    }

    $sql2 = "INSERT into brand values ('$new_brand_id','$brand_name','$brand_status')";
    $result2 = mysqli_query($connect, $sql2);
    echo json_encode($result2);
    mysqli_close($connect);
} elseif ($operation == "update") {
    $brand_id = $_REQUEST['brand_id'];
    $brand_name = $_REQUEST['brand_name'];
    $brand_status = $_REQUEST['brand_status'];


    $sql1 = "UPDATE brand SET brand_name = '$brand_name', brand_status = '$brand_status' WHERE brand_id = '$brand_id'";
    $result = mysqli_query($connect, $sql1);

    echo json_encode($result);
    mysqli_close($connect);
} elseif ($operation == "delete") {
    $brand_id = $_REQUEST['brand_id'];

    $sql1 = "DELETE FROM brand WHERE brand_id = '$brand_id'";
    $result = mysqli_query($connect, $sql1);
    if ($result == true) {
        $status['status'] = true;
    } else {
        $status['status'] = false;
    }
    echo json_encode($status);
    mysqli_close($connect);
} elseif ($operation == "show_edit") {
    $brand_id = $_REQUEST['brand_id'];
    $sql = "SELECT * FROM brand WHERE brand_id='$brand_id'";
    $result = mysqli_query($connect, $sql);
    $array = mysqli_fetch_array($result);

    echo json_encode($array);
    mysqli_close($connect);
} else {

    echo "false";
}
?>