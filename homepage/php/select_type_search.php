<?php

error_reporting(E_ALL ^ E_WARNING);

if (isset($_GET['select_model'])) {
    require './connect.php';
    $html = "<option value='#'>Model</option>";
    $brand_id = $_REQUEST['brand'];
    $sql_for_select_model = "SELECT * FROM model WHERE brand_id='{$brand_id}' AND model_status='Enabled'";
    $result = mysqli_query($connect, $sql_for_select_model);
    while ($array = mysqli_fetch_array($result)) {
        $html = $html . "<option value='{$array['model_id']}'>{$array['model_name']}</option>";
    }
    echo json_encode($html);
} else {
    require './php/connect.php';
    $sql1_for_brand = "SELECT brand.brand_id,brand.brand_name ,COUNT(sports_equipment.product_id) AS product_amount
                    FROM brand
                    INNER JOIN model ON model.brand_id=brand.brand_id
                    INNER JOIN sports_equipment ON sports_equipment.model_id=model.model_id
                    WHERE brand_status='Enabled'
                    GROUP BY brand.brand_id
                    ORDER BY brand.brand_name";
    $sql3_for_category = "SELECT category.category_id,category.category_name ,COUNT(sports_equipment.product_id) AS product_amount
                    FROM category 
                    INNER JOIN sports_equipment ON sports_equipment.category_id=category.category_id
                    WHERE category_status='Enabled'
                    GROUP BY category.category_id
                    ORDER BY category.category_name";
    $sql4_for_color = "SELECT color,COUNT(product_id) AS product_amount
                    FROM sports_equipment 
                    WHERE product_status='Enabled' GROUP BY color";
//////////////////// SELECT SEARCH BRAND ///////////////////
    $html_search = "<div class='col-md-3'>
                <select class='form-control' id='brand-search' onchange='selectModel()'>
                    <option value='#'>Brand</option>";
    $result1_for_brand = mysqli_query($connect, $sql1_for_brand);
    while ($array1_for_brand = mysqli_fetch_array($result1_for_brand)) {
        $html_search = $html_search . "<option value='{$array1_for_brand['brand_id']}'>{$array1_for_brand['brand_name'] } ({$array1_for_brand['product_amount']})</option>";
    }
    $html_search = $html_search . "</select><br>";
//////////////////// SELECT SEARCH MODEL ///////////////////
    $html_search = $html_search . "<select class='form-control' id='model-search' disabled>
                    <option value='#'>Model</option>";
    $html_search = $html_search . "</select><br></div>";



    $html_search = $html_search . "<div class='col-md-3'>
                                <select class='form-control' id='price_search'>
                                        <option value='#'>Price</option>
                                        <option value='0,350'>ต่ำกว่า ฿ 350</option>
                                        <option value='350,500'>฿ 350 - ฿ 500</option>
                                        <option value='501,1000'>฿ 501 - ฿ 1000</option>
                                        <option value='1001,1500'>฿ 1001 - ฿ 1500</option>
                                        <option value='1501,2000'>฿ 1501 - ฿ 2000</option>
                                        <option value='2001,2500'>฿ 2001 - ฿ 2500</option>
                                        <option value='2501'>฿ 2500 ขึ้นไป </option>
                                </select><br>";
//////////////////// SELECT SEARCH CATEGORY ///////////////////
    $html_search = $html_search . " <select class='form-control' id='category-search'>
                                    <option  value='#'>Category</option>";
    $result3_for_category = mysqli_query($connect, $sql3_for_category);
    while ($array3_for_category = mysqli_fetch_array($result3_for_category)) {
        $html_search = $html_search . "<option value='{$array3_for_category['category_id']}'>{$array3_for_category['category_name'] } ({$array3_for_category['product_amount']})</option>";
    }
    $html_search = $html_search . "</select>
                            </div>";

//////////////////// SELECT SEARCH COLOR ///////////////////
    $html_search = $html_search . "
        <div class='col-md-3' style='height: 15%; overflow-y: scroll'>";
    $result4_for_color = mysqli_query($connect, $sql4_for_color);
    while ($array4_for_color = mysqli_fetch_array($result4_for_color)) {
        $html_search = $html_search . "<div class='checkbox'>";
        if ($array4_for_color['color'] == "white") {
            $html_search = $html_search . "<label style='color:{$array4_for_color['color']}; background-color:#A9A9A9;'><input type='checkbox' name='color-search[]' value='{$array4_for_color['color']}'>{$array4_for_color['color'] } ({$array4_for_color['product_amount']})</label><span style='color:{$array4_for_color['color']};' class='glyphicon glyphicon-tint'></span>";
        } else {
            $html_search = $html_search . "<label style='color:{$array4_for_color['color']}'><input type='checkbox' name='color-search[]' value='{$array4_for_color['color']}'>{$array4_for_color['color'] } ({$array4_for_color['product_amount']})</label> <span style='color:{$array4_for_color['color']};' class='glyphicon glyphicon-tint'></span>";
        }
        $html_search = $html_search . "</div>";
    }
    $html_search = $html_search . "</div>                      
                        <div class='col-sm-3'>
                        <input class='form-control' id='name_search' type='text'  placeholder='Search.' > <br>
                        <input class='form-control' id='id-search'  maxlength='6' placeholder='Search ID'>     
                        </div>                    
                        <button  type='button' onclick = " . "search()" . " class='btn btn-info'>Search</button> 
                        ";
}
?>