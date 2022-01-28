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
        $this->searchValue = "";
        $this->process = "ACTIVATION";
    }

    public function setSortModeRecommendedDesc()
    {
        $this->sortMode = "recommendedDesc";
    }
    public function setSortModeDateDesc()
    {
        $this->sortMode = "dateDesc";
    }
    public function setSortModeDateAsc()
    {
        $this->sortMode = "dateAsc";
    }
    public function setSortModeNameAsc()
    {
        $this->sortMode = "nameAsc";
    }
    public function setSortModeNameDesc()
    {
        $this->sortMode = "nameDesc";
    }
    public function setSortModePriceInOfferAsc()
    {
        $this->sortMode = "priceInOfferAsc";
    }
    public function setSortModePriceInOfferDesc()
    {
        $this->sortMode = "priceInOfferDesc";
    }

    public function setFromInputData($terminal)
    {
        $this->category = $terminal->category;
        $this->producer = $terminal->producer;
        $this->searchValue = $terminal->search;
        $this->propositionItemId = $terminal->offerType;
        $this->sortMode = $terminal->sortMode;

        if ($terminal->piecgie) {
            $this->attrStickerFilter->setPolecanyDo5G();
        }
        if ($terminal->esim) {
            $this->attrStickerFilter->seteSIM();
        }
        if ($terminal->outlet) {
            $this->attrStickerFilter->setOutlet();
        }
        if ($terminal->preorder) {
            $this->attrStickerFilter->setPreorder();
        }

        if ($terminal->priceFilter && $terminal->offerType != '"DEFAULT_SALES_OF_GOODS_PROPOSITION$MOB_CPO_SALES_OF_GOODS"') { // to be checked
            $this->oneTimePriceInOfferFilters['to'] = $terminal->priceTo;
            $this->oneTimePriceInOfferFilters['from'] = $terminal->priceFrom;
        } else if ($terminal->priceFilter && $terminal->offerType == '"DEFAULT_SALES_OF_GOODS_PROPOSITION$MOB_CPO_SALES_OF_GOODS"') {
            $this->priceFilter->to = $terminal->priceFilter->to;
            $this->priceFilter->from = $terminal->priceFilter->from;
        }
        if ($terminal->onlyAvailable) {
            $this->showAvailable = $terminal->onlyAvailable;
        }
        if ($terminal->offerType == '"TANTO_B2B_249410$MOB_CPO_7050_5722_AC_249410"') {
            $this->process = 'INSTALMENT_SALES_OF_GOODS_NC';
        }

        if ($terminal->offerType == '"DEFAULT_SALES_OF_GOODS_PROPOSITION$MOB_CPO_SALES_OF_GOODS"') {
            $this->process = 'SALE_OF_GOODS';
        }

        if (
            $terminal->offerType == '"Orange_Oferta_dla_Firm_251056$MOB_CPO_7318_5726_AC_251056"'
            || $terminal->offerType == '"Orange_Oferta_dla_Firm_251057$MOB_CPO_7318_5726_AC_251057"'
            || $terminal->offerType == '"Orange_Oferta_dla_Firm_251058$MOB_CPO_7318_5726_AC_251058"'
            || $terminal->offerType == '"Orange_Oferta_dla_Firm_251059$MOB_CPO_7318_5726_AC_251059"'
        ) {
            $this->process = 'MNP';
        }
    }
}

class ApiCredentials
{
    public $cookies;
    public $token;

    public function __construct()
    {
        $this->cookies = array();
    }

    function getCredentialsFromRemote()
    {
        $this->token = fopen("https://www.orange.pl/hapi/pwa/v1/offerSelector/getToken", 'r');
        $this->token = fgets($this->token);
        foreach ($http_response_header as $hdr) {
            if (preg_match('/^Set-Cookie:\s*([^;]+)/', $hdr, $matches)) {
                parse_str($matches[1], $tmp);
                $this->cookies += $tmp;
            }
        }
        $this->token = str_replace('"', "", $this->token);
    }
}


$searchPayload = new SearchPayload();


$terminal = json_decode(
    isset($_GET['data']) ?
        $_GET['data'] :
        '{"producer":"","offerType":"Orange_Oferta_dla_Firm_249810$MOB_CPO_7291_5726_AC_249810","category":"Phones and Devices","search":"alcatel","piecgie":false,"esim":false,"outlet":false,"preorder":false,"priceFilter":false,"priceFrom":"","priceTo":"","sortMode":"recommendedDesc","loyalty":24,"onlyAvailable":true,"checkPickup":false}'
);

$searchPayload->setFromInputData($terminal);


$apiCredentials = new ApiCredentials();
$apiCredentials->getCredentialsFromRemote();

$opts = array(
    'http' => array(
        'method' => "POST",
        'header' => "Accept-language: pl\r\n" .
            "Content-type: application/json; charset=UTF-8\r\n" .
            "CSRFToken: " . $apiCredentials->token . "\r\n" .
            "Cookie: " . http_build_query($apiCredentials->cookies, '', '; ') . "\r\n",
        'content' => json_encode($searchPayload)
    )
);
$context = stream_context_create($opts);
$fp = fopen('https://www.orange.pl/hapi/sklep/getFiltered', 'r', false, $context);

echo stream_get_contents($fp);
