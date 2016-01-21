<?php

error_reporting(E_ALL ^ E_WARNING);
//////////////////////////////////////////////////////
require './php/datetime.php';
$totalSale = 0;
$discount = 0;
$delivery = 0;
$discountPrice = 0;
if (isset($_SESSION['member_id'])) {
    $member_id = $_SESSION['member_id'];
    /////// Check Promotion
    $sql_for_promotion = "SELECT * FROM promotion WHERE DATE(NOW()) >= start_date AND DATE(NOW()) <= end_date";
    $result_for_promotion = mysqli_query($connect, $sql_for_promotion);
    $array_for_promotion = mysqli_fetch_array($result_for_promotion);
    if (mysqli_num_rows($result_for_promotion) > 0) {
        $discount = $array_for_promotion['discount'];
    }
//////////////////////////////////////////////////////
////////////////// Start Member //////////////////////
//////////////////////////////////////////////////////
    if (isset($member_id)) {
        $html = "";
        // Command SQL for Select Address
        $sql2 = "SELECT member.member_fname,member.member_lname,sale.delivery_address,member.member_address
                FROM member 
                    INNER JOIN sale
                        ON member.member_id = sale.member_id
                WHERE member.member_id='$member_id'";
        // Command SQL for Select Address if result2 <= 0
        $sql3 = "SELECT member_address,member_fname,member_lname,member_id
                FROM member
                WHERE member_id='$member_id'";
        $result2 = mysqli_query($connect, $sql2);
        $count = 0;
        if (mysqli_num_rows($result2) > 0) {
            while ($array2 = mysqli_fetch_array($result2)) {
                $member_name = $array2['member_fname'] . " " . $array2['member_lname'];
                $member_address = $member_name . $array2['member_address'];
                $other_address[$count] = $array2['delivery_address'];
                $count++;
            }
            $count = 0;
            $other_address = array_unique($other_address);
            $other_address = array_values($other_address);
            for ($i = 0; $i < count($other_address); $i++) {
                if ($member_address != $other_address[$i]) {
                    $count++;
                    $html = $html . "<div class='radio'>
                        <label><input type='radio' name='optradio' value='{$other_address[$i]}'>
                            <p> ที่อยู่อื่นๆ  {$count} </p>
                        </label>
                        <textarea readonly  rows='4' id='address-profile' class='form-control' value=''>{$other_address[$i]}</textarea> 
                        </div>";
                }
            }
        } else {
            $result2 = mysqli_query($connect, $sql3);
            while ($array2 = mysqli_fetch_array($result2)) {
                $member_name = $array2['member_fname'] . " " . $array2['member_lname'];
                $member_address = $member_name . $array2['member_address'];
            }
        }
    }
////////////////////////////////////////////////////////
//////////////////  Start Cart    ////////////////////
//////////////////////////////////////////////////////
    $html2 = "<div class='panel-body'>   
                            <h4>รายการสินค้า</h4>
                            <table class='table table-hover'>
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class='text-center'>Name</th>
                                        <th class='text-center'>Amount</th>
                                        <th class='text-center'>Price</th>
                                        <th class='text-center'>Total</th>
                                    </tr>
                                </thead>
                                <tbody>";

    for ($i = 0; $i < count($_SESSION['product']); $i++) {
        $value = $_SESSION['product'][$i];
        $temp = json_decode($value, true);
        if (isset($temp['product_id'])) {
            $sql3 = "SELECT  sports_equipment.product_name,sports_equipment.price,product_pic.pic  
                     FROM sports_equipment
                        INNER JOIN product_pic 
                            ON product_pic.product_id=sports_equipment.product_id
                     WHERE sports_equipment.product_id='{$temp['product_id']}'
                     GROUP BY product_pic.product_id";
            $result3 = mysqli_query($connect, $sql3);
            $array3 = mysqli_fetch_array($result3);
            $totalPrice = $array3['price'] * $temp['amount'];
            $totalSale += $totalPrice;
            if ($totalSale >= 1000) {
                $delivery = 0;
            } else {
                $delivery = 80;
                $totalSale += $delivery;
            }
            $html2 = $html2 . "<tr>
                              <td><img src='../img/{$array3['pic']}' width='45' height='45px'></td>
                              <td><h5>{$array3['product_name']}</h5></td>
                              <td class='text-center'><h5>{$temp['amount']}</h5></td>
                              <td class='text-right'><h5>" . number_format($array3['price'], 2) . "</h5></td>
                              <td class='text-right'><h5>" . number_format($totalPrice, 2) . "</h5></td>
                              </tr>";
        }
    }
    $discountPrice = $discount * $totalSale / 100;
    $html2 = $html2 . "<tr>
                                        <td></td>
                                        <td></td>
                                        <td class='text-right text-success'><h5>Discount</h5></td>
                                        <td></td>
                                        <td class='text-right text-success'><h5><strong>- " . number_format($discountPrice, 2) . " ฿</strong></h5></td>
                                    </tr>
                                    <tr >
                                        <td></td>
                                        <td></td>
                                        <td class='text-right'><h5>Delivery</h5></td>
                                        <td></td>
                                        <td class='text-right'><h5><strong>{$delivery}</strong></h5></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td class='text-right'><h5>Total Price</h5></td>
                                        <td></td>
                                        <td class='text-right'><h5><strong>" . number_format($totalSale - $discountPrice, 2) . " ฿" . "</h5></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>";
////////////////////////////////////////////////////////
//////////////////  END Cart    ////////////////////
//////////////////////////////////////////////////////
}
mysqli_close($connect);
?>

