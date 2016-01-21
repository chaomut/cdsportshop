<?php

require './connect.php';
$operation = $_GET['operation'];


if ($operation == "select") {

    $sql1 = "SELECT * FROM sports_equipment
            INNER JOIN model
            INNER JOIN category
            ON sports_equipment.model_id = model.model_id
            AND sports_equipment.category_id = category.category_id
            GROUP BY sports_equipment.product_id";

    $sql2 = "SELECT * FROM category ORDER BY category_name";

    $sql3 = "SELECT * FROM model
            INNER JOIN brand
            ON model.brand_id = brand.brand_id
            ORDER BY brand.brand_name";

    $result = mysqli_query($connect, $sql1);
    $result2 = mysqli_query($connect, $sql2);
    $result3 = mysqli_query($connect, $sql3);

    $html1 = "<table class='table table-striped' style='text-align:center;'>"
            . " <thead>
                    <tr>
                        <th style='text-align:center;'>Product ID</th>
                        <th style='text-align:center;'>Name</th>
                        <th style='text-align:center;'>Detail</th>
                        <th style='text-align:center;'>Pic</th>
                        <th style='text-align:center;'>Price</th>
                        <th style='text-align:center;'>Amount</th>
                        <th style='text-align:center;'>Reorder Point</th>
                        <th style='text-align:center;'>Add Date</th>
                        <th style='text-align:center;'>Status</th>
                        <th></th>
                    </tr>
                </thead>";

    $html2 = "<select class='form-control' id='cate_list' name='cate_list'>"
            . "<option></option>";
    $html3 = "<select class='form-control' id='model_list' name='model_list'>"
            . "<option></option>";
    $html4 = "<select class='form-control' id='cate_list_edit' name='cate_list_edit'>"
            . "<option></option>";
    $html5 = "<select class='form-control' id='model_list_edit' name='model_list_edit'>"
            . "<option></option>";

    while ($array = mysqli_fetch_array($result)) {
        $sql4 = "SELECT * FROM product_pic WHERE product_id='{$array['product_id']}'";
        $result4 = mysqli_query($connect, $sql4);
        $array4 = mysqli_fetch_array($result4);

        $html1 = $html1 . "<tr>
                        <td>{$array['product_id']}</td>
                        <td>{$array['product_name']}</td>
                        <td><button type='button' class='btn btn-info' data-toggle='modal' data-target='#{$array['product_id']}' >Detail</button>

                            <!-- Modal -->
                            <div id='{$array['product_id']}' class='modal fade' role='dialog'>
                              <div class='modal-dialog'>
                                <!-- Modal content-->
                                <div class='modal-content'>
                                  <div class='modal-header'>
                                    <h4 class='modal-title'>Product ID: {$array['product_id']}</h4>
                                  </div>
                                  <div class='modal-body'>
                                  <table class='table table-striped'>
                                    <tr>
                                    <td><img src='../../img/{$array4['pic']}' width=100px height=100px><br>
                                    <strong>Product:</strong> {$array['product_name']}<br>
                                    <strong>Model:</strong> {$array['model_name']}<br>
                                    <strong>Category:</strong> {$array['category_name']}<br>
                                    <strong>Color:</strong> {$array['color']}<br>
                                    <strong>Detail:</strong> {$array['product_detail']}<br>     
                                    </td>
                                    <tr>
                                    </table>
                              </div>
                          <div class='modal-footer'>
                            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                   </td>";

        if (mysqli_num_rows($result4) > 0) {
            $html1 = $html1 . "<td><img src='../../img/{$array4['pic']}' width=50px height=50px></td>";
        } else {
            $html1 = $html1 . "<td>No Pic</td>";
        }
        $html1 = $html1 . "<td>{$array['price']}</td>
                        <td>{$array['amount']}</td>
                        <td>{$array['reorder_point']}</td>
                        <td>" . date("d-m-Y H:i:s", strtotime($array['add_date'])) . "</td> 
                        <td>{$array['product_status']}</td>
                            <td>
                            <a href='#to-edit'><button type='button' class='btn btn-default' onclick=" . "editProduct('{$array['product_id']}')" . ">
                                <span class='glyphicon glyphicon-edit'></span> Edit
                            </button></a>
                            <button type='button' class='btn btn-danger' id='delete-product' onclick=" . "deleteProduct('{$array['product_id']}')>
                                <span class='glyphicon glyphicon-remove'></span> Delete
                            </button>
                            </td>
                    </tr>";
    }

    while ($array = mysqli_fetch_array($result2)) {
        $html2 = $html2 . "<option value='{$array['category_id']}'>{$array['category_name']}</option>";
        $html4 = $html4 . "<option value='{$array['category_id']}'>{$array['category_name']}</option>";
    }

    while ($array = mysqli_fetch_array($result3)) {
        $html3 = $html3 . "<option value='{$array['model_id']}'>{$array['brand_name']} : {$array['model_name']}</option>";
        $html5 = $html5 . "<option value='{$array['model_id']}'>{$array['brand_name']} : {$array['model_name']}</option>";
    }

    $html1 = $html1 . "</table>";
    $html2 = $html2 . "</select>";
    $html3 = $html3 . "</select>";
    $html4 = $html4 . "</select>";
    $html5 = $html5 . "</select>";

    $array['html1'] = $html1;
    $array['html2'] = $html2;
    $array['html3'] = $html3;
    $array['html4'] = $html4;
    $array['html5'] = $html5;
    echo json_encode($array);
    mysqli_close($connect);
} elseif ($operation == "insert") {
    $category_id = $_REQUEST['category_id'];
    $model_id = $_REQUEST['model_id'];
    $product_name = $_REQUEST['product_name'];
    $product_detail = $_REQUEST['product_detail'];
    $product_color = $_REQUEST['product_color'];
    $product_price = $_REQUEST['product_price'];
    $product_amount = $_REQUEST['product_amount'];
    $reorder_point = $_REQUEST['reorder_point'];
    $product_status = $_REQUEST['product_status'];

    date_default_timezone_set('Asia/Bangkok');
    $addProduct_date = date("Y-m-d H:i:s");

    $sql1 = "SELECT max(product_id)+1 as new_product_id FROM sports_equipment";
    $result1 = mysqli_query($connect, $sql1);

    $array = mysqli_fetch_array($result1);

    if ($array['new_product_id'] == NULL) {
        $new_product_id = "000001";
    } else {
        $new_product_id = sprintf('%06s', $array['new_product_id']);
    }

    $sql2 = "INSERT INTO sports_equipment values ('$new_product_id','$product_name','$product_detail','$product_color',
            '$product_price','$product_amount','$reorder_point','$addProduct_date','$product_status','$model_id','$category_id')";
    $result2 = mysqli_query($connect, $sql2);
    
    echo json_encode($new_product_id);
    mysqli_close($connect);
} else if ($operation == "update") {
    $product_id = $_REQUEST['product_id'];
    $category_id = $_REQUEST['category_id'];
    $model_id = $_REQUEST['model_id'];
    $product_name = $_REQUEST['product_name'];
    $product_detail = $_REQUEST['product_detail'];
    $color = $_REQUEST['color'];
    $price = $_REQUEST['price'];
    $amount = $_REQUEST['amount'];
    $reorder_point = $_REQUEST['reorder_point'];
    $product_status = $_REQUEST['product_status'];

    $sql1 = "UPDATE sports_equipment SET product_name = '$product_name', product_detail = '$product_detail',
            color = '$color', price = '$price', amount = '$amount', category_id = '$category_id',model_id = '$model_id',reorder_point = '$reorder_point', product_status = '$product_status' 
            WHERE product_id = '$product_id'";
    $result = mysqli_query($connect, $sql1);

    echo json_encode($result);
    mysqli_close($connect);
} else if ($operation == "delete") {
    $product_id = $_REQUEST['product_id'];

    $sql1 = "DELETE FROM sports_equipment WHERE product_id = '$product_id'";
    $result = mysqli_query($connect, $sql1);
    if ($result == true) {
        $status['status'] = true;
    } else {
        $status['status'] = false;
    }
    echo json_encode($status);
    mysqli_close($connect);
} else if ($operation == "show_edit") {

    $product_id = $_POST['product_id'];
    $sql1 = "SELECT * FROM sports_equipment WHERE product_id='$product_id'";
    $result1 = mysqli_query($connect, $sql1);
    $array = mysqli_fetch_array($result1);

    $sql2 = "SELECT pic_id,pic FROM product_pic WHERE product_id = '$product_id'";
    $result2 = mysqli_query($connect, $sql2);
    $array2 = mysqli_fetch_array($result2);

    if (mysqli_num_rows($result2) > 0) {
        $product_pic = $array + $array2;
    } else {
        $product_pic = $array;
    }


    echo json_encode($product_pic);
    mysqli_close($connect);
} else {
    echo "false";
}
?>