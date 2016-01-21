<?php

require './connect.php';
$operation = $_GET['operation'];

if ($operation == "select") {
    $sql1 = "SELECT * FROM category";
    $result = mysqli_query($connect, $sql1);
    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . "<thead>
                    <tr>
                        <th style='text-align:center;'>Category ID</th>
                        <th style='text-align:center;'>Name</th>
                        <th style='text-align:center;'>Status</th>
                        <th></th>
                    </tr>
                </thead>";

    while ($array = mysqli_fetch_array($result)) {
        $html1 = $html1 . "<tr>
                        <td>{$array['category_id']}</td>
                        <td>{$array['category_name']}</td>
                        <td>{$array['category_status']}</td> 
                            <td>
                            <a href='#to-edit'><button type='button' class='btn btn-default' onclick=" . "editCategory('{$array['category_id']}')" . ">
                                <span class='glyphicon glyphicon-edit'></span> Edit
                            </button></a>
                            <button type='button' class='btn btn-danger' id='delete-category' onclick=" . "deleteCategory('{$array['category_id']}')>
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
    $cate_name = $_REQUEST['cate_name'];
    $cate_status = $_REQUEST['cate_status'];

    $sql1 = "SELECT max(category_id)+1 as new_category_id FROM category";
    $result = mysqli_query($connect, $sql1);

    $array = mysqli_fetch_array($result);

    if ($array['new_category_id'] == NULL) {
        $new_category_id = "000001";
    } else {
        $new_category_id = sprintf('%06s', $array['new_category_id']);
    }

    $sql2 = "INSERT into category values ('$new_category_id','$cate_name','$cate_status')";
    $result2 = mysqli_query($connect, $sql2);
    echo json_encode($result2);
    mysqli_close($connect);
} elseif ($operation == "update") {
    $cate_id = $_REQUEST['cate_id'];
    $cate_name = $_REQUEST['cate_name'];
    $cate_status = $_REQUEST['cate_status'];

    $sql1 = "UPDATE category SET category_name = '$cate_name', category_status = '$cate_status' WHERE category_id = '$cate_id'";
    $result = mysqli_query($connect, $sql1);

    echo json_encode($result);
    mysqli_close($connect);
} elseif ($operation == "delete") {
    $cate_id = $_REQUEST['cate_id'];

    $sql1 = "DELETE FROM category WHERE category_id = '$cate_id'";
    $result = mysqli_query($connect, $sql1);
    if ($result == true) {
        $status['status'] = true;
    } else {
        $status['status'] = false;
    }
    echo json_encode($status);
    mysqli_close($connect);
} elseif ($operation == "show_edit") {

    $cate_id = $_REQUEST['cate_id'];
    $sql = "SELECT * from category WHERE category_id='$cate_id'";
    $result = mysqli_query($connect, $sql);
    $array = mysqli_fetch_array($result);

    echo json_encode($array);
    mysqli_close($connect);
} else {
    echo "false";
}
?>