<!--


SET GLOBAL event_scheduler = ON;
ALTER EVENT CancelSale ENABLE;
CREATE EVENT CancelSale
    ON SCHEDULE
        EVERY 30 SECOND
        DO
UPDATE sale SET sale_status = 'cancel'
WHERE DATE_SUB(NOW(), INTERVAL 3 DAY) >= sale_date AND sale_status = 'wait for payment'




-->
<?php
$connect = mysqli_connect('localhost', 'root', '', 'cdsportshop');
mysqli_set_charset($connect, 'utf8');

$sql = "UPDATE sale SET sale_status = 'cancel'
WHERE DATE_SUB(NOW(), INTERVAL 3 DAY)>=sale_date AND sale_status = 'wait for payment'";
$result = mysqli_query($connect, $sql);
?>
