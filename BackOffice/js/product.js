var check_name = true;
var check_name_edit = true;

$(document).ready(function () {   
    //Select Product
    $.post("../php/product_mng.php?operation=select", {}, function (data) {
        $("#show-product").html(data.html1);
        $("#select-cate1").html(data.html2);
        $("#select-cate2").html(data.html4);
        $("#select-model1").html(data.html3);
        $("#select-model2").html(data.html5);
    }, "json");

    //Insert Product
    $("#add-product").click(function () {
        var category_id = $("#cate_list");
        var model_id = $("#model_list");
        var product_name = $("#product_name");
        var product_detail = $("#product_detail");
        var product_color = $("#product_color");
        var product_price = $("#product_price");
        var product_amount = $("#product_amount");
        var reorder_point = $("#reorder_point");
        var product_status = $("#product_status");


        if (category_id.val() !== '' && model_id.val() !== '' && product_name.val() !== ''
                && product_color.val() !== '' && product_price.val() !== ''
                && product_amount.val() !== '' && reorder_point.val() !== '' && product_status.val() !== '')
        {
            if (check_name === true) {
                $.post("../php/product_mng.php?operation=insert", {
                    "category_id": category_id.val(),
                    "model_id": model_id.val(),
                    "product_name": product_name.val(),
                    "product_detail": product_detail.val(),
                    "product_color": product_color.val(),
                    "product_price": product_price.val(),
                    "product_amount": product_amount.val(),
                    "reorder_point": reorder_point.val(),
                    "product_status": product_status.val()
                }, function (data) {
                    popupWindow = window.open(
                            '../php/upload_pic.php?product_id=' + data, 'popUpWindow', 'height=600,width=600');
                }, "json");

            } else
                alert("กรุณากรอกข้อมูลให้ถูกต้อง");
        } else
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
    });

    //Update Product
    $("#edit-product").click(function () {
        var product_id = $("#product_id_edit");
        var category_id = $("#cate_list_edit");
        var model_id = $("#model_list_edit");
        var product_name = $("#product_name_edit");
        var product_detail = $("#product_detail_edit");
        var color = $("#product_color_edit");
        var price = $("#product_price_edit");
        var amount = $("#product_amount_edit");
        var reorder_point = $("#reorder_point_edit");
        var product_status = $("#product_status_edit");

        if (product_id.val() !== '' && category_id.val() !== '' && model_id.val() !== ''
                && product_name.val() !== '' && color.val() !== ''
                && price.val() !== '' && amount.val() !== '' && reorder_point.val() !== '' && product_status.val() !== '')
        {
            if (check_name_edit === true) {
                $.post("../php/product_mng.php?operation=update", {
                    "product_id": product_id.val(),
                    "category_id": category_id.val(),
                    "model_id": model_id.val(),
                    "product_name": product_name.val(),
                    "product_detail": product_detail.val(),
                    "color": color.val(),
                    "price": price.val(),
                    "amount": amount.val(),
                    "reorder_point": reorder_point.val(),
                    "product_status": product_status.val()
                }, function (data) {
                    location.reload();
                }, "json");
            } else
                alert("กรุณากรอกข้อมูลให้ถูกต้อง");
        } else
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
    });
    $("#edit-pic").click(function () {
        var product_id = $("#product_id_edit");

        if (product_id.val() !== '')
        {
            popupWindow = window.open(
                    '../php/upload_pic.php?product_id=' + product_id.val(), 'popUpWindow', 'height=600,width=600');
        } else
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
    });
    
///////////////////////////////VALIDATE//////////////////////////////////////////////////
    //Product Name
    $("#product_name").blur(function () {
        var errorProduct = $("#errorProductName1");
        var product_name = $("#product_name");
        checkProductNameComplete(errorProduct, product_name);
    });
    
    //ProductName Edit
    $("#product_name_edit").blur(function () {
        var errorProduct = $("#errorProductName2");
        var product_name = $("#product_name_edit");
        var product_id = $("#product_id_edit");
        checkProductNameEditComplete(errorProduct, product_id, product_name);
    });    
/////////////////////////////////////////////////////////////////////////////////
    //Check Product Name
    function checkProductNameComplete(errorProduct, product_name) {
        if (product_name.val() === "") {
            errorProduct.css({"color": "red"});
            errorProduct.text("*กรุณากรอกข้อมูล");
            product_name.css({"border-color": "red"});
            product_name.css({"background-color": "lavenderblush"});
            check_name = false;
        } else {
            $.post("../php/check_duplicateData.php?operation=product", {
                "product_name": product_name.val()
            }, function (data) {
                if (data.status === true) {
                    errorProduct.text("");
                    product_name.css({"border-color": "green"});
                    product_name.css({"background-color": "#d6e9c6"});
                    check_name = true;
                } else {
                    errorProduct.css({"color": "red"});
                    errorProduct.text("*ชื่อนี้ไม่สามารถใช้ได้");
                    product_name.css({"border-color": "red"});
                    product_name.css({"background-color": "lavenderblush"});
                    check_name = false;
                }
            }, "json");
        }
    }

    //Check Name Edit
    function checkProductNameEditComplete(errorProduct, product_id, product_name) {
        if (product_name.val() === "") {
            errorProduct.css({"color": "red"});
            errorProduct.text("*กรุณากรอกข้อมูล");
            product_name.css({"border-color": "red"});
            product_name.css({"background-color": "lavenderblush"});
            check_name_edit = false;
        } else {
            $.post("../php/check_duplicateData.php?operation=product_edit", {
                "product_id": product_id.val(),
                "product_name": product_name.val()
            }, function (data) {
                if (data.status === true) {
                    errorProduct.text("");
                    product_name.css({"border-color": "green"});
                    product_name.css({"background-color": "#d6e9c6"});
                    check_name_edit = true;
                } else {
                    errorProduct.css({"color": "red"});
                    errorProduct.text("*ชื่อนี้ไม่สามารถใช้ได้");
                    product_name.css({"border-color": "red"});
                    product_name.css({"background-color": "lavenderblush"});
                    check_name_edit = false;
                }
            }, "json");
        }
    }
////////////////////////////////////////////////////////////////////////////////
});

