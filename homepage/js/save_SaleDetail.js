var checktel = false;
var checkpostcode = false;
$(document).ready(function () {
//////////////////////////////////////////////////////
// Address Old
    $("#btn-old-address").click(function () {
        var oldaddress = $("input:checked").val();
        saveSaleDetail(oldaddress);
    });
//////////////////////////////////////////////////////
// New Address And Validate 
    ////// Check Fname lname address 
    // Fname
    $('#fname').keypress(function () {
        var fname = $("#fname");
        var errorfname = $("#error-fname");
        checkformat(errorfname, fname);
    });
    //check value
    $('#fname').blur(function () {
        var fname = $("#fname");
        var errorfname = $("#error-fname");
        checkvalue(errorfname, fname);
    });
    // Lname
    $('#lname').keypress(function () {
        var lname = $("#lname");
        var errorlname = $("#error-lname");
        checkformat(errorlname, lname);
    });
    //check value
    $('#lname').blur(function () {
        var lname = $("#lname");
        var errorlname = $("#error-lname");
        checkvalue(errorlname, lname);
    });
    //check value
    $('#address').blur(function () {
        var address = $("#address");
        var erroraddress = $("#error-address");
        checkvalue(erroraddress, address);
    });
    $('#Subdistrict').keypress(function () {
        var Subdistrict = $("#Subdistrict");
        var errorSubdistrict = $("#error-Subdistrict");
        checkformat(errorSubdistrict, Subdistrict);
    });
    //check value
    $('#Subdistrict').blur(function () {
        var Subdistrict = $("#Subdistrict");
        var errorSubdistrict = $("#error-Subdistrict");
        checkvalue(errorSubdistrict, Subdistrict);
    });
    $('#District').keypress(function () {
        var District = $("#District");
        var errorDistrict = $("#error-District");
        checkformat(errorDistrict, District);
    });
    //check value
    $('#District').blur(function () {
        var District = $("#District");
        var errorDistrict = $("#error-District");
        checkvalue(errorDistrict, District);
    });
    $('#Proviance').keypress(function () {
        var Proviance = $("#Proviance");
        var errorProviance = $("#error-Proviance");
        checkformat(errorProviance, Proviance);
    });
    //check value
    $('#Proviance').blur(function () {
        var Proviance = $("#Proviance");
        var errorProviance = $("#error-Proviance");
        checkvalue(errorProviance, Proviance);
    });
    $("#tel").keypress(function () {
        var errortel = $("#error-tel");
        var tel = $("#tel");
        checkTelAndPostCode(errortel, tel);
    });
    $("#tel").blur(function () {
        var errortel = $("#error-tel");
        var tel = $("#tel");
        checkTelLength(errortel, tel);
    });
    ////// Check Postcode **
    $("#postcode").keypress(function () {
        var errorpost = $("#error-postcode");
        var postcode = $("#postcode");
        checkTelAndPostCode(errorpost, postcode);
    });
    $("#postcode").blur(function () {
        var errorpost = $("#error-postcode");
        var postcode = $("#postcode");
        checkPostLength(errorpost, postcode);
    });
    function checkformat(error, textbox) {
        if ((event.which < 65 && (event.which < 96 || event.which > 90 || event.which > 122))) {
            event.preventDefault();
            textbox.css('border-color', 'red');
            error.text("กรอกข้อมูลได้เฉพาะตัวอักษรเท่านั้น");
        } else {
            error.text("");
            textbox.removeAttr('style');
        }
    }
    function checkvalue(error, textbox) {
        if (textbox.val().length <= 0) {
            textbox.css('border-color', 'red');
            error.text("กรุณากรอกข้อมูลให้ครบถ้วน");
        } else {
            error.text("");
            textbox.css('border-color', 'green');
        }
    }
    function checkTelAndPostCode(errortel, textbox) {
        if (event.which > 31 && event.which < 48 || event.which > 57) {
            event.preventDefault();
            textbox.css('border-color', 'red');
            errortel.text("กรอกเฉาะตัวเลขเท่านั้น");
        } else {
            textbox.removeAttr('style');
            errortel.text("");
        }
    }
    function checkTelLength(errortel, textbox) {
        if (textbox.val().length >= 9 && textbox.val().length <= 10) {
            errortel.text("");
            textbox.css("border-color", "green");
            checktel = true;
        } else {
            textbox.css("border-color", "red");
            errortel.text("กรุณากรอกข้อมูลอย่างน้อย 9 ตัว");
            checktel = false;
        }
    }
    function checkPostLength(errorpost, textbox) {
        if (textbox.val().length === 5) {
            errorpost.text("");
            textbox.css("border-color", "green");
            checkpostcode = true;
        } else {
            textbox.css("border-color", "red");
            errorpost.text("กรุณากรอกข้อมูลรหัสไปรษณีย์ให้ถูกต้อง");
            checkpostcode = false;
        }
    }
// New Address
    $("#btn-new-address").click(function () {
        var fname = $("#fname");
        var lname = $("#lname");
        var address = $("#address");
        var subdistrict = $("#Subdistrict");
        var district = $("#District");
        var proviance = $("#Proviance");
        var postcode = $("#postcode");
        var tel = $("#tel");
        if (checktel === true) {
            if (checkpostcode === true) {
                if (fname.val() !== "" &&
                        lname.val() !== "" && address.val() !== "" &&
                        tel.val() !== "" && district.val() !== "" &&
                        subdistrict.val() !== "" && proviance.val() !== "" &&
                        postcode.val() !== "") {
                    var newAddress = fname.val() + " " + lname.val() + " "
                            + address.val() + " แขวง"
                            + subdistrict.val() + " เขต"
                            + district.val() + " จังหวัด"
                            + proviance.val() + " "
                            + postcode.val() + " "
                            + tel.val();
                    saveSaleDetail(newAddress);
                } else {
                    alert("กรุณากรอกข้อมูลให้ครบทุกช่อง");
                }
            } else {
                alert("กรุณากรอกรหัสไปรษณีย์");
                postcode.focus();
            }
        } else {
            alert("กรุณากรอกเบอร์โทรศัพท์");
            tel.focus();
        }

    });
//////////////////////////////////////////////////////
/////// Save Sale Detail
    function saveSaleDetail(address) {
        $.post("./php/save_SaleDetail.php", {
            "address": address
        }, function (data) {
            if (data.status === false) {
                alert(data.msg);
                window.location.href = "mycart_page.php";
            } else {
                window.location.href = "save_detail_page.php?save=sale";
            }
        }, "json");
    }
});

