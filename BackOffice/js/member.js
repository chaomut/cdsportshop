$(document).ready(function() {
//////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Select Brand
    $.post("../php/member_mng.php?operation=select", {}, function(data) {
        $("#show-member").html(data.html1);
    }, "json");
});

