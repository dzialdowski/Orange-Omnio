<?php

function is_not_null($var)
{
    return !is_null($var);
}

class AttrFilter
{
}
class AttrStickerFilter
{
    public $Bestseller; //String
    public $Outlet; //String
    public $Preorder; //String
    public $PolecanyDo5G; //String
    public $eSIM; // String

    function setBestseller()
    {
        $this->Bestseller = "Bestseller";
    }
    function setOutlet()
    {
        $this->Outlet = "Outlet";
    }
    function setPreorder()
    {
        $this->preorder = "Nowość";
    }
    function setPolecanyDo5G()
    {
        $this->PolecanyDo5G = "Polecany do 5G";
    }
    function seteSIM()
    {
        $this->eSIM = "eSIM w Orange";
    }
}
class AttrNumberFilter
{
}
class PriceFilter
{
    public $to; //int
    public $from; //int
}
class DeviceInOfferPriceFilter
{
    public $to; //int
    public $from; //int
}
class SearchPayload
{
    public $category; //String
    public $producer; //String
    public $start; //int
    public $sortMode; //String
    public $attrFilter; //AttrFilter
    public $attrStickerFilter; //AttrStickerFilter
    public $attrNumberFilter; //AttrNumberFilter
    public $deviceInOfferPriceFilter; //DeviceInOfferPriceFilter
    public $priceFilter; //PriceFilter
    public $matchToFilter;  //array( undefined )
    public $searchValue; //String
    public $isChangeProductMode; //boolean 
    public $process; //String
    public $propositionItemId; //String
    public $oneTimePriceInOfferFilters; //array( OneTimePriceInOfferFilters )
    public $showAvailable; //boolean 
    public $showAll; //boolean

    public function __construct()
    {
        $this->start = 1;
        $this->oneTimePriceInOfferFilters = array();
        $this->attrFilter = new AttrFilter();
        $this->attrStickerFilter = new AttrStickerFilter();
        $this->priceFilter = new PriceFilter();
        $this->deviceInOfferPriceFilter = new DeviceInOfferPriceFilter();
        $this->matchToFilter = array();
        $this->sortMode = "";
        $this->isChangeProductMode = false;
        $this->showAvailable = false;
        $this->showAll = true;
        $this->attrNumberFilter = new attrNumberFilter();
        $this->searchValue="";
    }
}

$searchPayload = new SearchPayload();

$terminal = json_decode($_GET['data']);
$producer = $terminal->producer;
$search = $terminal->search;
$category = $terminal->category;
if ($terminal->piecgie) {
    $searchPayload->attrStickerFilter->setPolecanyDo5G();
}
if ($terminal->esim) {
    $searchPayload->attrStickerFilter->seteSIM();
}
if ($terminal->outlet) {
    $searchPayload->attrStickerFilter->setOutlet();
}
if ($terminal->preorder) {
    $searchPayload->attrStickerFilter->setPreorder();
}
$searchPayload->process = "ACTIVATION";

$searchPayload->propositionItemId=$terminal->offerType;

if ($terminal->priceFilter && $terminal->offerType != '"DEFAULT_SALES_OF_GOODS_PROPOSITION$MOB_CPO_SALES_OF_GOODS"') {
    $searchPayload->oneTimePriceInOfferFilters['to'] = $terminal->priceTo;
    $searchPayload->oneTimePriceInOfferFilters['from'] = $terminal->priceFrom;
} else if ($terminal->priceFilter && $terminal->offerType == '"DEFAULT_SALES_OF_GOODS_PROPOSITION$MOB_CPO_SALES_OF_GOODS"') {
    $searchPayload->priceFilter->to = $terminal->priceFilter->to;
    $searchPayload->priceFilter->from = $terminal->priceFilter->from;
}
if ($terminal->onlyAvailable) {
    $searchPayload->onlyAvailable = $terminal->onlyAvailable;
}
if ($terminal->offerType == '"TANTO_B2B_249410$MOB_CPO_7050_5722_AC_249410"') {
    $searchPayload->process = 'INSTALMENT_SALES_OF_GOODS_NC';
}

if ($terminal->offerType == '"DEFAULT_SALES_OF_GOODS_PROPOSITION$MOB_CPO_SALES_OF_GOODS"') {
    $searchPayload->process = 'SALE_OF_GOODS';
}

if ($terminal->offerType == '"Orange_Oferta_dla_Firm_251056$MOB_CPO_7318_5726_AC_251056"' || $terminal->offerType == '"Orange_Oferta_dla_Firm_251057$MOB_CPO_7318_5726_AC_251057"' || $terminal->offerType == '"Orange_Oferta_dla_Firm_251058$MOB_CPO_7318_5726_AC_251058"' || $terminal->offerType == '"Orange_Oferta_dla_Firm_251059$MOB_CPO_7318_5726_AC_251059"') {
    $searchPayload->process = 'MNP';
}

$searchPayload->category = $terminal->category;
$searchPayload->producer = $terminal->producer;
$searchPayload->searchValue = $terminal->search;





$token = fopen("https://www.orange.pl/hapi/pwa/v1/offerSelector/getToken", 'r');
$token = fgets($token);
$cookies = array();
foreach ($http_response_header as $hdr) {
    if (preg_match('/^Set-Cookie:\s*([^;]+)/', $hdr, $matches)) {
        parse_str($matches[1], $tmp);
        $cookies += $tmp;
    }
}
$token = str_replace('"', "", $token);


$opts = array(
    'http' => array(
        'method' => "POST",
        'header' =>
            "Accept-language: pl\r\n" .
            "Content-type: application/json; charset=UTF-8\r\n" .
            "CSRFToken: " . $token."\r\n".
            "Cookie: ". http_build_query($cookies,'','; '). "\r\n",
        'content' => json_encode($searchPayload)
    )
);
//var_dump($opts);
$context = stream_context_create($opts);
$fp = fopen('https://www.orange.pl/hapi/sklep/getFiltered', 'r', false, $context);

echo stream_get_contents($fp);

function curlResponseHeaderCallback($tokenc, $headerLine)
{
    global $cookies;
    if (preg_match('/^Set-Cookie:\s*([^;]*)/mi', $headerLine, $cookie) == 1)
        $cookies[] = $cookie;
    return strlen($headerLine); // Needed by curl
}
