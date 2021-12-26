<?php
error_reporting(0);
require("../config.php");
$query = "SELECT CouponTypeDev.CouponType AS Kupon, COUNT(CouponsDev.coupon) AS Ilosc FROM CouponTypeDev LEFT JOIN CouponsDev ON CouponsDev.couponType = CouponTypeDev.CouponType WHERE CouponsDev.isCouponUsed=0 GROUP BY CouponTypeDev.CouponType";
$result = $con->query($query);
while ($row = $result->fetch(PDO::FETCH_BOTH)) {
    $rows[] = $row;
}
echo json_encode(array("success" => $rows));
