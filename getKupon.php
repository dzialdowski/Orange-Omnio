<?php
$kupon = $_GET['kuponType'];
$username = $_GET['username'];
if ($username == null || $username == "null") {
    echo '{"success":[{"coupon":"Błędny login","0":"Błędny login"}]}';
    exit(0);
}
require("config.php");
$query = "UPDATE TOP(1) CouponsDev SET isCouponUsed=1 OUTPUT inserted.coupon, inserted.couponID WHERE isCouponUsed=0 AND couponType=?"; //sqlsrv only
$stmt = $con->prepare($query);

if ($stmt->execute(array($kupon))) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = $row;
    }
    $kod = $rows[0]["coupon"];
    $kuponID = $rows[0]['couponID'];
    echo json_encode(array("success" => $rows));
    $url= $endpoint."returnToDatabase.php?codeID=".$kuponID;
    $keyboard = json_encode([
        "inline_keyboard" => [
            [
                [
                    "text" => "Zwróć do bazy",
                    "url" => $url
                ]
            ]
        ]
    ]);
}


$url = 'https://api.telegram.org/' . $botKey . '/sendMessage';
if ($kod != null) $data = array('chat_id' => $logChannelID, 'text' => "Użytkownik `$username` właśnie pobrał kod \n`$kod`\nAdres IP użytkownika: `" . $_SERVER['REMOTE_ADDR'] . "`", 'parse_mode' => 'MarkdownV2', 'reply_markup' => $keyboard);
else $data = array('chat_id' => $logChannelID, 'text' => "Użytkownik `$username` właśnie próbował pobrać kod `$kupon`, ale się nie udało, ponieważ zabrakło kuponów w momencie wysłania zapytania\nAdres IP użytkownika: `" . $_SERVER['REMOTE_ADDR'] . "`", 'parse_mode' => 'MarkdownV2');

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) {
}
