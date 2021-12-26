<?php


if ($_GET['type'] == "street") {
    $ch = curl_init("https://www.orange.pl/hapi/cbs/streetauto");
    $payload = '{"filter":{"city_id":' . $_GET['city_id'] . '},"html":"' . $_GET['street'] . '"}';
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $tost = curl_exec($ch);
    curl_close($ch);
}

if ($_GET['type'] == "city") {
    $ch = curl_init("https://www.orange.pl/hapi/cbs/cityauto");
    $payload = '{"filter":"","html":"' . $_GET['city'] . '"}';
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    $tost = curl_exec($ch);
    curl_close($ch);
}

if ($_GET['type'] == "zipCode") {
    $ch = curl_init('https://www.orange.pl/wwt/streetZips?placeId=' . $_GET['city_id'] . '&streetId=' . $_GET['street_id'] . '&streetNumber=' . $_GET['street_number']);
    $tost = curl_exec($ch);
    curl_close($ch);
}

if ($_GET['type'] == "offers") {


    /////////////////////////////////////////GET ORANGE TOKEN
    $cookies = array();
    $tokenc = curl_init('https://www.orange.pl/hapi/pwa/v1/offerSelector/getToken');
    curl_setopt($tokenc, CURLOPT_RETURNTRANSFER, 1);
    // Ask for the callback.
    curl_setopt($tokenc, CURLOPT_HEADERFUNCTION, "curlResponseHeaderCallback");
    $result = curl_exec($tokenc);
    //var_dump($cookies);
    curl_close($tokenc);
    /////////////////////////////////////////END TOKEN 


    $payload = '{"wwtAddress":{"preZipCode":"","postalCode":"","town":"' . $_GET['city_name'] . '","line1":"' . $_GET['street_name'] . '","line2":"' . $_GET['street_number'] . '","appartmentNo":"' . $_GET['appartment_number'] . '","streetId":' . $_GET['street_id'] . ',"cityId":' . $_GET['city_id'] . ',"streetNumber":"' . $_GET['street_number'] . '"},"process":"ACTIVATION","factory":"FIX","wwtSuflerUid":"pwaWWTSufler","productFilterUid":"fixAllOfferFilter","productFilterLdfUid":null,"useMolierSfh":false}';

    $ch = curl_init("https://www.orange.pl/hapi/pwa/v3/api/offers");

    //echo $payload;
    $result = str_replace('"', "", $result);
    curl_setopt($ch, CURLOPT_COOKIE, $cookies[0][1]);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'CSRFToken: ' . $result, 'Content-Length: ' . strlen($payload)));
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    //echo $result."  ";
    //echo $cookies[0][1];
    $tost = curl_exec($ch);
}




function curlResponseHeaderCallback($tokenc, $headerLine)
{
    global $cookies;
    if (preg_match('/^Set-Cookie:\s*([^;]*)/mi', $headerLine, $cookie) == 1)
        $cookies[] = $cookie;
    return strlen($headerLine); // Needed by curl
}
