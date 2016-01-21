var check_ems = true;
var check_date = true;

$(document).ready(function () {
///////////////////////////////////////////////////////////////////////////////    
    //Select Delivery
    $.post("../php/delivery_detail.php?operation=select", {}, function (data) {
        $("#show-delivery").html(data.html1);
        $("#select-sale_id").html(data.html2);
    }, "json");

    //Update Delivery
    $("#submit-delivery").click(function () {
        var sale_id = $("#sale_id");
        var delivery_date = $("#delivery_date");
        var ems_id = $("#ems_id");
        var admin_id = $("#admin_id");

        var con = confirm("ยืนยันการบันทึกการจัดส่งสินค้า");
        if (con === true) {
            if (sale_id.val() !== '' && delivery_date.val() !== '' && ems_id.val() !== '')
            {
                $.post("../php/delivery_detail.php?operation=update", {
                    "sale_id": sale_id.val(),
                    "delivery_date": delivery_date.val(),
                    "ems_id": ems_id.val(),
                    "admin_id": admin_id.val()
                }, function (data) {
                    location.reload();
                }, "json");
            } else
                alert("กรุณากรอกข้อมูลให้ครบถ้วน");
        }
    });
/////////////////////////////////////////////////////////////////////////////////////////    
//////////////////////////VALIDATE///////////////////////////////////////////////////////    
    //Check EMS
    $("#ems_id").keypress(function () {
        var errorDelivery = $("#errorEms");
        checkEms(errorDelivery);
    });
    $("#ems_id").blur(function () {
        var errorDelivery = $("#errorEms");
        var ems_id = $("#ems_id");
        checkEmsComplete(errorDelivery, ems_id);
    });

    //Check Date
    $("#delivery_date").blur(function () {
        var errorDelivery = $("#errorDate");
        var delivery_date = $("#delivery_date");
        checkDateComplete(errorDelivery, delivery_date);
    });
/////////////////////////////////////////////////////////////////////////////////

    function checkEms(errorDelivery) {

        if ((event.which > 47 && event.which < 58) || (event.which > 64 && event.which < 91) ||
                (event.which > 96 && event.which < 123)) {

            errorDelivery.text("");
            check_ems = true;
        } else {
            event.preventDefault();
            errorDelivery.css({"color": "red"});
            errorDelivery.text("*กรุณากรอกเป็นตัวอักษร หรือ ตัวเลข");
            check_ems = false;
        }
    }

    function checkEmsComplete(errorDelivery, ems_id) {
        if (ems_id.val() === "") {
            errorDelivery.css({"color": "red"});
            errorDelivery.text("*กรุณากรอกข้อมูล");
            ems_id.css({"border-color": "red"});
            ems_id.css({"background-color": "lavenderblush"});
            check_ems = false;
        } else if (ems_id.val().length < 13) {
            errorDelivery.css({"color": "red"});
            errorDelivery.text("*กรุณากรอกข้อมูลให้ครบ 13 ตัว");
            ems_id.css({"border-color": "red"});
            ems_id.css({"background-color": "lavenderblush"});
            check_ems = false;
        } else {
            errorDelivery.text("");
            ems_id.css({"border-color": "green"});
            ems_id.css({"background-color": "#d6e9c6"});
            check_ems = true;
        }
    }

    function checkDateComplete(errorDelivery, delivery_date) {
        if (delivery_date.val() === "") {
            errorDelivery.css({"color": "red"});
            errorDelivery.text("*กรุณากรอกข้อมูล");
            delivery_date.css({"border-color": "red"});
            delivery_date.css({"background-color": "lavenderblush"});
            check_date = false;
        } else {
            errorDelivery.text("");
            delivery_date.css({"border-color": "green"});
            delivery_date.css({"background-color": "#d6e9c6"});
            check_date = true;
        }
    }
//////////////////////////////////////////////////////////////////////////////////    
});

