<?php
error_reporting(0);
require("../config.php");
$codeID = $_GET['codeID'];
$codeVal = $_GET['codeVal'];
$username = $_GET['username'];
if ($codeID == null && $codeVal == null) {
    echo "Brak kuponu do przywrócenia";
    exit(0);
}

if ($codeID != null) {
    $query = "UPDATE TOP(1) CouponsDev SET isCouponUsed=0 OUTPUT inserted.coupon WHERE isCouponUsed=1 AND couponID=?";
    $stmt = $con->prepare($query);
    $stmt->execute(array($codeID));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = $row;
    }
    $kod = $rows[0]["coupon"];
    $url = 'https://api.telegram.org/' . $botKey . '/sendMessage';
    if ($kod != null) {
        $data = array('chat_id' => $logChannelID, 'text' => "Przywrócono kod `$kod` do bazy", 'parse_mode' => 'MarkdownV2');
        echo "Przywrócono kod $kod do bazy";
    } else {
        $data = array('chat_id' => $logChannelID, 'text' => "Przywracanie kuponu nie pykło", 'parse_mode' => 'MarkdownV2');
        http_response_code(406);
        echo "Przywracanie kodu nie pykło";
    }
} else {  //Code returned by user
    $query = "UPDATE TOP(1) CouponsDev SET isCouponUsed=0 OUTPUT inserted.coupon WHERE isCouponUsed=1 AND coupon='$codeVal'";
    $stmt = $con->prepare($query);
    $stmt->execute(array($codeVal));
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = $row;
    }
    $kod = $rows[0]["coupon"];
    $url = 'https://api.telegram.org/' . $botKey . '/sendMessage';
    if ($kod != null) {
        $data = array('chat_id' => $logChannelID, 'text' => "Użytkownik `$username` przywrócił kod `$kod` do bazy\nAdres IP użytkownika: `" . $_SERVER['REMOTE_ADDR']."`", 'parse_mode' => 'MarkdownV2');
        echo "Przywrócono kod $kod do bazy";
    } else {
        $data = array('chat_id' => $logChannelID, 'text' => "Przywracanie kuponu `$codeVal` przez użytkownika `$username` nie pykło\nAdres IP użytkownika: `" . $_SERVER['REMOTE_ADDR']."`", 'parse_mode' => 'MarkdownV2');
        http_response_code(406);
        echo "Przywracanie kodu nie pykło";
    }
}


$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */
}
