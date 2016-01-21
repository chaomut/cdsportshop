<?php
error_reporting(E_ALL^E_WARNING);
require '../cancel_sale.php';
if (isset($_GET['save'])) {
    $save = $_GET['save'];
    if ($save == "sale") {
        session_start();
        $message = "<h4 class='text-center text-danger'><u>กรุณาชำระเงินภายใน 3 วันหลังจากวันที่สั่งซื้อ เพราะระบบจะทำการยกเลิกอัตโนมัติ</u></h4><br>";
        $wait = "<script>
        setTimeout(function() {
            window.location.href = 'payment_page.php';
        }, 3000);
        </script>";
        unset($_SESSION['product']);
    } elseif ($save == "payment") {
        $message = "<h4 class='text-center text-success'><u>การชำระเงินเสร็จสมบูรณ์</u></h4><br>";
        $wait = "<script>
        setTimeout(function() {
            window.location.href = 'history_page.php';
        }, 3000);
        </script>";
    }
} else {

    header("Refresh:0;url=./index.php");
    exit();
}
?>
<html>
    <head>
        <title> HOME </title>
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width=device-width">
        <link href = "css/bootstrap.min.css" rel = "stylesheet" type = "text/css">
        <script src = "js/jquery-1.11.3.min.js" type = "text/javascript"></script>
    <body>
        <br>
        <br>
        <br>
        <div class='container'>
            <div class="col-sm-3"></div>
            <div class="col-sm-8">
                <?php
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                         aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                        Please Wait...
                    </div>
                </div>
            </div>
        </div>
    </body>
    <?php echo $wait ?>
</html>