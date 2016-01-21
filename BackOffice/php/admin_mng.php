<?php

session_start();
$admin_id = $_SESSION['admin_id'];

require './connect.php';
$operation = $_GET['operation'];

if ($operation == "select") {
    $sql1 = "SELECT * FROM admin";

    $result1 = mysqli_query($connect, $sql1);



    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . " <thead>
                    <tr>
                        <th style='text-align:center;'>Admin ID</th>
                        <th style='text-align:center;'>First Name</th>
                        <th style='text-align:center;'>Last Name</th>
                        <th style='text-align:center;'>Tel</th>
                        <th style='text-align:center;'>Email</th>
                        <th></th>
                    </tr>
                </thead>";

    while ($array = mysqli_fetch_array($result1)) {
        $html1 = $html1 . "<tr>
                        <td>{$array['admin_id']}</td>
                        <td>{$array['admin_fname']}</td>
                        <td>{$array['admin_lname']}</td>
                        <td>{$array['admin_tel']}</td>
                        <td>{$array['admin_email']}</td>";
        if ($admin_id == '000001') {
            $html1 = $html1 . "<td><a href='#to-edit'><button type='button' class='btn btn-default' onclick=" . "editAdmin('{$array['admin_id']}')" . ">
                                    <span class='glyphicon glyphicon-edit'></span> Edit
                                    </button></a>
                                    <button type='button' class='btn btn-danger' id='delete-brand' onclick=" . "deleteAdmin('{$array['admin_id']}')>
                                    <span class='glyphicon glyphicon-remove'></span> Delete
                                    </button>
                               </td>
                           </tr>";
        }
    }
    $html1 = $html1 . "</table>";

    $array['html1'] = $html1;

    echo json_encode($array);
    mysqli_close($connect);
} else if ($operation == "insert") {
    $admin_fname = $_REQUEST['admin_fname'];
    $admin_lname = $_REQUEST['admin_lname'];
    $admin_tel = $_REQUEST['admin_tel'];
    $admin_email = $_REQUEST['admin_email'];
    $admin_pass = $_REQUEST['admin_pass'];

    $md5pass = md5($admin_pass);

    $sql1 = "SELECT max(admin_id)+1 as new_admin_id FROM admin";
    $result = mysqli_query($connect, $sql1);

    $array = mysqli_fetch_array($result);

    if ($array['new_admin_id'] == NULL) {
        $new_admin_id = "000001";
    } else {
        $new_admin_id = sprintf('%06s', $array['new_admin_id']);
    }

    $sql2 = "INSERT into admin values ('$new_admin_id','$admin_fname','$admin_lname','$admin_tel','$admin_email','$md5pass')";
    $result2 = mysqli_query($connect, $sql2);
    echo json_encode($result2);
    mysqli_close($connect);
} else if ($operation == "update") {
    $admin_id = $_REQUEST['admin_id'];
    $admin_fname = $_REQUEST['admin_fname'];
    $admin_lname = $_REQUEST['admin_lname'];
    $admin_tel = $_REQUEST['admin_tel'];
    $admin_email = $_REQUEST['admin_email'];


    $sql1 = "UPDATE admin SET admin_fname = '$admin_fname', admin_lname = '$admin_lname', 
            admin_tel = '$admin_tel', admin_email = '$admin_email' WHERE admin_id = '$admin_id'";
    $result = mysqli_query($connect, $sql1);

    echo json_encode($result);
    mysqli_close($connect);
} else if ($operation == "delete") {
    $admin_id = $_REQUEST['admin_id'];

    $sql1 = "DELETE FROM admin WHERE admin_id = '$admin_id'";
    $result = mysqli_query($connect, $sql1);
    if ($result == true) {
        $status['status'] = true;
    } else {
        $status['status'] = false;
    }
    echo json_encode($status);
    mysqli_close($connect);
} else if ($operation == "show_edit") {
    $admin_id = $_REQUEST['admin_id'];
    $sql = "SELECT * FROM admin WHERE admin_id='$admin_id'";
    $result = mysqli_query($connect, $sql);
    $array = mysqli_fetch_array($result);

    echo json_encode($array);
    mysqli_close($connect);
} else {

    echo "false";
}
?>