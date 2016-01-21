<?php

require '../php/connect.php';

$html1 = "<select class='form-control' id='year' name='year'>";
$html2 = "<select class='form-control' name='month' id='month'>
                                        <option value='01'>January</option>
                                        <option value='02'>February</option>
                                        <option value='03'>March</option>
                                        <option value='04'>April</option>
                                        <option value='05'>May</option>
                                        <option value='06'>June</option>
                                        <option value='07'>July</option>
                                        <option value='08'>August</option>
                                        <option value='09'>September</option>
                                        <option value='10'>October</option>
                                        <option value='11'>November</option>
                                        <option value='12'>December</option>
                                    </select>";

$report = $_REQUEST['report'];

if ($report == "purchase_report") {
    $sql1 = "SELECT YEAR(pur_date) AS pur_date FROM purchase GROUP BY YEAR(pur_date)";
    $result1 = mysqli_query($connect, $sql1);

    while ($array = mysqli_fetch_array($result1)) {
        $html1 = $html1 . "<option value='{$array['pur_date']}'>{$array['pur_date']}</option>";
    }

    $html1 = $html1 . "</select>";

    $array['html1'] = $html1;
    $array['html2'] = $html2;

    echo json_encode($array);
} else if ($report == "sale_report") {
    $sql1 = "SELECT YEAR(sale_date) AS sale_date FROM sale GROUP BY YEAR(sale_date)";
    $result1 = mysqli_query($connect, $sql1);

    while ($array = mysqli_fetch_array($result1)) {
        $html1 = $html1 . "<option value='{$array['sale_date']}'>{$array['sale_date']}</option>";
    }

    $html1 = $html1 . "</select>";

    $array['html1'] = $html1;
    $array['html2'] = $html2;

    echo json_encode($array);
}
?>

