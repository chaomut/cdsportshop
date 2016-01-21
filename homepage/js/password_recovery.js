var checkpassword = false;
var checktel = false;
var checkemail = false;
$(document).ready(function () {
    ////// Check Email **
    $("#email-recovery").blur(function () {
        checkEmail();
    });
    ////// Check Tel **
    $("#recovery-tel").keypress(function () {
        var tel = $("#recovery-tel");
        var errortel = $("#error-recovery-tel");
        checkTelAndPostCode(errortel, tel);
    });
    $("#recovery-tel").blur(function () {
        var tel = $("#recovery-tel");
        var errortel = $("#error-recovery-tel");
        checkTelLength(errortel, tel);
    });
///// Check Format Password ** ////////////
    $("#recovery-password").keypress(function () {
        var errorRePwd = $("#error-recovery-password");
        var password = $("#recovery-password");
        checkFormatPassword2(errorRePwd, password);
    });
    $("#recovery-password").blur(function () {
        var errorRePwd = $("#error-recovery-password");
        var password = $("#recovery-password");
        checkFormatPassword(errorRePwd, password);
    });
/////////////////////////////////////
///// Check Re-Password **
    $("#recovery-password-again").keyup(function () {
        var errorRePwd = $("#error-recovery-password-again");
        var password = $("#recovery-password");
        var rePassword = $("#recovery-password-again");
        checkRePassword(errorRePwd, password, rePassword);
    });
    $("#recovery-password-again").keypress(function () {
        var errorRePwd = $("#error-recovery-password-again");
        var Repassword = $("#recovery-password-again");
        checkFormatPassword2(errorRePwd, Repassword);
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
    function checkEmail() {
        var regex = /^([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)@([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)[\\.]([a-zA-Z]{2,9})$/;
        var email = $("#email-recovery");
        var error = $("#error-email-recovery");
        if (email.val().trim() !== "") {
            if (regex.test(email.val())) {
                email.css('border-color', 'green');
                error.text("");
                checkemail = true;
            } else {
                email.css('border-color', 'red');
                error.text("E-mail ไม่ถูกต้อง");
                checkemail = false;
            }
        } else {
            email.css('border-color', 'red');
            error.text("กรุณากรอก E-mail เพื่อใช้สำหรับเข้าสู่ระบบ");
            checkemail = false;
        }
    }
   $('#recovery-pass-btn').click(function () {
        var email = $("#email-recovery");
        var tel = $("#recovery-tel");
        var pass = $("#recovery-password");
        var pass_again = $("#recovery-password-again");
        if (checkpassword === true) {
            if (checktel === true) {
                if (checkemail === true) {
                    $.post("./php/m_recoverypwd.php", {
                        "email": email.val(),
                        "tel": tel.val(),
                        "password": pass.val()
                    }, function (data) {
                        if (data.status === true)
                        {
                            alert("การเปลี่ยนรหัสเสร้จสมบูรณ์");
                            location.href = "./login_page.php";
                        } else {
                            alert("การเปลี่ยนรหัสผ่านผิดพลาด !");
                        }
                    }, "json");
                } else {
                    email.focus();
                }
            } else {
                tel.focus();
            }
        } else {
            pass_again.focus();
        }
    })
});

