<?php

require './connect.php';
$operation = $_GET['operation'];

if ($operation == "select") {
    $sql1 = "SELECT * FROM model
            INNER JOIN brand
            ON model.brand_id = brand.brand_id
            ORDER BY model.model_id";

    $sql2 = "SELECT * FROM brand
            ORDER BY brand_name";

    $result1 = mysqli_query($connect, $sql1);
    $result2 = mysqli_query($connect, $sql2);
    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . "<thead>
                    <tr>
                        <th style='text-align:center;'>Model ID</th>
                        <th style='text-align:center;'>Brand</th>
                        <th style='text-align:center;'>Model</th>
                        <th style='text-align:center;'>Status</th>
                        <th></th>
                    </tr>
           </thead>";
    $html2 = "<select class='form-control' id='brand_list' name='brand_list'>"
            . "<option></option>";
    $html3 = "<select class='form-control' id='brand_list_edit' name='brand_list_edit'>"
            . "<option></option>";
    while ($array = mysqli_fetch_array($result1)) {
        $html1 = $html1 . "<tr>
                        <td>{$array['model_id']}</td>
                        <td>{$array['brand_name']}</td>
                        <td>{$array['model_name']}</td>
                        <td>{$array['model_status']}</td>   
                            <td>
                            <a href='#to-edit'><button type='button' class='btn btn-default' onclick=" . "editModel('{$array['model_id']}')" . ">
                                <span class='glyphicon glyphicon-edit'></span> Edit
                            </button></a>
                            <button type='button' class='btn btn-danger' id='delete-model' onclick=" . "deleteModel('{$array['model_id']}')>
                                <span class='glyphicon glyphicon-remove'></span> Delete
                            </button>
                            </td>
                      </tr>";
    }

    while ($array = mysqli_fetch_array($result2)) {
        $html2 = $html2 . "<option value='{$array['brand_id']}'>{$array['brand_name']}</option>";
        $html3 = $html3 . "<option value='{$array['brand_id']}'>{$array['brand_name']}</option>";
    }


    $html1 = $html1 . "</table>";
    $html2 = $html2 . "</select>";
    $html3 = $html3 . "</select>";


    $array['html1'] = $html1;
    $array['html2'] = $html2;
    $array['html3'] = $html3;

    echo json_encode($array);
    mysqli_close($connect);
} elseif ($operation == "insert") {
    $model_name = $_REQUEST['model_name'];
    $model_status = $_REQUEST['model_status'];
    $brand_list = $_REQUEST['brand_list'];


    $sql1 = "SELECT max(model_id)+1 as new_model_id FROM model";
    $result = mysqli_query($connect, $sql1);
    $array = mysqli_fetch_array($result);


    if ($array['new_model_id'] == NULL) {
        $new_model_id = "000001";
    } else {
        $new_model_id = sprintf('%06s', $array['new_model_id']);
    }

    $sql2 = "INSERT INTO model values ('$new_model_id','$model_name','$model_status','$brand_list')";
    $result2 = mysqli_query($connect, $sql2);
    echo json_encode($result2);
    mysqli_close($connect);
} elseif ($operation == "update") {
    $model_id = $_REQUEST['model_id'];
    $brand_id = $_REQUEST['brand_id'];
    $model_name = $_REQUEST['model_name'];
    $model_status = $_REQUEST['model_status'];

    $sql1 = "UPDATE model SET model_name = '$model_name', model_status = '$model_status', brand_id = '$brand_id' WHERE model_id = '$model_id'";
    $result = mysqli_query($connect, $sql1);

    echo json_encode($result);
    mysqli_close($connect);
} elseif ($operation == "delete") {
    $model_id = $_REQUEST['model_id'];

    $sql1 = "DELETE FROM model WHERE model_id = '$model_id'";
    $result = mysqli_query($connect, $sql1);

    if ($result == true) {
        $status['status'] = true;
    } else {
        $status['status'] = false;
    }
    echo json_encode($status);
    mysqli_close($connect);
} elseif ($operation == "show_edit") {
    $model_id = $_REQUEST['model_id'];
    $sql = "SELECT model.model_id, model.model_name, model.model_status, brand.brand_name, brand.brand_id 
        FROM model INNER JOIN brand ON model.brand_id = brand.brand_id WHERE model_id='$model_id'";
    $result = mysqli_query($connect, $sql);
    $array = mysqli_fetch_array($result);

    echo json_encode($array);
} else {
    echo "false";
}
?>