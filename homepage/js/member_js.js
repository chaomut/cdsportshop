var checkemail = false;
var checktel = false;
var checkpostcode = false;
var checkpassword = false;
$(document).ready(function () {
////// Check Email **
    $("#e-mail").blur(function () {
        checkDupEmail();
    });
////// Check Tel **
    $("#tel-recovery").keypress(function () {
        var errortel = $("#error-tel-recovery");
        checkTelAndPostCode(errortel);
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
/////////////////////////////////////
///// Check Re-Password **
    $("#re-password").keyup(function () {
        var errorRePwd = $("#error-Repassword");
        var password = $("#password");
        var rePassword = $("#re-password");
        checkRePassword(errorRePwd, password, rePassword);
    });
    $("#re-password").keypress(function () {
        var errorRePwd = $("#error-Repassword");
        var Repassword = $("#re-password");
        checkFormatPassword2(errorRePwd, Repassword);
    });
///// Signup
    $("#btn-signup").click(function () {
        checkSigup();
    });

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
});
///////////////////////////////////////////////////////
//
//
///////////////////////////////////////////////////////
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
///////////////////////////////////////////////////////
//
//
///////////////////////////////////////////////////////
function checkRePassword(errorRePwd, password, rePassword) {
    if (rePassword.val().trim().length === 0) {
        errorRePwd.text("กรุณาใส่รหัสผ่านอีกครั้ง !");
        errorRePwd.removeClass("text-success");
        errorRePwd.addClass("text-danger");
        rePassword.css("border-color", "red");
        checkpassword = false;
    } else if (password.val() !== rePassword.val()) {
        errorRePwd.text("รหัสผ่านไม่ตรงกัน");
        errorRePwd.removeClass("text-success");
        errorRePwd.addClass("text-danger");
        rePassword.css("border-color", "red");
        checkpassword = false;
    } else {
        password.css("border-color", "green");
        rePassword.css("border-color", "green");
        errorRePwd.removeClass("text-danger");
        errorRePwd.addClass("text-success");
        errorRePwd.text("รหัสผ่านตรงกัน");
        checkpassword = true;
    }
}
/////////////////////////////////////////////////////////////
// Check Pass
function checkFormatPassword(errorPwd, password) {
    if (password.val().length >= 8) {
        password.css("border-color", "green");
        errorPwd.text("");
    } else {
        errorPwd.addClass("text-danger");
        password.css("border-color", "red");
        errorPwd.text("กรุณากรอกข้อมูลอย่างน้อย 8 ตัว");
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
//////////////////////////////////////////////////////////////
///// check dup and format Email
function checkDupEmail() {
    var regex = /^([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)@([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)[\\.]([a-zA-Z]{2,9})$/;
    var email = $("#e-mail");
    var error = $("#error-email");
    if (email.val().trim() !== "") {
        if (regex.test(email.val())) {
            $.post("./php/m_check_email_dup.php", {
                "email": email.val()
            }, function (data) {
                if (data.status === false) {
                    email.css('border-color', 'red');
                    error.text(data.msg);
                    checkemail = false;
                } else {
                    email.css('border-color', 'green');
                    error.addClass('text-success');
                    error.text(data.msg);
                    checkemail = true;
                }
            }, "json");
        } else {
            email.css('border-color', 'red');
            error.text("E-mail ไม่ถูกต้อง");
        }
    } else {
        email.css('border-color', 'red');
        error.text("กรุณากรอก E-mail เพื่อใช้สำหรับเข้าสู่ระบบ");
    }
}
///////////////////////////////////////////////////////
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
///////////////////////////////////////////////////////
//
//
///////////////////////////////////////////////////////
function checkSigup() {
    var email = $("#e-mail");
    var fname = $("#fname");
    var lname = $("#lname");
    var address = $("#address");
    var district = $("#District");
    var subdistrict = $("#Subdistrict");
    var proviance = $("#Proviance");
    var postcode = $("#postcode");
    var tel = $("#tel");
    var password = $("#password");
    var repassword = $("#re-password");
    if (checkemail === true) {
        if (checktel === true) {
            if (checkpostcode === true) {
                if (email.val() !== "" && fname.val() !== "" &&
                        lname.val() !== "" && address.val() !== "" &&
                        tel.val() !== "" && password.val() !== "" &&
                        repassword.val() !== "" && district.val() !== "" &&
                        subdistrict.val() !== "" && proviance.val() !== "" &&
                        postcode.val() !== "") {
                    var addressAll = " " + address.val() + " แขวง" + subdistrict.val() + " เขต" + district.val() + " จังหวัด" + proviance.val() + " ," + postcode.val();
                    $.post("./php/m_sigup.php", {
                        "email": email.val(),
                        "fname": fname.val(),
                        "lname": lname.val(),
                        "address": addressAll,
                        "tel": tel.val(),
                        "password": password.val()
                    }, function (data) {
                        if (data.msg === "true") {
                            location.href = "./login_page.php";
                        } else {
                            alert("สมัครสมาชิกไม่สำเร็จ");
                        }
                    }, "json");
                    $chek = false;
                } else {
                    alert("กรุณากรอกข้อมูลให้ครบทุกช่อง");
                }
            } else {
                postcode.focus();
            }
        } else {
            tel.focus();
        }
    } else {
        email.focus();
    }
}
//////////////////////////////////////////////////////
//
//////////////////////////////////////////////////////


