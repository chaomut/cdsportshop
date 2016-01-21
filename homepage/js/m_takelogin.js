var checkemail = false;
var checkpassword = false;
$(document).ready(function () {
    var email = $("#login-e-mail");
    var password = $("#login-password");
    var error_email = $("#error-email");
    var error_password = $("#error-password");
    $("#takelogin").click(function () {
        // check กรอกครบหรือไม่
        if (email.val() !== "" && password.val() !== "") {
            // check email and password
            if (checkemail === true && checkpassword === true) {
                $.post("./php/m_takelogin.php", {
                    'email': email.val(),
                    'password': password.val()
                }, function (data) {
                    if (data.status === true) {
                        alert("เข้าสู่ระบบสำเร็จ");
                        location.reload();
                    } else {
                        alert("E-mail หรือ รหัสผ่าน ไม่ถูกต้อง");
                        email.css('border-color', 'red');
                        password.css('border-color', 'red');
                        email.focus();
                    }
                }, "json");
            } else {
                email.focus();
            }
        } else {
            // Email == ""
            if (email.val() === "") {
                email.css('border-color', 'red');
                error_email.text("กรุณากรอก E-mail เพื่อเข้าสู่ระบบ");
            }
            // Password == ""
            if (password.val() === "") {
                password.css('border-color', 'red');
                error_password.text("กรุณากรอก รหัสผ่าน เพื่อเข้าสู่ระบบ");
            }
        }

    });
///////////////////// CHECK FORMAT EMAIL ///////////////////////////////////////
    // Check Format
    $("#login-e-mail").blur(function () {
        if (email.val() !== "") {
            var regex = /^([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)@([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)[\\.]([a-zA-Z]{2,9})$/;
            if (regex.test(email.val())) {
                email.css('border-color', 'green');
                error_email.text("");
                checkemail = true;
            } else {
                email.css('border-color', 'red');
                error_email.text("E-mail ไม่ถูกต้อง");
                email.focus();
            }
        } else {
            email.css('border-color', 'red');
            error_email.text("กรอกข้อมูลให้ครบถ้วน");
            email.focus();
        }
    });
////////////////////////////////////////////////////////////////////////////////
/////////////////// CHECK FORMAT PASSWORD //////////////////////////////////////
    // Check Length
    $("#login-password").blur(function () {
        if (password.val().length < 8) {
            password.css('border-color', 'red');
            error_password.text("รหัสผ่านต้องมี 8 ตัวขึ้นไป ");
            password.focus();
        } else {
            password.css('border-color', 'green');
            checkpassword = true;
        }
    });
    // Check Format
    $("#login-password").keypress(function () {
        if ((event.which >= 48 && event.which <= 57) || (event.which >= 65 && event.which <= 90) || (event.which >= 97 && event.which <= 122)) {
            password.removeAttr('style');
            error_password.text("");
        } else {
            event.preventDefault();
            password.css('border-color', 'red');
            error_password.text("รหัสผ่านใส่ได้เพียงตัวอักษร หรือ ตัวเลขเท่านั้น");
        }
    });
//////////////////////////////////////////////////////////////////////////////////


});