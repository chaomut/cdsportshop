<?php

session_start();
require './connect.php';
$operation = $_GET['operation'];


if ($operation == "select_reorderpoint") {

    $sql1 = "SELECT * FROM sports_equipment
            INNER JOIN product_pic
            ON sports_equipment.product_id = product_pic.product_id
            WHERE sports_equipment.amount <= sports_equipment.reorder_point";

    if (isset($_SESSION['purchase'])) {
        for ($i = 0; $i < count($_SESSION['purchase']); $i++) {
            $value = $_SESSION['purchase'][$i];
            $temp = json_decode($value, true);
            $sql1 = $sql1 . " AND sports_equipment.product_id <> '{$temp['product_id']}'";
        }
    }
    $sql1 = $sql1 . " GROUP BY sports_equipment.product_id";
    $result = mysqli_query($connect, $sql1);

    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . " <thead>
                    <tr>
                        <th style='text-align:center;'>Product ID</th>
                        <th style='text-align:center;'>Name</th>
                        <th style='text-align:center;'>Detail</th>
                        <th style='text-align:center;'>Color</th>
                        <th style='text-align:center;'>Pic</th>
                        <th style='text-align:center;'>Price</th>
                        <th style='text-align:center;'>Amount</th>
                        <th style='text-align:center;'>Reorder Point</th>
                        <th style='text-align:center;'>Model ID</th>
                        <th style='text-align:center;'>Category ID</th>
                        <th style='text-align:center;'>Status</th>
                        <th></th>
                    </tr>
                </thead>";

    while ($array = mysqli_fetch_array($result)) {
        $html1 = $html1 . "<tr>
                        <td>{$array['product_id']}</td>
                        <td>{$array['product_name']}</td>
                        <td><textarea readonly>{$array['product_detail']}</textarea></td>
                        <td>{$array['color']}</td>
                        <td><img src='../../img/{$array['pic']}' width=50px height=50px></td>
                        <td>{$array['price']}</td>
                        <td>{$array['amount']}</td>
                        <td>{$array['reorder_point']}</td>
                        <td>{$array['model_id']}</td>
                        <td>{$array['category_id']}</td>    
                        <td>{$array['product_status']}</td>
                        <td><button type='button' class='btn btn-primary' onclick=" . "addPurchase('{$array['product_id']}')" . ">
                            <span class='glyphicon glyphicon-plus'></span> Add
                            </button></td> 
                    </tr>";
    }

    $html1 = $html1 . "</table>";

    $array['html1'] = $html1;

    echo json_encode($array);
    mysqli_close($connect);
} else if ($operation == "select_all") {

    $sql1 = "SELECT * FROM sports_equipment
            INNER JOIN product_pic
            ON sports_equipment.product_id = product_pic.product_id";

    if (isset($_SESSION['purchase'])) {
        for ($i = 0; $i < count($_SESSION['purchase']); $i++) {
            $value = $_SESSION['purchase'][$i];
            $temp = json_decode($value, true);
            $sql1 = $sql1 . " AND sports_equipment.product_id <> '{$temp['product_id']}'";
        }
    }
    $sql1 = $sql1 . " GROUP BY sports_equipment.product_id";
    $result = mysqli_query($connect, $sql1);

    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . " <thead>
                    <tr>
                        <th style='text-align:center;'>Product ID</th>
                        <th style='text-align:center;'>Name</th>
                        <th style='text-align:center;'>Detail</th>
                        <th style='text-align:center;'>Color</th>
                        <th style='text-align:center;'>Pic</th>
                        <th style='text-align:center;'>Price</th>
                        <th style='text-align:center;'>Amount</th>
                        <th style='text-align:center;'>Reorder Point</th>
                        <th style='text-align:center;'>Model ID</th>
                        <th style='text-align:center;'>Category ID</th>
                        <th style='text-align:center;'>Status</th>
                        <th></th>
                    </tr>
                </thead>";

    while ($array = mysqli_fetch_array($result)) {
        $html1 = $html1 . "<tr>
                        <td>{$array['product_id']}</td>
                        <td>{$array['product_name']}</td>
                        <td><textarea readonly>{$array['product_detail']}</textarea></td>
                        <td>{$array['color']}</td>
                        <td><img src='../../img/{$array['pic']}' width=50px height=50px></td>
                        <td>{$array['price']}</td>
                        <td>{$array['amount']}</td>
                        <td>{$array['reorder_point']}</td>
                        <td>{$array['model_id']}</td>
                        <td>{$array['category_id']}</td>    
                        <td>{$array['product_status']}</td>
                        <td><button type='button' class='btn btn-primary' onclick=" . "addPurchase('{$array['product_id']}')" . ">
                            <span class='glyphicon glyphicon-plus'></span> Add
                            </button></td> 
                    </tr>";
    }

    $html1 = $html1 . "</table>";

    $array['html1'] = $html1;
    echo json_encode($array);
    mysqli_close($connect);
}
?>