var check_name = true;
var check_address = true;
var check_email = true;
var check_tel = true;

var check_name_edit = true;
var check_address_edit = true;
var check_email_edit = true;
var check_tel_edit = true;

$(document).ready(function() {
    //Select Supplier
    $.post("../php/supplier_mng.php?operation=select", {}, function(data) {
        $("#show-supplier").html(data.html1);
    }, "json");

    //Insert Supplier
    $("#add-supplier").click(function() {
        var sup_name = $("#sup_name");
        var sup_address = $("#sup_address");
        var sup_email = $("#sup_email");
        var sup_tel = $("#sup_tel");
        var sup_status = $("#sup_status");
        if (sup_name.val() !== '' && sup_address.val() !== '' && sup_email.val() !== ''
                && sup_tel.val() !== '' && sup_status.val() !== '')
        {
            if (check_name === true && check_address === true && check_tel === true
                    && check_email === true) {
                $.post("../php/supplier_mng.php?operation=insert", {
                    "sup_name": sup_name.val(),
                    "sup_address": sup_address.val(),
                    "sup_email": sup_email.val(),
                    "sup_tel": sup_tel.val(),
                    "sup_status": sup_status.val()
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

    //Update Supplier
    $("#edit-supplier").click(function() {
        var sup_id = $("#sup_id_edit");
        var sup_name = $("#sup_name_edit");
        var sup_address = $("#sup_address_edit");
        var sup_email = $("#sup_email_edit");
        var sup_tel = $("#sup_tel_edit");
        var sup_status = $("#sup_status_edit");
        if (sup_id.val() !== '' && sup_name.val() !== '' && sup_address.val() !== '' && sup_email.val() !== ''
                && sup_tel.val() !== '' && sup_status.val() !== '')
        {
            if (check_name_edit === true && check_address_edit === true && check_tel_edit === true
                    && check_email_edit === true) {
                $.post("../php/supplier_mng.php?operation=update", {
                    "sup_id": sup_id.val(),
                    "sup_name": sup_name.val(),
                    "sup_address": sup_address.val(),
                    "sup_email": sup_email.val(),
                    "sup_tel": sup_tel.val(),
                    "sup_status": sup_status.val()
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
/////////////////////////VALIDATE///////////////////////////////////////////////
//SupName Add
    $("#sup_name").blur(function() {
        var errorSup = $("#errorSupName1");
        var sup_name = $("#sup_name");
        checkSupNameComplete(errorSup, sup_name);
    });
    //SupName Edit

    $("#sup_name_edit").blur(function() {
        var errorSup = $("#errorSupName2");
        var sup_id = $("#sup_id_edit")
        var sup_name = $("#sup_name_edit");
        checkSupNameEditComplete(errorSup, sup_id, sup_name);
    });
////////////////////////////////////////////////////////////////////////////////
//Sup Address
    $("#sup_address").blur(function() {
        var errorSup = $("#errorSupAddress1");
        var sup_address = $("#sup_address");
        checkSupAddressComplete(errorSup, sup_address);
    });

    $("#sup_address_edit").blur(function() {
        var errorSup = $("#errorSupAddress2");
        var sup_address = $("#sup_address_edit");
        checkSupAddressEditComplete(errorSup, sup_address);
    });

////////////////////////////////////////////////////////////////////////////////
//Check Sup Tel
    //Tel Add
    $("#sup_tel").keypress(function() {
        var errorSup = $("#errorSupTel1");
        checkSupTel(errorSup);
    });
    $("#sup_tel").blur(function() {
        var errorSup = $("#errorSupTel1");
        var sup_tel = $("#sup_tel");
        checkSupTelComplete(errorSup, sup_tel);
    });

    //Tel Edit
    $("#sup_tel_edit").keypress(function() {
        var errorSup = $("#errorSupTel2");
        checkSupTelEdit(errorSup);
    });
    $("#sup_tel_edit").blur(function() {
        var errorSup = $("#errorSupTel2");
        var sup_tel = $("#sup_tel_edit");
        checkSupTelEditComplete(errorSup, sup_tel);
    });
///////////////////////////////////////////////////////////////////////////////
    //Admin Email

    $("#sup_email").blur(function() {
        var errorSup = $("#errorSupEmail1");
        var sup_email = $("#sup_email");
        checkEmailFormat(errorSup, sup_email);
    });

    $("#sup_email_edit").blur(function() {
        var errorSup = $("#errorSupEmail2");
        var sup_id = $("#sup_id_edit");
        var sup_email = $("#sup_email_edit");
        checkEmailEditFormat(errorSup, sup_id, sup_email);
    });
    
/////////////////////////////////////////////////////////////////////////////////

    function checkSupNameComplete(errorSup, sup_name) {
        if (sup_name.val() === "") {
            errorSup.css({"color": "red"});
            errorSup.text("*กรุณากรอกข้อมูล");
            sup_name.css({"border-color": "red"});
            sup_name.css({"background-color": "lavenderblush"});
            check_name = false;
        }
        else {
            $.post("../php/check_duplicateData.php?operation=supplier", {
                "sup_name": sup_name.val()
            }, function(data) {
                if (data.status === true) {
                    errorSup.text("");
                    sup_name.css({"border-color": "green"});
                    sup_name.css({"background-color": "#d6e9c6"});
                    check_name = true;
                }
                else {
                    errorSup.css({"color": "red"});
                    errorSup.text("*ชื่อนี้ไม่สามารถใช้ได้");
                    sup_name.css({"border-color": "red"});
                    sup_name.css({"background-color": "lavenderblush"});
                    check_name = false;
                }
            }, "json");
        }
    }

    function checkSupNameEditComplete(errorSup, sup_id, sup_name) {
        if (sup_name.val() === "") {
            errorSup.css({"color": "red"});
            errorSup.text("*กรุณากรอกข้อมูล");
            sup_name.css({"border-color": "red"});
            sup_name.css({"background-color": "lavenderblush"});
            check_name_edit = false;
        }
        else {
            $.post("../php/check_duplicateData.php?operation=supplier_edit", {
                "sup_id": sup_id.val(),
                "sup_name": sup_name.val()
            }, function(data) {
                if (data.status === true) {
                    errorSup.text("");
                    sup_name.css({"border-color": "green"});
                    sup_name.css({"background-color": "#d6e9c6"});
                    check_name_edit = true;
                }
                else {
                    errorSup.css({"color": "red"});
                    errorSup.text("*ชื่อนี้ไม่สามารถใช้ได้");
                    sup_name.css({"border-color": "red"});
                    sup_name.css({"background-color": "lavenderblush"});
                    check_name_edit = false;
                }
            }, "json");
        }
    }

    function checkSupAddressComplete(errorSup, sup_address) {
        if (sup_address.val() === "") {
            errorSup.css({"color": "red"});
            errorSup.text("*กรุณากรอกข้อมูล");
            sup_address.css({"border-color": "red"});
            sup_address.css({"background-color": "lavenderblush"});
            check_address = false;
        }
        else {
            errorSup.text("");
            sup_address.css({"border-color": "green"});
            sup_address.css({"background-color": "#d6e9c6"});
            check_address = true;
        }
    }

    function checkSupAddressEditComplete(errorSup, sup_address) {
        if (sup_address.val() === "") {
            errorSup.css({"color": "red"});
            errorSup.text("*กรุณากรอกข้อมูล");
            sup_address.css({"border-color": "red"});
            sup_address.css({"background-color": "lavenderblush"});
            check_address_edit = false;
        }
        else {
            errorSup.text("");
            sup_address.css({"border-color": "green"});
            sup_address.css({"background-color": "#d6e9c6"});
            check_address_edit = true;
        }
    }

    function checkSupTel(errorSup) {

        if (event.which < 48 || event.which > 57) {
            event.preventDefault();
            errorSup.css({"color": "red"});
            errorSup.text("*กรุณากรอกเป็นตัวเลข");
            check_tel = false;
        }
        else {
            errorSup.text("");
            check_tel = true;
        }
    }


    function checkSupTelComplete(errorSup, sup_tel) {
        if (sup_tel.val().length < 9) {
            errorSup.css({"color": "red"});
            errorSup.text("*กรุณากรอกข้อมูลอย่างน้อย 9 หลัก");
            sup_tel.css({"border-color": "red"});
            sup_tel.css({"background-color": "lavenderblush"});
            check_tel = false;
        } else {
            errorSup.text("");
            sup_tel.css({"border-color": "green"});
            sup_tel.css({"background-color": "#d6e9c6"});
            check_tel = true;
        }
    }

    //Check Tel Edit
    function checkSupTelEdit(errorSup) {

        if (event.which < 48 || event.which > 57) {
            event.preventDefault();
            errorSup.css({"color": "red"});
            errorSup.text("*กรุณากรอกเป็นตัวเลข");
            check_tel_edit = false;
        }
        else {
            errorSup.text("");
            check_tel_edit = true;
        }
    }


    function checkSupTelEditComplete(errorSup, sup_tel) {
        if (sup_tel.val().length < 9) {
            errorSup.css({"color": "red"});
            errorSup.text("*กรุณากรอกข้อมูลอย่างน้อย 9 หลัก");
            sup_tel.css({"border-color": "red"});
            sup_tel.css({"background-color": "lavenderblush"});
            check_tel_edit = false;
        } else {
            errorSup.text("");
            sup_tel.css({"border-color": "green"});
            sup_tel.css({"background-color": "#d6e9c6"});
            check_tel_edit = true;
        }
    }

    //Check Email
    function checkEmailFormat(errorSup, sup_email) {
        var regex = /^([0-9a-zA-Z]([-_.]*[0-9a-zA-Z]+)*)@([0-9a-zA-Z]([-_.]*[0-9a-zA-Z]+)*)[.]([a-zA-Z]{2,9})$/;
        if (regex.test(sup_email.val())) {
            $.post("../php/check_duplicateEmail.php?operation=supplier", {
                "sup_email": sup_email.val()
            }, function(data) {
                if (data.status === true) {
                    errorSup.text("");
                    sup_email.css({"border-color": "green"});
                    sup_email.css({"background-color": "#d6e9c6"});
                    check_email = true;
                }
                else {
                    errorSup.css({"color": "red"});
                    errorSup.text("*Email นี้ไม่สามารถใช้ได้");
                    sup_email.css({"border-color": "red"});
                    sup_email.css({"background-color": "lavenderblush"});
                    check_email = false;
                }
            }, "json");
        }
        else {
            errorSup.css({"color": "red"});
            errorSup.text("*Email ไม่ถูกต้อง");
            sup_email.css({"border-color": "red"});
            sup_email.css({"background-color": "lavenderblush"});
            check_email = false;
        }
    }

    function checkEmailEditFormat(errorSup, sup_id, sup_email) {
        var regex = /^([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)@([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)[\\.]([a-zA-Z]{2,9})$/;
        if (regex.test(sup_email.val())) {
            $.post("../php/check_duplicateEmail.php?operation=supplier_edit", {
                "sup_id": sup_id.val(),
                "sup_email": sup_email.val()
            }, function(data) {
                if (data.status === true) {
                    errorSup.text("");
                    sup_email.css({"border-color": "green"});
                    sup_email.css({"background-color": "#d6e9c6"});
                    check_email_edit = true;
                }
                else {
                    errorSup.css({"color": "red"});
                    errorSup.text("*Email นี้ไม่สามารถใช้ได้");
                    sup_email.css({"border-color": "red"});
                    sup_email.css({"background-color": "lavenderblush"});
                    check_email_edit = false;
                }
            }, "json");
        }
        else {
            errorSup.css({"color": "red"});
            errorSup.text("*Email ไม่ถูกต้อง");
            sup_email.css({"border-color": "red"});
            sup_email.css({"background-color": "lavenderblush"});
            check_email_edit = false;
        }
    }
/////////////////////////////////////////////////////////////////////////////////
});