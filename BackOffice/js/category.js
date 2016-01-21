var check_name = true;
var check_name_edit = true;

$(document).ready(function () {
    //Select Category
    $.post("../php/category_mng.php?operation=select", {}, function (data) {

        $("#show-category").html(data.html1);
        $("#show-category-id").html(data.html2);
    }, "json");

    //Insert Category
    $("#add-category").click(function () {
        var cate_name = $("#cate_name");
        var cate_status = $("#cate_status");
        if (cate_name.val() !== '' && cate_status.val() !== '')
        {
            if (check_name === true) {
                $.post("../php/category_mng.php?operation=insert", {
                    "cate_name": cate_name.val(),
                    "cate_status": cate_status.val()
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

    //Update Category
    $("#edit-category").click(function () {
        var cate_id = $("#cate_id_edit");
        var cate_name = $("#cate_name_edit");
        var cate_status = $("#cate_status_edit");

        if (cate_id.val() !== '' && cate_name.val() !== '' && cate_status.val() !== '')
        {
            if (check_name_edit === true) {
                $.post("../php/category_mng.php?operation=update", {
                    "cate_id": cate_id.val(),
                    "cate_name": cate_name.val(),
                    "cate_status": cate_status.val()
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
//////////////////////////////////////////////////////////////////////////////////////    
////////////////////////////VALIDATE//////////////////////////////////////////////////    
//Check Category 
    $("#cate_name").keypress(function () {
        var errorCate = $("#errorCateName1");
        checkCateName(errorCate);
    });
    $("#cate_name").blur(function () {
        var errorCate = $("#errorCateName1");
        var cate_name = $("#cate_name");
        checkCateNameComplete(errorCate, cate_name);
    });

    $("#cate_name_edit").keypress(function () {
        var errorCate = $("#errorCateName2");
        checkCateName(errorCate);
    });
    $("#cate_name_edit").blur(function () {
        var errorCate = $("#errorCateName2");
        var cate_id = $("#cate_id_edit");
        var cate_name = $("#cate_name_edit");
        checkCateNameEditComplete(errorCate, cate_id, cate_name);
    });

//////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Check Name Add
    function checkCateName(errorCate) {
        if (((event.which < 65 && event.which > 32) || (event.which > 90 && event.which < 97) || (event.which > 122 && event.which < 256))) {
            event.preventDefault();
            errorCate.css({"color": "red"});
            errorCate.text("*กรุณากรอกเป็นตัวอักษร");
            check_name = false;
        }
        else {
            errorCate.text("");
            check_name = true;
        }
    }

    function checkCateNameComplete(errorCate, cate_name) {
        if (cate_name.val() === "") {
            errorCate.css({"color": "red"});
            errorCate.text("*กรุณากรอกข้อมูล");
            cate_name.css({"border-color": "red"});
            cate_name.css({"background-color": "lavenderblush"});
            check_name = false;
        }
        else {
            $.post("../php/check_duplicateData.php?operation=category", {
                "cate_name": cate_name.val()
            }, function (data) {
                if (data.status === true) {
                    errorCate.text("");
                    cate_name.css({"border-color": "green"});
                    cate_name.css({"background-color": "#d6e9c6"});
                    check_name = true;
                }
                else {
                    errorCate.css({"color": "red"});
                    errorCate.text("*ชื่อนี้ไม่สามารถใช้ได้");
                    cate_name.css({"border-color": "red"});
                    cate_name.css({"background-color": "lavenderblush"});
                    check_name = false;
                }
            }, "json");
        }
    }
    
    //Check Name Edit
    function checkCateNameEditComplete(errorCate, cate_id, cate_name) {
        if (cate_name.val() === "") {
            errorCate.css({"color": "red"});
            errorCate.text("*กรุณากรอกข้อมูล");
            cate_name.css({"border-color": "red"});
            cate_name.css({"background-color": "lavenderblush"});
            check_name_edit = false;
        }
        else {
            $.post("../php/check_duplicateData.php?operation=category_edit", {
                "cate_id": cate_id.val(),
                "cate_name": cate_name.val()
            }, function (data) {
                if (data.status === true) {
                    errorCate.text("");
                    cate_name.css({"border-color": "green"});
                    cate_name.css({"background-color": "#d6e9c6"});
                    check_name_edit = true;
                }
                else {
                    errorCate.css({"color": "red"});
                    errorCate.text("*ชื่อนี้ไม่สามารถใช้ได้");
                    cate_name.css({"border-color": "red"});
                    cate_name.css({"background-color": "lavenderblush"});
                    check_name_edit = false;
                }
            }, "json");
        }
    }
///////////////////////////////////////////////////////////////////////////////////    
});


