<?php
$producer = $_GET['producer'];
$offerType = $_GET['offer'];
$search = $_GET['search'];
$category = $_GET['category'];
$lojalka = "\"".$_GET['lojalka']."\"";
$sticker = "";
if($_GET['piecgie']=='true') $sticker = $sticker.'"PolecanyDo5G":"Polecany do 5G",';
if($_GET['esim']=='true') $sticker = $sticker.'"eSIM":"eSIM w Orange",';
if($_GET['outlet']=='true') $sticker = $sticker.'"Outlet":"Outlet",';
if($_GET['preorder']=='true') $sticker = $sticker.'"Preorder":"Nowość",';
$process="ACTIVATION";

$installment= ',"deviceInstallmentsCount":'.$lojalka.'}';
$installment='';

if($_GET['priceFilter']=='true' && $offerType!='"DEFAULT_SALES_OF_GOODS_PROPOSITION$MOB_CPO_SALES_OF_GOODS"') $installment = $installment.',"oneTimePriceInOfferFilters":[{"to":"'.$_GET['priceTo'].'","from":"'.$_GET['priceFrom'].'"}]';
if($_GET['priceFilter']=='true' && $offerType=='"DEFAULT_SALES_OF_GOODS_PROPOSITION$MOB_CPO_SALES_OF_GOODS"') $installment = $installment.',"priceFilter":{"to":"'.$_GET['priceTo'].'","from":"'.$_GET['priceFrom'].'"}';
if($_GET['onlyAvailable']=='true') $installment = $installment.',"showAvailable": true';
$installment= $installment.'}';
if($sticker) $sticker=substr($sticker, 0, -1);
if($offerType=='"TANTO_B2B_249410$MOB_CPO_7050_5722_AC_249410"'){ 
    /*$payload='{"category":"Phones and Devices","producer":'.
        $producer.',"start":1,"showAll":true,"sortMode":"","attrFilter":{},"attrStickerFilter":{'.$sticker.'},"attrNumberFilter":{},"priceFilter":{},"matchToFilter":{},"searchValue":'.
        $search.',"isChangeProductMode":false,"process":"INSTALMENT_SALES_OF_GOODS_NC",
        "propositionItemId":"TANTO_B2B_249410$MOB_CPO_7050_5722_AC_249410","oneTimePriceInOfferFilters":[]}
    ';*/
    $process='INSTALMENT_SALES_OF_GOODS_NC';
}

if($offerType=='"DEFAULT_SALES_OF_GOODS_PROPOSITION$MOB_CPO_SALES_OF_GOODS"'){ 
    /*$payload='{"category":"Phones and Devices","producer":'.
        $producer.',"start":1,"showAll":true,"sortMode":"","attrFilter":{},"attrStickerFilter":{'.$sticker.'},"attrNumberFilter":{},"priceFilter":{},"matchToFilter":{},"searchValue":'.
        $search.',"isChangeProductMode":false,"process":"INSTALMENT_SALES_OF_GOODS_NC",
        "propositionItemId":"TANTO_B2B_249410$MOB_CPO_7050_5722_AC_249410","oneTimePriceInOfferFilters":[]}
    ';*/
    $process='SALE_OF_GOODS';
}

if($offerType=='"Orange_Oferta_dla_Firm_251056$MOB_CPO_7318_5726_AC_251056"'||$offerType=='"Orange_Oferta_dla_Firm_251057$MOB_CPO_7318_5726_AC_251057"'||$offerType=='"Orange_Oferta_dla_Firm_251058$MOB_CPO_7318_5726_AC_251058"'||$offerType=='"Orange_Oferta_dla_Firm_251059$MOB_CPO_7318_5726_AC_251059"'){
    $process='MNP';
}
$payload = '{"category":'.$category.',"producer":'.
    $producer.',"start":1,"showAll":true,"attrStickerFilter":{'.$sticker.'},"searchValue":'.
    $search.',"process":"'.$process.'","propositionItemId":'. 
    $offerType.$installment;

$cookies = Array();
$tokenc = curl_init('https://www.orange.pl/hapi/pwa/v1/offerSelector/getToken');
curl_setopt($tokenc, CURLOPT_RETURNTRANSFER, 1);
// Ask for the callback.
curl_setopt($tokenc, CURLOPT_HEADERFUNCTION, "curlResponseHeaderCallback");
$result = curl_exec($tokenc);
//var_dump($cookies);
curl_close($tokenc);
$ch = curl_init("https://www.orange.pl/hapi/sklep/getFiltered");

//echo $payload;
$result=str_replace('"', "", $result);
curl_setopt($ch, CURLOPT_COOKIE	, $cookies[0][1]);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'CSRFToken: '.$result, 'Content-Length: ' . strlen($payload)));
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
//echo $result."  ";
//echo $cookies[0][1];
$tost = curl_exec($ch);

//print_r( curl_getinfo($ch));
curl_close($ch);

function curlResponseHeaderCallback($tokenc, $headerLine) {
    global $cookies;
    if (preg_match('/^Set-Cookie:\s*([^;]*)/mi', $headerLine, $cookie) == 1)
        $cookies[] = $cookie;
    return strlen($headerLine); // Needed by curl
}
