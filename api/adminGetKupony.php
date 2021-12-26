<?php 
error_reporting(0);
require("../config.php");
$query="SELECT * FROM Coupons";
$result=$con->query($query);
while ($row = $result->fetch(PDO::FETCH_BOTH)) {
    $rows[]=$row;
}
echo json_encode(array("success"=>$rows));


