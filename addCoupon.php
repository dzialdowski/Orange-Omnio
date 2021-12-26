<?php
//error_reporting(0);
require("config.php");
$codeType = $_GET['codeType'];
$codeValues = json_decode(urldecode($_GET['codeValue']), true);


if ($codeType == null || $codeValues == null) {
    echo "Brak kuponu do dodania";
    exit(0);
}



$query = "INSERT INTO CouponsDev(couponType, coupon, isCouponUsed) VALUES (?,?,0);";

$stmt = $con->prepare($query);
try {
    $con->beginTransaction();
    foreach ($codeValues as $row) {
        if ($stmt->execute(array($codeType, $row))) {
            echo "Udana próba dodania kodu $row - typ $codeType do bazy<br>";
        } else {
            echo "Nieudana próba dodania kodu $row - typ $codeType do bazy<br>";
        }
    }
    if ($con->commit()) {
        echo "Dodano wymienione wyżej kody<br>";
        /////////////////////////////////////////   Telegram bot - log
        $url = 'https://api.telegram.org/' . $botKey . '/sendMessage';
        $data = array('chat_id' => $logChannelID, 'text' => "Dodano " . count($codeValues) . " kuponów " . $codeType, 'parse_mode' => 'MarkdownV2');
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        /////////////////////////////////////////
    } else {
        echo "Błąd przy dodawaniu kodów";
    }
} catch (Exception $e) {
    $con->rollback();
    print_r($e);
}
