$(document).ready(function () {
    $.post("../php/sale_detail.php?operation=select", {}, function (data) {
        $("#show-sale").html(data.html1);
    }, "json");
});