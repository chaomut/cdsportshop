
var check_tel = true;
var check_email = true;
var check_pass = true;

$(document).ready(function() {

    $("#save-new-password").click(function() {
        var admin_email = $("#admin_email");
        var admin_tel = $("#admin_tel");
        var admin_pass = $("#admin_pass");
        var admin_repass = $("#admin_repass");


        if (admin_email.val() !== '' && admin_tel.val() !== ''
                && admin_pass.val() !== '' && admin_repass.val() !== '')
        {
            if (check_email === true && check_tel === true && check_pass === true) {
                $.post("../php/forgot_password_mng.php?operation=update", {
                    "admin_email": admin_email.val(),
                    "admin_tel": admin_tel.val(),
                    "admin_pass": admin_pass.val()

                }, function(data) {
                    if (data.status === true) {
                        alert("รหัสผ่านถูกเปลี่ยนเรียบร้อย");
                        location.href = "../login_back.php";
                    }
                    else{
                        alert("Email หรือ เบอร์โทร ไม่ถูกต้อง");
                    }
                }, "json");
            }
            else
                alert("กรุณากรอกข้อมูลให้ถูกต้อง");
        }
        else
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
    });

////////////////////////////////VALIDATE//////////////////////////////////////////
    //Admin Email
    $("#admin_email").blur(function() {
        var errorAdmin = $("#errorAdminEmail1");
        var admin_email = $("#admin_email");
        checkEmailFormat(errorAdmin, admin_email);
    });

    //Admin Tel
    $("#admin_tel").keypress(function() {
        var errorAdmin = $("#errorAdminTel1");
        checkAdminTel(errorAdmin);
    });
    $("#admin_tel").blur(function() {
        var errorAdmin = $("#errorAdminTel1");
        var admin_tel = $("#admin_tel");
        checkAdminTelComplete(errorAdmin, admin_tel);
    });

////////////////////////////////////////////////////////////////////////////////
    //Admin Pass
    $("#admin_pass").keypress(function() {
        var errorAdmin = $("#errorAdminPass");
        checkAdminPass(errorAdmin);
    });
    $("#admin_pass").blur(function() {
        var errorAdmin = $("#errorAdminPass");
        var admin_pass = $("#admin_pass");
        checkAdminPassComplete(errorAdmin, admin_pass);
    });
    $("#admin_repass").keypress(function() {
        var errorAdmin = $("#errorAdminRePass");
        checkAdminPass(errorAdmin);
    });
    $("#admin_repass").blur(function() {
        var errorAdmin = $("#errorAdminRePass");
        var admin_pass = $("#admin_pass");
        var admin_repass = $("#admin_repass");
        checkAdminRePassComplete(errorAdmin, admin_pass, admin_repass);
    });
//////////////////////////////////////////////////////////////////////////////////////////////////
    //Check Admin Tel
    function checkAdminTel(errorAdmin) {
        if (event.which < 48 || event.which > 57) {
            event.preventDefault();
            errorAdmin.css({"color": "red"});
            errorAdmin.text("*กรุณากรอกเป็นตัวเลข");
            check_tel = false;
        }
        else {
            errorAdmin.text("");
            check_tel = true;
        }
    }

    function checkAdminTelComplete(errorAdmin, admin_tel) {
        if (admin_tel.val().length < 9) {
            errorAdmin.css({"color": "red"});
            errorAdmin.text("*กรุณากรอกข้อมูลอย่างน้อย 9 หลัก");
            admin_tel.css({"border-color": "red"});
            admin_tel.css({"background-color": "lavenderblush"});
            check_tel = false;
        } else {
            errorAdmin.text("");
            admin_tel.css({"border-color": "green"});
            admin_tel.css({"background-color": "#d6e9c6"});
            check_tel = true;
        }
    }

//////////////////////////////////////////////////////////////////////////////////////////
    //Check Email
    function checkEmailFormat(errorAdmin, admin_email) {
        var regex = /^([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)@([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)[\\.]([a-zA-Z]{2,9})$/;
        if (regex.test(admin_email.val())) {
            errorAdmin.text("");
            admin_email.css({"border-color": "green"});
            admin_email.css({"background-color": "#d6e9c6"});
            check_email = true;
        }
        else {
            errorAdmin.css({"color": "red"});
            errorAdmin.text("*Email ไม่ถูกต้อง");
            admin_email.css({"border-color": "red"});
            admin_email.css({"background-color": "lavenderblush"});
            check_email = false;
        }
    }


/////////////////////////////////////////////////////////////////////////
    //Check Pass
    function checkAdminPass(errorAdmin, admin_pass) {

        if ((event.which >= 33 && event.which <= 255)) {
            errorAdmin.text("");
            admin_pass.css({"border-color": "green"});
            admin_pass.css({"background-color": "#d6e9c6"});
            check_pass = true;
        }
        else {
            event.preventDefault();
            errorAdmin.css({"color": "red"});
            errorAdmin.text("*กรุณากรอกข้อมูลให้ถูกต้องตามรูปแบบ");
            check_pass = false;
        }
    }

    function checkAdminPassComplete(errorAdmin, admin_pass) {
        if (admin_pass.val().length < 8) {
            errorAdmin.css({"color": "red"});
            errorAdmin.text("*กรุณากรอกข้อมูลอย่างน้อย 8 ตัว");
            admin_pass.css({"border-color": "red"});
            admin_pass.css({"background-color": "lavenderblush"});
            check_pass = false;
        } else {
            errorAdmin.text("");
            admin_pass.css({"border-color": "green"});
            admin_pass.css({"background-color": "#d6e9c6"});
            check_pass = true;
        }
    }

    function checkAdminRePassComplete(errorAdmin, admin_pass, admin_repass) {
        if (admin_repass.val().length < 8) {
            errorAdmin.css({"color": "red"});
            errorAdmin.text("*กรุณากรอกข้อมูลอย่างน้อย 8 ตัว");
            admin_repass.css({"border-color": "red"});
            admin_repass.css({"background-color": "lavenderblush"});
            check_pass = false;
        }
        else if (admin_pass.val() === admin_repass.val()) {
            errorAdmin.text("");
            admin_repass.css({"border-color": "green"});
            admin_repass.css({"background-color": "#d6e9c6"});
            check_pass = true;
        }
        else {
            errorAdmin.css({"color": "red"});
            errorAdmin.text("*รหัสผ่านไม่ตรงกัน");
            admin_repass.css({"border-color": "red"});
            admin_repass.css({"background-color": "lavenderblush"});
            check_pass = false;
        }

        if (admin_repass.val() === "") {
            errorAdmin.text("*กรุณากรอกรหัสผ่านอีกครั้ง");
            admin_repass.css({"border-color": "red"});
            admin_repass.css({"background-color": "lavenderblush"});
            check_pass = false;
        }
    }
//////////////////////////////////////////////////////////////////////////////////    
});

