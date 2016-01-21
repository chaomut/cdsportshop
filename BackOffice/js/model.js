var check_name = true;
var check_name_edit = true;

$(document).ready(function () {
    //Select Model
    $.post("../php/model_mng.php?operation=select", {}, function (data) {
        $("#show-model").html(data.html1);
        $("#select-brand").html(data.html2);
        $("#select-brand-edit").html(data.html3);
    }, "json");

    //Insert Model
    $("#add-model").click(function () {
        var model_name = $("#model_name");
        var model_status = $("#model_status");
        var brand_list = $("#brand_list");
        if (model_name.val() !== '' && model_status.val() !== '' && brand_list.val() !== '')
        {
            if (check_name === true) {
                $.post("../php/model_mng.php?operation=insert", {
                    "model_name": model_name.val(),
                    "model_status": model_status.val(),
                    "brand_list": brand_list.val()
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

    //Update Model
    $("#edit-model").click(function () {
        var model_id = $("#model_id_edit");
        var brand_id = $("#brand_list_edit");
        var model_name = $("#model_name_edit");
        var model_status = $("#model_status_edit");

        if (model_id.val() !== '' && brand_id.val() !== '' && model_name.val() !== '' && model_status.val() !== '')
        {
            if (check_name_edit === true) {
                $.post("../php/model_mng.php?operation=update", {
                    "model_id": model_id.val(),
                    "brand_id": brand_id.val(),
                    "model_name": model_name.val(),
                    "model_status": model_status.val()
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
//////////////////////////////VALIDATE///////////////////////////////////////////////////////////   
    //Check model
    $("#model_name").blur(function () {
        var errorModel = $("#errorModelName1");
        var model_name = $("#model_name");
        checkModelNameComplete(errorModel, model_name);
    });

    $("#model_name_edit").blur(function () {
        var errorModel = $("#errorModelName2");
        var model_id = $("#model_id_edit");
        var model_name = $("#model_name_edit");
        checkModelNameEditComplete(errorModel, model_id, model_name);
    });
/////////////////////////////////////////////////////////////////////////////////////////////////
    function checkModelNameComplete(errorModel, model_name) {
        if (model_name.val() === "") {
            errorModel.css({"color": "red"});
            errorModel.text("*กรุณากรอกข้อมูล");
            model_name.css({"border-color": "red"});
            model_name.css({"background-color": "lavenderblush"});
            check_name = false;
        }
        else {
            $.post("../php/check_duplicateData.php?operation=model", {
                "model_name": model_name.val()
            }, function (data) {
                if (data.status === true) {
                    errorModel.text("");
                    model_name.css({"border-color": "green"});
                    model_name.css({"background-color": "#d6e9c6"});
                    check_name = true;
                }
                else {
                    errorModel.css({"color": "red"});
                    errorModel.text("*ชื่อนี้ไม่สามารถใช้ได้");
                    model_name.css({"border-color": "red"});
                    model_name.css({"background-color": "lavenderblush"});
                    check_name = false;
                }
            }, "json");
        }
    }

    function checkModelNameEditComplete(errorModel, model_id, model_name) {
        if (model_name.val() === "") {
            errorModel.css({"color": "red"});
            errorModel.text("*กรุณากรอกข้อมูล");
            model_name.css({"border-color": "red"});
            model_name.css({"background-color": "lavenderblush"});
            check_name_edit = false;
        }
        else {
            $.post("../php/check_duplicateData.php?operation=model_edit", {
                "model_id": model_id.val(),
                "model_name": model_name.val()
            }, function (data) {
                if (data.status === true) {
                    errorModel.text("");
                    model_name.css({"border-color": "green"});
                    model_name.css({"background-color": "#d6e9c6"});
                    check_name_edit = true;
                }
                else {
                    errorModel.css({"color": "red"});
                    errorModel.text("*ชื่อนี้ไม่สามารถใช้ได้");
                    model_name.css({"border-color": "red"});
                    model_name.css({"background-color": "lavenderblush"});
                    check_name_edit = false;
                }
            }, "json");
        }
    }
////////////////////////////////////////////////////////////////////////////////////    
});


