var check_name = true;

var check_name_edit = true;

$(document).ready(function () {
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Select Brand
    $.post("../php/brand_mng.php?operation=select", {}, function (data) {
        $("#show-brand").html(data.html1);
    }, "json");

    //Insert Brand
    $("#add-brand").click(function () {
        var brand_name = $("#brand_name");
        var brand_status = $("#brand_status");
        if (brand_name.val() !== '' && brand_status.val() !== '')
        {
            if (check_name === true) {
                $.post("../php/brand_mng.php?operation=insert", {
                    "brand_name": brand_name.val(),
                    "brand_status": brand_status.val()
                }, function (data) {
                    location.reload();
                }, "json");
            }
            else
                alert("กรุณากรอกข้อมูลให้ถูกต้อง");
        }
        else
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
    });
    
    //edit brand
    $("#edit-brand").click(function () {
        var brand_id = $("#brand_id_edit");
        var brand_name = $("#brand_name_edit");
        var brand_status = $("#brand_status_edit");

        if (brand_id.val() !== '' && brand_name.val() !== '' && brand_status.val() !== '')
        {
            if (check_name_edit === true) {
                $.post("../php/brand_mng.php?operation=update", {
                    "brand_id": brand_id.val(),
                    "brand_name": brand_name.val(),
                    "brand_status": brand_status.val()
                }, function (data) {
                    location.reload();
                }, "json");
            }
            else
                alert("กรุณากรอกข้อมูลให้ถูกต้อง");
        }
        else
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
    });
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////VALIDATE////////////////////////////////////////////////////
    //Brand Name Add
    $("#brand_name").blur(function () {
        var errorBrand = $("#errorBrandName1");
        var brand_name = $("#brand_name");
        checkBrandNameComplete(errorBrand, brand_name);
    });
    //Brand Name Edit
    $("#brand_name_edit").blur(function () {
        var errorBrand = $("#errorBrandName2");
        var brand_id = $("#brand_id_edit");
        var brand_name = $("#brand_name_edit");
        checkBrandNameEditComplete(errorBrand, brand_id, brand_name);
    });
/////////////////////////////////////////////////////////////////////////////////////////   
    //Check brand
    function checkBrandNameComplete(errorBrand, brand_name) {
        if (brand_name.val() === "") {
            errorBrand.css({"color": "red"});
            errorBrand.text("*กรุณากรอกข้อมูล");
            brand_name.css({"border-color": "red"});
            brand_name.css({"background-color": "lavenderblush"});
            check_name = false;
        }
        else {
            $.post("../php/check_duplicateData.php?operation=brand", {
                "brand_name": brand_name.val()
            }, function (data) {
                if (data.status === true) {
                    errorBrand.text("");
                    brand_name.css({"border-color": "green"});
                    brand_name.css({"background-color": "#d6e9c6"});
                    check_name = true;
                }
                else {
                    errorBrand.css({"color": "red"});
                    errorBrand.text("*ชื่อนี้ไม่สามารถใช้ได้");
                    brand_name.css({"border-color": "red"});
                    brand_name.css({"background-color": "lavenderblush"});
                    check_name = false;
                }
            }, "json");
        }
    }

    function checkBrandNameEditComplete(errorBrand, brand_id, brand_name) {
        if (brand_name.val() === "") {
            errorBrand.css({"color": "red"});
            errorBrand.text("*กรุณากรอกข้อมูล");
            brand_name.css({"border-color": "red"});
            brand_name.css({"background-color": "lavenderblush"});
            check_name_edit = false;
        }
        else {
            $.post("../php/check_duplicateData.php?operation=brand_edit", {
                "brand_id": brand_id.val(),
                "brand_name": brand_name.val()
            }, function (data) {
                if (data.status === true) {
                    errorBrand.text("");
                    brand_name.css({"border-color": "green"});
                    brand_name.css({"background-color": "#d6e9c6"});
                    check_name_edit = true;
                }
                else {
                    errorBrand.css({"color": "red"});
                    errorBrand.text("*ชื่อนี้ไม่สามารถใช้ได้");
                    brand_name.css({"border-color": "red"});
                    brand_name.css({"background-color": "lavenderblush"});
                    check_name_edit = false;
                }
            }, "json");
        }
    }
///////////////////////////////////////////////////////////////////////////////////    
});

