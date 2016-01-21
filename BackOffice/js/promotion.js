var check_name = true;
var check_start = true;
var check_end = true;
var check_discount = true;

var check_name_edit = true;
var check_start_edit = true;
var check_end_edit = true;
var check_discount_edit = true;

$(document).ready(function() {  
    //Select Promotion
    $.post("../php/promotion_mng.php?operation=select", {}, function(data) {
        $("#show-promotion").html(data.html1);
    }, "json");
    //Insert Promotion
    $("#add-promotion").click(function() {
        var pro_name = $("#pro_name");
        var pro_detail = $("#pro_detail");
        var start_date = $("#start_date");
        var end_date = $("#end_date");
        var discount = $("#discount");
        if (pro_name.val() !== '' && start_date.val() !== ''
                && end_date.val() !== '' && discount.val() !== '')
        {
            if (check_name === true && check_start === true && check_end === true && check_discount === true) {
                $.post("../php/promotion_mng.php?operation=insert", {
                    "pro_name": pro_name.val(),
                    "pro_detail": pro_detail.val(),
                    "start_date": start_date.val(),
                    "end_date": end_date.val(),
                    "discount": discount.val()
                }, function(data) {
                    location.reload();
                }, "json");
            }
            else
                alert("กรุณากรอกข้อมูลให้ถูกต้อง");
        }
        else
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
    });
    //Update Promotion
    $("#edit-promotion").click(function() {
        var pro_id = $("#pro_id_edit");
        var pro_name = $("#pro_name_edit");
        var pro_detail = $("#pro_detail_edit");
        var start_date = $("#start_date_edit");
        var end_date = $("#end_date_edit");
        var discount = $("#discount_edit");
        if (pro_id.val() !== '' && pro_name.val() !== '' && start_date.val() !== ''
                && end_date.val() !== '' && discount.val() !== '')
        {
            if (check_name_edit === true && check_start_edit === true && check_end_edit === true &&
                    check_discount_edit === true) {
                $.post("../php/promotion_mng.php?operation=update", {
                    "pro_id": pro_id.val(),
                    "pro_name": pro_name.val(),
                    "pro_detail": pro_detail.val(),
                    "start_date": start_date.val(),
                    "end_date": end_date.val(),
                    "discount": discount.val()
                }, function(data) {
                    location.reload();
                }, "json");
            }
            else
                alert("กรุณากรอกข้อมูลให้ถูกต้อง");
        }
        else
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
    });
////////////////////////////////////VALIDATE////////////////////////////////////////
//Check Promotion

    //Pro Name
    $("#pro_name").blur(function() {
        var errorPromotion = $("#errorProName1");
        var pro_name = $("#pro_name");
        checkProNameComplete(errorPromotion, pro_name);
    });

    //Pro Name Edit
    $("#pro_name_edit").blur(function() {
        var pro_id = $("#pro_id_edit");
        var errorPromotion = $("#errorProName2");
        var pro_name = $("#pro_name_edit");
        checkProNameEditComplete(errorPromotion, pro_id, pro_name);
    });

    //Start Date
    $("#start_date").blur(function() {
        var errorPromotion = $("#errorStart1");
        var start_date = $("#start_date");
        checkProStartComplete(errorPromotion, start_date);
    });
    $("#start_date_edit").blur(function() {
        var errorPromotion = $("#errorStart2");
        var pro_id = $("#pro_id_edit");
        var start_date = $("#start_date_edit");
        checkProStartEditComplete(errorPromotion, pro_id, start_date);
    });

    //End Date
    $("#end_date").blur(function() {
        var errorPromotion = $("#errorEnd1");
        var start_date = $("#start_date");
        var end_date = $("#end_date");
        checkProEndComplete(errorPromotion, start_date, end_date);
    });
    
    $("#end_date_edit").blur(function() {
        var errorPromotion = $("#errorEnd2");
        var start_date = $("#start_date_edit");
        var end_date = $("#end_date_edit");
        var pro_id = $("#pro_id_edit");
        checkProEndEditComplete(errorPromotion, start_date, end_date, pro_id);
    });

    //Discount
    $("#discount").keypress(function() {
        var errorPromotion = $("#errorProDiscount1");
        checkProDiscount(errorPromotion);
    });

    $("#discount").blur(function() {
        var errorPromotion = $("#errorProDiscount1");
        var discount = $("#discount");
        checkProDiscountComplete(errorPromotion, discount);
    });

    $("#discount_edit").keypress(function() {
        var errorPromotion = $("#errorProDiscount2");
        checkProDiscountEdit(errorPromotion);
    });
    
    $("#discount_edit").blur(function() {
        var errorPromotion = $("#errorProDiscount2");
        var discount = $("#discount_edit");
        checkProDiscountEditComplete(errorPromotion, discount);
    });    
////////////////////////////////////////////////////////////////////////////////
//Check Promotion Name
    function checkProNameComplete(errorPromotion, pro_name) {
        if (pro_name.val() === "") {
            errorPromotion.css({"color": "red"});
            errorPromotion.text("*กรุณากรอกข้อมูล");
            pro_name.css({"border-color": "red"});
            pro_name.css({"background-color": "lavenderblush"});
            check_name = false;
        }
        else {
            $.post("../php/check_duplicateData.php?operation=promotion", {
                "pro_name": pro_name.val()
            }, function(data) {
                if (data.status === true) {
                    errorPromotion.text("");
                    pro_name.css({"border-color": "green"});
                    pro_name.css({"background-color": "#d6e9c6"});
                    check_name = true;
                }
                else {
                    errorPromotion.css({"color": "red"});
                    errorPromotion.text("*ชื่อนี้ไม่สามารถใช้ได้");
                    pro_name.css({"border-color": "red"});
                    pro_name.css({"background-color": "lavenderblush"});
                    check_name = false;
                }
            }, "json");
        }
    }
//Check Promotion Name Edit
    function checkProNameEditComplete(errorPromotion, pro_id, pro_name) {
        if (pro_name.val() === "") {
            errorPromotion.css({"color": "red"});
            errorPromotion.text("*กรุณากรอกข้อมูล");
            pro_name.css({"border-color": "red"});
            pro_name.css({"background-color": "lavenderblush"});
            check_name_edit = false;
        }
        else {
            $.post("../php/check_duplicateData.php?operation=promotion_edit", {
                "pro_id": pro_id.val(),
                "pro_name": pro_name.val()
            }, function(data) {
                if (data.status === true) {
                    errorPromotion.text("");
                    pro_name.css({"border-color": "green"});
                    pro_name.css({"background-color": "#d6e9c6"});
                    check_name_edit = true;
                }
                else {
                    errorPromotion.css({"color": "red"});
                    errorPromotion.text("*ชื่อนี้ไม่สามารถใช้ได้");
                    pro_name.css({"border-color": "red"});
                    pro_name.css({"background-color": "lavenderblush"});
                    check_name_edit = false;
                }
            }, "json");
        }
    }
//Check Pro Start
    function checkProStartComplete(errorPromotion, start_date) {
        if (start_date.val() === "") {
            errorPromotion.css({"color": "red"});
            errorPromotion.text("*กรุณากรอกข้อมูล");
            start_date.css({"border-color": "red"});
            start_date.css({"background-color": "lavenderblush"});
            check_start = false;
        }
        else {
            $.post("../php/check_duplicateData.php?operation=promotion_start", {
                "start_date": start_date.val()
            }, function(data) {
                if (data.status === true) {
                    errorPromotion.text("");
                    start_date.css({"border-color": "green"});
                    start_date.css({"background-color": "#d6e9c6"});
                    check_start = true;
                }
                else {
                    errorPromotion.css({"color": "red"});
                    errorPromotion.text("*วันที่นี้ไม่สามารถใช้ได้");
                    start_date.css({"border-color": "red"});
                    start_date.css({"background-color": "lavenderblush"});
                    check_start = false;
                }
            }, "json");
        }
    }
//Check Pro Start Edit
    function checkProStartEditComplete(errorPromotion, pro_id, start_date) {
        if (start_date.val() === "") {
            errorPromotion.css({"color": "red"});
            errorPromotion.text("*กรุณากรอกข้อมูล");
            start_date.css({"border-color": "red"});
            start_date.css({"background-color": "lavenderblush"});
            check_start_edit = false;
        }
        else {
            $.post("../php/check_duplicateData.php?operation=promotion_start_edit", {
                "pro_id": pro_id.val(),
                "start_date": start_date.val()
            }, function(data) {
                if (data.status === true) {
                    errorPromotion.text("");
                    start_date.css({"border-color": "green"});
                    start_date.css({"background-color": "#d6e9c6"});
                    check_start_edit = true;
                }
                else {
                    errorPromotion.css({"color": "red"});
                    errorPromotion.text("*วันที่นี้ไม่สามารถใช้ได้");
                    start_date.css({"border-color": "red"});
                    start_date.css({"background-color": "lavenderblush"});
                    check_start_edit = false;
                }
            }, "json");
        }
    }

//Check Pro End
    function checkProEndComplete(errorPromotion, start_date, end_date) {
        if (end_date.val() === "") {
            errorPromotion.css({"color": "red"});
            errorPromotion.text("*กรุณากรอกข้อมูล");
            end_date.css({"border-color": "red"});
            end_date.css({"background-color": "lavenderblush"});
            check_end = false;
        }
        else if (end_date.val() <= start_date.val()) {
            errorPromotion.css({"color": "red"});
            errorPromotion.text("*วันที่นี้ไม่สามารถใช้ได้");
            end_date.css({"border-color": "red"});
            end_date.css({"background-color": "lavenderblush"});
            check_end = false;
        }
        else {
            errorPromotion.text("");
            end_date.css({"border-color": "green"});
            end_date.css({"background-color": "#d6e9c6"});
            check_end = true;
        }
    }
//Check Pro End Edit
    function checkProEndEditComplete(errorPromotion, start_date, end_date, pro_id) {
        if (end_date.val() === "") {
            errorPromotion.css({"color": "red"});
            errorPromotion.text("*กรุณากรอกข้อมูล");
            end_date.css({"border-color": "red"});
            end_date.css({"background-color": "lavenderblush"});
            check_end_edit = false;
        }
        else if (end_date.val() <= start_date.val()) {
            errorPromotion.css({"color": "red"});
            errorPromotion.text("*วันที่นี้ไม่สามารถใช้ได้");
            end_date.css({"border-color": "red"});
            end_date.css({"background-color": "lavenderblush"});
            check_end_edit = false;
        }
        else {
            $.post("../php/check_duplicateData.php?operation=promotion_end_edit", {
                "pro_id": pro_id.val(),
                "end_date": end_date.val()
            }, function(data) {
                if (data.status === true) {
                    errorPromotion.text("");
                    end_date.css({"border-color": "green"});
                    end_date.css({"background-color": "#d6e9c6"});
                    check_end_edit = true;
                }
                else {
                    errorPromotion.css({"color": "red"});
                    errorPromotion.text("*วันที่นี้ไม่สามารถใช้ได้");
                    end_date.css({"border-color": "red"});
                    end_date.css({"background-color": "lavenderblush"});
                    check_end_edit = false;
                }
            }, "json");
        }
    }

    //Check Discount 
    function checkProDiscount(errorPromotion) {

        if (event.which >= 48 && event.which <= 57) {
            errorPromotion.text("");
            check_discount = true;
        }
        else {
            event.preventDefault();
            errorPromotion.css({"color": "red"});
            errorPromotion.text("*กรุณากรอกเป็นตัวเลข");
            check_discount = false;
        }
    }

    function checkProDiscountComplete(errorPromotion, discount) {
        if (discount.val() === "") {
            errorPromotion.css({"color": "red"});
            errorPromotion.text("*กรุณากรอกข้อมูล");
            discount.css({"border-color": "red"});
            discount.css({"background-color": "lavenderblush"});
            check_discount = false;
        }
        else {
            errorPromotion.text("");
            discount.css({"border-color": "green"});
            discount.css({"background-color": "#d6e9c6"});
            check_discount = true;
        }
    }

    function checkProDiscountEdit(errorPromotion) {

        if (event.which >= 48 && event.which <= 57) {
            errorPromotion.text("");
            check_discount_edit = true;
        }
        else {
            event.preventDefault();
            errorPromotion.css({"color": "red"});
            errorPromotion.text("*กรุณากรอกเป็นตัวเลข");
            check_discount_edit = false;
        }
    }

    function checkProDiscountEditComplete(errorPromotion, discount) {
        if (discount.val() === "") {
            errorPromotion.css({"color": "red"});
            errorPromotion.text("*กรุณากรอกข้อมูล");
            discount.css({"border-color": "red"});
            discount.css({"background-color": "lavenderblush"});
            check_discount_edit = false;
        }
        else {
            errorPromotion.text("");
            discount.css({"border-color": "green"});
            discount.css({"background-color": "#d6e9c6"});
            check_discount_edit = true;
        }
    }
/////////////////////////////////////////////////////////////////////////////////    
});