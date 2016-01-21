var check_invoice = true;

$(document).ready(function() {

    //Select Receive
    $.post("../php/receive_detail.php?operation=select", {}, function(data) {
        $("#show-receive").html(data.html1);
        $("#select-pur").html(data.html2);
    }, "json");

    //Update Receive
    $("#save-changes-receive").click(function() {
        var pur_id = $("#pur_id");
        var invoiceNo = $("#invoiceNo");
        var admin_id = $("#admin_id");

        if (pur_id.val() !== '' && invoiceNo.val() !== '')
        {
            $.post("../php/receive_detail.php?operation=update", {
                "pur_id": pur_id.val(),
                "invoiceNo": invoiceNo.val(),
                "admin_id": admin_id.val()
            }, function(data) {
                location.reload();
            }, "json");

        }
        else
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
    });
//////////////////////////////////VALIDATE///////////////////////////////////////
    $("#invoiceNo").keypress(function() {
        var errorInvoice = $("#errorInvoice");
        checkInvoice(errorInvoice);
    });
    $("#invoiceNo").blur(function() {
        var errorInvoice = $("#errorInvoice");
        var invoiceNo = $("#invoiceNo");
        checkInvoiceComplete(errorInvoice, invoiceNo);
    });
/////////////////////////////////////////////////////////////////////////////////

    function checkInvoice(errorInvoice) {
        if (event.which > 47 && event.which < 58) {
            errorInvoice.text("");
            check_invoice = true;
        }
        else {
            event.preventDefault();
            errorInvoice.css({"color": "red"});
            errorInvoice.text("*กรุณากรอกเป็นตัวเลข");
            check_invoice = false;
        }
    }

    function checkInvoiceComplete(errorInvoice, invoiceNo) {
        if (invoiceNo.val() === "") {
            errorInvoice.css({"color": "red"});
            errorInvoice.text("*กรุณากรอกข้อมูล");
            invoiceNo.css({"border-color": "red"});
            invoiceNo.css({"background-color": "lavenderblush"});
            check_invoice = false;
        }
        else {
            errorInvoice.text("");
            invoiceNo.css({"border-color": "green"});
            invoiceNo.css({"background-color": "#d6e9c6"});
            check_invoice = true;
        }
    }
////////////////////////////////////////////////////////////////////////////////    
});