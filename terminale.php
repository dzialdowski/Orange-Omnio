<!doctype html>
<html lang="pl">

<head>
  <title>OMNIO</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/ico" href="favicon.ico">
  <!-- Bootstrap CSS -->
  <!-- Copyright © 2014 Monotype Imaging Inc. All rights reserved -->
  <link href="https://cdn.jsdelivr.net/npm/boosted@5.1.3/dist/css/orange-helvetica.min.css" rel="stylesheet" integrity="sha384-ARRzqgHDBP0PQzxQoJtvyNn7Q8QQYr0XT+RXUFEPkQqkTB6gi43ZiL035dKWdkZe" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/boosted@5.1.3/dist/css/boosted.min.css" rel="stylesheet" integrity="sha384-Di/KMIVcO9Z2MJO3EsrZebWTNrgJTrzEDwAplhM5XnCFQ1aDhRNWrp6CWvVcn00c" crossorigin="anonymous">
  <link href="dark-mode.css?ver=2" rel="stylesheet">
  <link href="style.css?ver=2" rel="stylesheet">
</head>

<body>
  <header role="banner">
    <nav role="navigation" class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" style="font-size: xx-large;" href="#">Omni<c style="background-color: black;" class="text-primary">o</c></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsing-navbar" aria-controls="collapsing-navbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse justify-content-between collapse" id="collapsing-navbar">
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="index.php">Kupony rabatowe</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="showMNPbutton">Kalkulator MNP</a></li>
            <li class="nav-item"><a class="nav-link active" href="terminale.php">Terminale</a></li>
            <li class="nav-item"><a class="nav-link" href="kodypocztowe.php">Kody pocztowe</a></li>
            <li class="nav-item">
              <input type="checkbox" class="btn-check" id="darkSwitch" />
              <label class="btn btn-primary nav-link" for="darkSwitch" id=darkSwitchLabel>Tryb ciemny</label>
              <script src="dark-mode-switch.min.js"></script>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-xs-6 col-md-4">
        <div class="form-group">
          <label for="offerType">Typ oferty</label>
          <select class="form-control" name="" id="offerType">
            <option value="Orange_Oferta_dla_Firm_249810$MOB_CPO_7291_5726_AC_249810">S VOICE B2B 24msc</option>
            <option value="Orange_Oferta_dla_Firm_249813$MOB_CPO_7291_5726_AC_249813">M VOICE B2B 24msc</option>
            <option value="Orange_Oferta_dla_Firm_249816$MOB_CPO_7291_5726_AC_249816">L VOICE B2B 24msc</option>
            <option value="Orange_Oferta_dla_Firm_249819$MOB_CPO_7291_5726_AC_249819">XL VOICE B2B 24msc</option>
            <option value="Orange_Oferta_dla_Firm_251056$MOB_CPO_7318_5726_AC_251056">S VOICE B2B 27msc</option>
            <option value="Orange_Oferta_dla_Firm_251057$MOB_CPO_7318_5726_AC_251057">M VOICE B2B 27msc</option>
            <option value="Orange_Oferta_dla_Firm_251058$MOB_CPO_7318_5726_AC_251058">L VOICE B2B 27msc</option>
            <option value="Orange_Oferta_dla_Firm_251059$MOB_CPO_7318_5726_AC_251059">XL VOICE B2B 27msc</option>
            <option value="Orange_Oferta_dla_Firm_249811$MOB_CPO_7291_5726_AC_249811">S VOICE B2B 36msc</option>
            <option value="Orange_Oferta_dla_Firm_249814$MOB_CPO_7291_5726_AC_249814">M VOICE B2B 36msc</option>
            <option value="Orange_Oferta_dla_Firm_249817$MOB_CPO_7291_5726_AC_249817">L VOICE B2B 36msc</option>
            <option value="Orange_Oferta_dla_Firm_249820$MOB_CPO_7291_5726_AC_249820">XL VOICE B2B 36msc</option>
            <option value="Internet_Mobilny_dla_Firm_247723$MOB_CPO_6091_5706_AC_247723">DATA</option>
            <option value="Internet_Mobilny_dla_Firm_247756$MOB_CPO_6091_5706_AC_247756">DATA XL</option>
            <option value="Internet_Mobilny_dla_Firm_247774$MOB_CPO_6091_5706_AC_247774">DATA XXL</option>
            <option value="Int_dla_Firm_Biurowy_Haiti_257491$MOB_CPO_7926_5745_AC_257491">Internet Biurowy</option>
            <option value="Int_dla_Firm_Biurowy_Haiti_257492$MOB_CPO_7926_5745_AC_257492">Internet Biurowy 5G</option>
            <option value="Int_dla_Firm_Biurowy_Haiti_257493$MOB_CPO_7926_5745_AC_257493">Internet Biurowy 5G Prymium</option>
            <option value="TANTO_B2B_249410$MOB_CPO_7050_5722_AC_249410">SIMFREE</option>
            <option value="DEFAULT_SALES_OF_GOODS_PROPOSITION$MOB_CPO_SALES_OF_GOODS">SIMFREE - BEZ RAT (AKCESORIA)</option>
            <option value="Abonament_komorkowy_257214$MOB_CPO_7731_5733_AC_257214">PLAN 40 B2C</option>
            <option value="Abonament_komorkowy_257215$MOB_CPO_7731_5733_AC_257215">PLAN 50 B2C</option>
            <option value="Abonament_komorkowy_257216$MOB_CPO_7731_5733_AC_257216">PLAN 60 B2C</option>
            <option value="Abonament_komorkowy_257217$MOB_CPO_7731_5733_AC_257217">PLAN 80 B2C</option>
          </select>
          <label for="Producer">Producent</label>
          <select onchange="" class="form-control" id="Producer">
            <option value="">Dowolny</option>
            <option value="Acer">ACER</option>
            <option value="Alcatel">ALCATEL</option>
            <option value="Apple">APPLE</option>
            <option value="Cat">CAT</option>
            <option value="DJI">DJI</option>
            <option value="Fiat">FIAT</option>
            <option value="Garmin">GARMIN</option>
            <option value="GoPro">GOPRO</option>
            <option value="HAMMER">HAMMER</option>
            <option value="HP">HP</option>
            <option value="HTC">HTC</option>
            <option value="Huawei">HUAWEI</option>
            <option value="Kawasaki">KAWASAKI</option>
            <option value="Lenovo">LENOVO</option>
            <option value="LG">LG</option>
            <option value="Maxcom">MAXCOM</option>
            <option value="Meizu">MEIZU</option>
            <option value="Motorola">MOTOROLA</option>
            <option value="myPhone">MYPHONE</option>
            <option value="Nokia">NOKIA</option>
            <option value="OPPO">OPPO</option>
            <option value="Orange">ORANGE</option>
            <option value="realme">REALME</option>
            <option value="Samsung">SAMSUNG</option>
            <option value="Sony">SONY</option>
            <option value="TCL">TCL</option>
            <option value="Techbite">TECHBITE</option>
            <option value="vivo">VIVO</option>
            <option value="Winner-Group">WINNER-GROUP</option>
            <option value="Xiaomi">XIAOMI</option>
          </select>
          <label for="sortMode">Sortowanie</label>
          <select class="form-control" name="" id="sortMode">
            <option selected value="recommendedDesc">Polecane</option>
            <option value="dateDesc">Najnowsze</option>
            <option value="dateAsc">Najstarsze</option>
            <option value="nameAsc">Nazwa A-Z</option>
            <option value="nameDesc">Nazwa Z-A</option>
            <option value="priceInOfferAsc">Cena rosnąco</option>
            <option value="priceInOfferDesc">Cena malejąco</option>
          </select>
          <label for="search">Wyszukaj</label>
          <input class="form-control" autocomplete="off" type="text" placeholder="Wpisz nazwę terminala, albo zostaw puste" id=search>
          <button class="btn btn-primary btn-block" type="button" data-bs-toggle="collapse" data-bs-target="#stickers" aria-expanded="false" aria-controls="stickers">Dodatkowe opcje</button></br>
          <div class="row">
            <div class="col">
              <div class="collapse multi-collapse" id="stickers">
                <div class="card card-body">
                  <label for="">Kategoria</label>
                  <select onchange="" class="form-control" id="category">
                    <option value="Phones and Devices">Telefony i urządzenia</option>
                    <option value="Smartphones">Smartfony</option>
                    <option value="Classic phones">Telefony komórkowe</option>
                    <option value="Modems and Routers">Modemy i routery</option>
                    <option value="Tablets">Tablety</option>
                    <option value="Laptops and Consoles">Laptopy i konsole</option>
                    <option value="Smartwatches and Smartbands">Smartwatche i Smartbandy</option>
                    <option value="Smartwatches">-Smartwatche</option>
                    <option value="Smartbands">-Smartbandy</option>
                    <option value="SMART Devices">Urządzenia Smart</option>
                    <option value="Smart House">-Inteligentny dom</option>
                    <option value="Fitness">-Fitness</option>
                    <option value="Cameras and gimbals">-Kamery i gimbale</option>
                    <option value="Tv sets">Telewizory i audio</option>
                    <option value="TVs">-Telewizory</option>
                    <option value="Home cinema and HiFi">-Kina domowe i HiFi</option>
                    <option value="Speakers IoT">-Głośniki</option>
                    <option value="Headphones IoT">-Słuchawki</option>
                    <option value="Drones">Drony</option>
                    <option value="Electric vehicles">Pojazdy elektryczne</option>
                    <option value="Bundles">Zestawy</option>
                    <option value="accesories">Akcesoria</option>
                    <option value="Music and Entertament">Muzyka i rozrywka</option>
                    <option value="Headphones">Słuchawki</option>
                  </select>
                  <div class="custom-control custom-switch">
                    <input class="custom-control-input" type="checkbox" value="" id="5G">
                    <label class="custom-control-label" for="5G">
                      5G
                    </label>
                  </div>
                  <div class="custom-control custom-switch">
                    <input class="custom-control-input" type="checkbox" value="" id="eSIM">
                    <label class="custom-control-label" for="eSIM">
                      eSIM
                    </label>
                  </div>
                  <div class="custom-control custom-switch">
                    <input class="custom-control-input" type="checkbox" value="" id="Outlet">
                    <label class="custom-control-label" for="Outlet">
                      Outlet
                    </label>
                  </div>
                  <div class="custom-control custom-switch">
                    <input class="custom-control-input" type="checkbox" value="" id="preorder">
                    <label class="custom-control-label" for="preorder">
                      Nowość
                    </label>
                  </div>
                  <div class="custom-control custom-switch">
                    <input class="custom-control-input" type="checkbox" value="" id="onlyAvailable">
                    <label class="custom-control-label" for="onlyAvailable">
                      Tylko dostępne
                    </label>
                  </div>
                  <div class="custom-control custom-switch">
                    <input class="custom-control-input" type="checkbox" value="" id="priceFilter">
                    <label class="custom-control-label" for="priceFilter">Zakres ceny</label>
                    <input type="text" aria-label="Od" placeholder="Od" type="number" class="form-control" id=priceFrom>
                    <input type="text" aria-label="Do" placeholder="Do" type="number" class="form-control" id=priceTo>
                  </div>
                  <div class="custom-control custom-switch">
                    <input class="custom-control-input" type="checkbox" value="" id="checkPickup">
                    <label class="custom-control-label" for="checkPickup">
                      Sprawdź odbiór w salonie
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button id="getTerminalsButton" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span>Pokaż terminale</button>
      </div>
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h3 id="myModalLabel2" class="card-title">Twoje zapytanie zawiera mało filtrów!</h3>
              <button type="button" class="btn-close" data-bs-dismiss="modal"><span class="visually-hidden">Close</span></button>

            </div>
            <div class="modal-body">
              <div class="d-flex">
                <div class="flex-grow-1">
                  <div class="card-body">
                    <div class="card-text">Zamierzasz zabić OMNI i/lub swoją przeglądarkę ponad setką (a dokładnie <a id=requestCount></a>) zapytań o dostępność sprzętu w salonach. Oczekiwanie na odpowiedź może chwilę potrwać. Kontynuować?</div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Wolę nie</button>
                <button type="button" onclick="getTerminals()" id="acceptWarning" class="btn btn-primary">Jeszcze jak!</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-6 col-md-8" id="dzejson">

      </div>
    </div>
  </div>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/tablesorter@2.31.3/dist/js/jquery.tablesorter.min.js" integrity="sha384-+PEWXCk8F17zxsQsEjkuHjUN4yFMHv03eKxKLrqwDql8FJQM0NeSvHRZFVLfXyn7" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@4.5.1/dist/js/swiper.min.js" integrity="sha384-llVNZVxgabZyf5ZeGs3m2QcNbEE0UK1PBKM6ZoJmWK5BuBpqZUXpN1nWXd0SrAC5" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/boosted@5.1.3/dist/js/boosted.bundle.min.js" integrity="sha384-5thbp4uNEqKgkl5m+rMBhqR+ZCs+3iAaLIghPWAgOv0VKvzGlYKR408MMbmCjmZF" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/focus-visible@5.2.0/dist/focus-visible.min.js" integrity="sha384-xRa5B8rCDfdg0npZcxAh+RXswrbFk3g6dlHVeABeluN8EIwdyljz/LqJgc2R3KNA" crossorigin="anonymous"></script>
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <script src="scriptTerminals.js?ver=4"></script>

  <?php require("mnpmodal.php"); ?>

</body>

</html>