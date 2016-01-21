$(document).ready(function () {
    //Select Payment
    $.post("../php/check-payment_detail.php?operation=select", {}, function (data) {
        $("#show-payment").html(data.html1);
        $("#select-payment-id").html(data.html2);
    }, "json");
    
    //Update Payment Status
    $("#save-changes-payment").click(function () {
        var payment_id = $("#payment_id");
        var payment_status = $("#payment_status");
        var admin_id = $("#admin_id");
        
        
        if (payment_id.val() !== '' && payment_status.val() !== '')
        {
            $.post("../php/check-payment_detail.php?operation=update", {
                "payment_id": payment_id.val(),
                "payment_status": payment_status.val(),
                "admin_id": admin_id.val()
            }, function (data) {
                location.reload();
            }, "json");
            
        }
        else
            alert("กรุณากรอกข้อมูลให้ครบถ้วน");
    });
});
