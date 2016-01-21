var checktel = true;
var checkpostcode = true;
var checkpassword = false;
$(document).ready(function () {
    $("#edit-profile").click(function () {
        $('#fname').removeAttr('readonly');
        $('#lname').removeAttr('readonly');
        $('#address').removeAttr('readonly');
        $('#Subdistrict').removeAttr('readonly');
        $('#District').removeAttr('readonly');
        $('#Proviance').removeAttr('readonly');
        $('#tel').removeAttr('readonly');
        $('#postcode').removeAttr('readonly');
        $('#tel').focus();
    });
///// Check Format Password ** ////////////
    $("#password").keypress(function () {
        var errorRePwd = $("#error-password");
        var password = $("#password");
        checkFormatPassword2(errorRePwd, password);
    });
    $("#password").blur(function () {
        var errorRePwd = $("#error-password");
        var password = $("#password");
        checkFormatPassword(errorRePwd, password);
    });
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
    // District
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
    // Subdistrict
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
    // Proviance
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
    //check value
    $('#address').blur(function () {
        var address = $("#address");
        var erroraddress = $("#error-address");
        checkvalue(erroraddress, address);
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
    // Check Pass
    function checkFormatPassword(errorPwd, password) {
        if (password.val().length >= 8) {
            password.css("border-color", "green");
            errorPwd.text("");
            checkpassword = true;
        } else {
            errorPwd.addClass("text-danger");
            password.css("border-color", "red");
            errorPwd.text("กรุณากรอกข้อมูลอย่างน้อย 8 ตัว");
            checkpassword = false;
        }
    }
    function checkFormatPassword2(errorPwd, textbox) {
        if ((event.which >= 48 && event.which <= 57) || (event.which >= 65 && event.which <= 90) || (event.which >= 97 && event.which <= 122)) {
            errorPwd.text("");
            textbox.removeAttr('style');
        } else {
            event.preventDefault();
            errorPwd.removeClass("text-success");
            errorPwd.addClass("text-danger");
            textbox.css("border-color", "red");
            errorPwd.text("กรอกได้เฉพาะตัวเลข หรือ ตัวอักษรเท่านั้น");
        }
    }
    function checkformat(error, textbox) {
        if ((event.which < 45 || (event.which > 45 && event.which < 65) || (event.which > 90 && event.which < 97)
                || (event.which > 122 && event.which < 256))) {
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
    $("#update_profile").click(function () {
        var fname_member = $("#fname");
        var lname_member = $("#lname");
        var tel_member = $("#tel");
        var address_member = $("#address");
        var Subdistrict = $("#Subdistrict");
        var District = $("#District");
        var Proviance = $("#Proviance");
        var postcode = $("#postcode");
        var password = $("#password");
        if (checktel === true) {
            if (checkpostcode === true) {
                if (checkpassword === true) {
                    if (fname_member.val() !== ""
                            && lname_member.val() !== ""
                            && addressAll !== ""
                            && tel_member !== ""
                            && password.val() !== ""
                            && Subdistrict.val() !== ""
                            && District.val() !== ""
                            && Proviance.val() !== "") {
                        var addressAll = " " + address_member.val() + " แขวง" + Subdistrict.val() + " เขต" + District.val() + " จังหวัด" + Proviance.val() + " ," + postcode.val();
                        $.post("./php/change_Profile.php", {
                            "fname": fname_member.val(),
                            "lname": lname_member.val(),
                            "address": addressAll,
                            "tel": tel_member.val(),
                            "password": password.val()
                        }, function (data) {
                            if (data.status === true)
                            {
                                alert("การเปลี่ยนเสร็จสมบูรณ์");
                                location.reload();
                            } else {
                                alert("รหัสผ่าน : ของคุณไม่ถูกต้องกรุณากรอกใหม่อีกครั้ง");
                                password.val("");
                                password.focus();

                            }
                        }, "json");
                    } else {
                        alert("กรุณากรอกข้อมูลให้ครบทุกช่อง");
                    }
                } else {
                    password.focus();
                }
            } else {
                postcode.focus();
            }
        } else {
            tel_member.focus();
        }
    });
});