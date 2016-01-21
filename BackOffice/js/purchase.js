$(document).ready(function () {
    $.post("../php/purchase_detail.php?operation=select", {}, function (data) {
        $("#show-purchase").html(data.html1);
    }, "json");
    
});


