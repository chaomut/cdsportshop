var check = false;
$(document).ready(function() {
    //Select Product
    showProduct();
    //Select All Products
    function showProduct() {
        if (check === false) {
            $.post("../php/purchase_alert.php?operation=select_reorderpoint", {}, function(data) {
                $("#show-product").html(data.html1);
            }, "json");
        }
        else {
            $.post("../php/purchase_alert.php?operation=select_all", {}, function(data) {
                $("#show-product").html(data.html1);
            }, "json");
        }
    }
    $("#select-all-product").click(function() {
        check = true;
        showProduct();
    });
    $("#select-out-product").click(function() {
        check = false;
        showProduct();
    });

    //Save Purchase    
    $("#save-purchase").click(function() {
        var sup_id = $("#sup_id");
        var test = document.getElementById("sup_id")
        var totalPurshasePrice = $("#totalPurshasePrice");
        var con = confirm("ยืนยันการสั่งซื้อสินค้า");
        if (con === true) {
            if (sup_id.val() !== '' && parseInt(totalPurshasePrice.val()) < 10000000000 )
            {
                $.post("../php/save_PurchaseDetail.php", {
                    "sup_id": sup_id.val()
                }, function(data) {
                    location.reload();
                }, "json");

            }
            else {
                alert("กรุณากรอกข้อมูลให้ถูกต้องและครบถ้วน");
            }
        }
    });
/////////////////////////////////////////////////////////////////////////////////

});