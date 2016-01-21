
var check_name = true;
var check_tel = true;
var check_email = true;
var check_pass = true;

var check_tel_edit = true;
var check_name_edit = true;
var check_email_edit = true;

$(document).ready(function () {

    //Select Admin
    $.post("../php/admin_mng.php?operation=select", {}, function (data) {
        $("#show-admin").html(data.html1);
    }, "json");
    //Insert Admin
    $("#add-admin").click(function () {
        var admin_fname = $("#admin_fname");
        var admin_lname = $("#admin_lname");
        var admin_tel = $("#admin_tel");
        var admin_email = $("#admin_email");
        var admin_pass = $("#admin_pass");
        if (admin_fname.val() !== '' && admin_lname.val() !== ''
                && admin_tel.val() !== '' && admin_email.val() !== '' && admin_pass.val() !== '')
        {
            if (check_name === true && check_tel === true && check_email === true && check_pass === true) {
                $.post("../php/admin_mng.php?operation=insert", {
                    "admin_fname": admin_fname.val(),
                    "admin_lname": admin_lname.val(),
                    "admin_tel": admin_tel.val(),
                    "admin_email": admin_email.val(),
                    "admin_pass": admin_pass.val()

                }, function (data) {
                    location.reload();
                }, "json");
            }
            else
                alert("กรุณากรอกข้อมูลให้ครบถ้วน");
        } else
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
    });
    $("#edit-admin").click(function () {
        var admin_id = $("#admin_id_edit");
        var admin_fname = $("#admin_fname_edit");
        var admin_lname = $("#admin_lname_edit");
        var admin_tel = $("#admin_tel_edit");
        var admin_email = $("#admin_email_edit");
        if (admin_fname.val() !== '' && admin_lname.val() !== ''
                && admin_tel.val() !== '' && admin_email.val() !== '')
        {
            if (check_name_edit === true && check_tel_edit === true) {
                $.post("../php/admin_mng.php?operation=update", {
                    "admin_id": admin_id.val(),
                    "admin_fname": admin_fname.val(),
                    "admin_lname": admin_lname.val(),
                    "admin_tel": admin_tel.val(),
                    "admin_email": admin_email.val()

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
    
//////////////////////////////////////////////////////////////////////////////////
/////////////////////////////VALIDATE/////////////////////////////////////////////
    //Fname Add
    $("#admin_fname").keypress(function () {
        var errorAdmin = $("#errorAdminFname1");
        checkAdminName(errorAdmin);
    });
    $("#admin_fname").blur(function () {
        var errorAdmin = $("#errorAdminFname1");
        var admin_fname = $("#admin_fname");
        checkAdminNameComplete(errorAdmin, admin_fname);
    });
    
    //Fname Edit
    $("#admin_fname_edit").keypress(function () {
        var errorAdmin = $("#errorAdminFname2");
        checkAdminNameEdit(errorAdmin);
    });
    $("#admin_fname_edit").blur(function () {
        var errorAdmin = $("#errorAdminFname2");
        var admin_fname = $("#admin_fname_edit");
        checkAdminNameEditComplete(errorAdmin, admin_fname);
    });
    
    //Lname Add
    $("#admin_lname").keypress(function () {
        var errorAdmin = $("#errorAdminLname1");
        checkAdminName(errorAdmin);
    });
    $("#admin_lname").blur(function () {
        var errorAdmin = $("#errorAdminLname1");
        var admin_lname = $("#admin_lname");
        checkAdminNameComplete(errorAdmin, admin_lname);
    });
    
    //Lname Edit
    $("#admin_lname_edit").keypress(function () {
        var errorAdmin = $("#errorAdminLname2");
        checkAdminNameEdit(errorAdmin);
    });
    $("#admin_lname_edit").blur(function () {
        var errorAdmin = $("#errorAdminLname2");
        var admin_lname = $("#admin_lname_edit");
        checkAdminNameEditComplete(errorAdmin, admin_lname);
    });
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//Check Admin Tel

    //Tel Add
    $("#admin_tel").keypress(function () {
        var errorAdmin = $("#errorAdminTel1");
        checkAdminTel(errorAdmin);
    });
    $("#admin_tel").blur(function () {
        var errorAdmin = $("#errorAdminTel1");
        var admin_tel = $("#admin_tel");
        checkAdminTelComplete(errorAdmin, admin_tel);
    });
    
    //Tel Edit
    $("#admin_tel_edit").keypress(function () {
        var errorAdmin = $("#errorAdminTel2");
        checkAdminTelEdit(errorAdmin);
    });
    $("#admin_tel_edit").blur(function () {
        var errorAdmin = $("#errorAdminTel2");
        var admin_tel = $("#admin_tel_edit");
        checkAdminTelCompleteEdit(errorAdmin, admin_tel);
    });
////////////////////////////////////////////////////////////////////////////////
    //Admin Email
    $("#admin_email").blur(function () {
        var errorAdmin = $("#errorAdminEmail1");
        var admin_email = $("#admin_email");
        checkEmailFormat(errorAdmin, admin_email);
    });
    
////////////////////////////////////////////////////////////////////////////////
    //Admin Pass
    $("#admin_pass").keypress(function () {
        var errorAdmin = $("#errorAdminPass");
        checkAdminPass(errorAdmin);
    });
    $("#admin_pass").blur(function () {
        var errorAdmin = $("#errorAdminPass");
        var admin_pass = $("#admin_pass");
        checkAdminPassComplete(errorAdmin, admin_pass);
    });
    $("#admin_repass").keypress(function () {
        var errorAdmin = $("#errorAdminRePass");
        checkAdminPass(errorAdmin);
    });
    $("#admin_repass").blur(function () {
        var errorAdmin = $("#errorAdminRePass");
        var admin_pass = $("#admin_pass");
        var admin_repass = $("#admin_repass");
        checkAdminRePassComplete(errorAdmin, admin_pass, admin_repass);
    });   
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Check Name Add
    function checkAdminName(errorAdmin) {

        if ((event.which < 45 ||(event.which > 45 && event.which < 65) || (event.which > 90 && event.which < 97) 
             || (event.which > 122 && event.which < 256))) {
            event.preventDefault();
            errorAdmin.css({"color": "red"});
            errorAdmin.text("*กรุณากรอกเป็นตัวอักษร");
            check_name = false;
        }
        else {
            errorAdmin.text("");
            check_name = true;
        }
    }

    function checkAdminNameComplete(errorAdmin, admin_name) {
        if (admin_name.val() === "") {
            errorAdmin.css({"color": "red"});
            errorAdmin.text("*กรุณากรอกข้อมูล");
            admin_name.css({"border-color": "red"});
            admin_name.css({"background-color": "lavenderblush"});
            check_name = false;
        }
        else {
            errorAdmin.text("");
            admin_name.css({"border-color": "green"});
            admin_name.css({"background-color": "#d6e9c6"});
            check_name = true;
        }
    }
    
    //Check Name Edit
    function checkAdminNameEdit(errorAdmin) {

        if ((event.which < 45 ||(event.which > 45 && event.which < 65) || (event.which > 90 && event.which < 97) 
                || (event.which > 122 && event.which < 256))) {
            event.preventDefault();
            errorAdmin.css({"color": "red"});
            errorAdmin.text("*กรุณากรอกเป็นตัวอักษร");
            check_name_edit = false;
        }
        else {
            errorAdmin.text("");
            check_name_edit = true;
        }
    }

    function checkAdminNameEditComplete(errorAdmin, admin_name) {
        if (admin_name.val() === "") {
            errorAdmin.css({"color": "red"});
            errorAdmin.text("*กรุณากรอกข้อมูล");
            admin_name.css({"border-color": "red"});
            admin_name.css({"background-color": "lavenderblush"});
            check_name_edit = false;
        }
        else {
            errorAdmin.text("");
            admin_name.css({"border-color": "green"});
            admin_name.css({"background-color": "#d6e9c6"});
            check_name_edit = true;
        }
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Check Tel Add
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
    
    //Check Tel Edit
    function checkAdminTelEdit(errorAdmin) {

        if (event.which < 48 || event.which > 57) {
            event.preventDefault();
            errorAdmin.css({"color": "red"});
            errorAdmin.text("*กรุณากรอกเป็นตัวเลข");
            check_tel_edit = false;
        }
        else {
            errorAdmin.text("");
            check_tel_edit = true;
        }
    }


    function checkAdminTelCompleteEdit(errorAdmin, admin_tel) {
        if (admin_tel.val().length < 9) {
            errorAdmin.css({"color": "red"});
            errorAdmin.text("*กรุณากรอกข้อมูลอย่างน้อย 9 หลัก");
            admin_tel.css({"border-color": "red"});
            admin_tel.css({"background-color": "lavenderblush"});
            check_tel_edit = false;
        } else {
            errorAdmin.text("");
            admin_tel.css({"border-color": "green"});
            admin_tel.css({"background-color": "#d6e9c6"});
            check_tel_edit = true;
        }
    }

//////////////////////////////////////////////////////////////////////////////////////////

    //Check Email
    function checkEmailFormat(errorAdmin, admin_email) {
        var regex = /^([0-9a-zA-Z]([-_.]*[0-9a-zA-Z]+)*)@([0-9a-zA-Z]([-_.]*[0-9a-zA-Z]+)*)[.]([a-zA-Z]{2,9})$/;
        if (regex.test(admin_email.val())) {
            $.post("../php/check_duplicateEmail.php?operation=admin", {
                "admin_email": admin_email.val()
            }, function (data) {
                if (data.status === true) {
                    errorAdmin.text("");
                    admin_email.css({"border-color": "green"});
                    admin_email.css({"background-color": "#d6e9c6"});
                    check_email = true;
                }
                else {
                    errorAdmin.css({"color": "red"});
                    errorAdmin.text("*Email นี้ไม่สามารถใช้ได้");
                    admin_email.css({"border-color": "red"});
                    admin_email.css({"background-color": "lavenderblush"});
                    check_email = false;
                }
            }, "json");
        }
        else {
            errorAdmin.css({"color": "red"});
            errorAdmin.text("*Email ไม่ถูกต้อง");
            admin_email.css({"border-color": "red"});
            admin_email.css({"background-color": "lavenderblush"});
            check_email = false;
        }
    }
/////////////////////////////////////////////////////////////////////////////////
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
////////////////////////////////////////////////////////////////////////////////    
});

