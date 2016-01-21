<?php
require './connect.php';
$operation = $_GET['operation'];

if ($operation == "select") {
    $sql1 = "SELECT * FROM member";
    $result = mysqli_query($connect, $sql1);

    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . " <thead>
                    <tr>
                        <th style='text-align:center;'>Member ID</th>
                        <th style='text-align:center;'>First Name</th>
                        <th style='text-align:center;'>Last Name</th>
                        <th style='text-align:center;'>Address</th>
                        <th style='text-align:center;'>E-mail</th>
                        <th style='text-align:center;'>Tel</th>
                    </tr>
                </thead>";

    while ($array = mysqli_fetch_array($result)) {
        $html1 = $html1 . "<tr>
                        <td>{$array['member_id']}</td>
                        <td>{$array['member_fname']}</td>
                        <td>{$array['member_lname']}</td>
                        <td><textarea readonly>{$array['member_address']}</textarea></td>
                        <td>{$array['member_email']}</td>
                        <td>{$array['member_tel']}</td>    
                    </tr>";
    }

    $html1 = $html1 . "</table>";

    $array['html1'] = $html1;

    echo json_encode($array);
    mysqli_close($connect);
}
?>

