$(document).ready(function () {
    $.post("../php/purchase_list.php?operation=select", {}, function (data) {
        $("#show-purchase").html(data.html1);
    }, "json");
    
});


