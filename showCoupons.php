<?php
error_reporting(0);
require("config.php");
$codeType = $_GET['codeType'];
$showAlsoUsed = $_GET['showAlsoUsed'];
$query = "";

if ($showAlsoUsed == "true") {
    if ($codeType == "ALL") {
        $query = "SELECT * FROM CouponsDev";
    } else {
        $query = "SELECT * FROM CouponsDev WHERE couponType=?";
    }
} else {
    if ($codeType == "ALL") {
        $query = "SELECT * FROM CouponsDev WHERE isCouponUsed=0";
    } else {
        $query = "SELECT * FROM CouponsDev WHERE isCouponUsed=0 AND couponType=?";
    }
}


$stmt = $con->prepare($query);
if ($stmt->execute(array($codeType))) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = $row;
    }
    echo json_encode(array("success" => $rows));
}
