var check_name = true;
var check_tel = true;
var check_pass = true;

$(document).ready(function() {
    //Show Admin Profile
    $("#edit-profile").click(function() {
        $('#admin_fname').removeAttr('readonly');
        $('#admin_lname').removeAttr('readonly');
        $('#admin_tel').removeAttr('readonly');
    });

    $("#update-profile").click(function() {
        var admin_id = $("#admin_id");
        var admin_tel = $("#admin_tel");
        var admin_fname = $("#admin_fname");
        var admin_lname = $("#admin_lname");
        var admin_pass = $("#admin_pass");
        
        if (admin_tel.val() !== '' && admin_fname.val() !== '' && admin_lname.val() !== '' && admin_pass.val() !== '')
        {
            if (check_name === true && check_tel === true && check_pass === true) {
                $.post("../php/admin_profile.php?operation=update", {
                    "admin_id": admin_id.val(),
                    "admin_tel": admin_tel.val(),
                    "admin_fname": admin_fname.val(),
                    "admin_lname": admin_lname.val(),
                    "admin_pass": admin_pass.val()
                }, function(data) {
                    if (data.status === true) {
                        location.reload();
                    } else {
                        alert("Password Incorrect");
                    }

                }, "json");
            }
            else
                alert("กรุณากรอกข้อมูลให้ถูกต้อง");
        }
        else
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
    });
////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////VALIDATE/////////////////////////////////////
    //Admin Fname
    $("#admin_fname").keypress(function() {
        var errorAdmin = $("#errorAdminFname1");
        checkAdminName(errorAdmin);
    });
    $("#admin_fname").blur(function() {
        var errorAdmin = $("#errorAdminFname1");
        var admin_fname = $("#admin_fname");
        checkAdminNameComplete(errorAdmin, admin_fname);
    });

    //Admin Lname 
    $("#admin_lname").keypress(function() {
        var errorAdmin = $("#errorAdminLname1");
        checkAdminName(errorAdmin);
    });
    $("#admin_lname").blur(function() {
        var errorAdmin = $("#errorAdminLname1");
        var admin_lname = $("#admin_lname");
        checkAdminNameComplete(errorAdmin, admin_lname);
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
/////////////////////////////////////////////////////////////////////////////////////////////////    
//
//Check AdminName
    function checkAdminName(errorAdmin) {
        if ((event.which < 45 || (event.which > 45 && event.which < 65) || (event.which > 90 && event.which < 97)
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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Check AdminTel
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
/////////////////////////////////////////////////////////////////////////////////
});

