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
  <link rel="manifest" href="manifest.json" />
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
            <li class="nav-item"><a class="nav-link" href="terminale.php">Terminale</a></li>
            <li class="nav-item"><a class="nav-link active" href="kodypocztowe.php">Kody pocztowe</a></li>
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
    <div class=row>
      <div class="col-xs-6 col-md-4">

        <h2>Kody pocztowe</h2>
        <div style="border: 2px solid gray; text-align: center;padding-top: 10px;padding-bottom: 10px;">
          Wybrana miejscowość: <c id=chosenCity></c><br>
          Wybrana ulica: <c id=chosenStreet></c>
        </div>
        <br>
        <div class="input-group mb-3">
          <input type="text" id="cityInput" class="form-control" placeholder="Miejscowość" aria-label="Miejscowość" aria-describedby="button-addon2">
          <div class="input-group-append">
            <button class="btn btn-secondary" type="button" id="getCityButton">Znajdź miejscowość</button>
          </div>
        </div>
        <div id=cityTableDiv>
          <table class=table id="cityTable">
            <thead>
              <tr>
                <th scope="col">Miasto</th>
                <th scope="col">Dokładna lokalizacja</th>
                <th scope="col">Wybieram!</th>
              </tr>
            </thead>
            <tbody id=cityTableContent>
            </tbody>
          </table>
        </div>

        <div class="alert alert-info" role="alert">
          <span class="alert-icon"></span>
          <p>W przypadku miejscowości bez ulicy wpisz miejscowość jako ulicę</p>
        </div>


        <div class="input-group mb-3">
          <input type="text" id="streetInput" class="form-control" placeholder="Ulica" aria-label="Ulica" aria-describedby="button-addon2">
          <div class="input-group-append">
            <button class="btn btn-secondary" type="button" id="getStreetButton">Znajdź ulicę</button>
          </div>
        </div>
        <div id=streetTableDiv>
          <table class=table id="streetTable">
            <thead>
              <tr>
                <th scope="col">Ulica</th>
                <th scope="col">Wybieram!</th>
              </tr>
            </thead>
            <tbody id=streetTableContent>
            </tbody>
          </table>
        </div>

        <div class="input-group mb-3">
          <input type="text" id="numberInput" class="form-control" placeholder="Numer budynku" aria-label="Numer budynku" aria-describedby="button-addon2">
          <div class="input-group-append">
            <button class="btn btn-secondary" type="button" id="getZipCodeButton">Pobierz kod pocztowy</button>
          </div>
        </div>
        <p style="text-align: center;font-size: x-large;">Możliwe kody: </p>
        <pre id=zipCodePlace style="text-align: center;font-size: xx-large;">

        </pre>
      </div>
      <!--Another column-->
      <div class="col-xs-6 col-md-4">
        <h2>Weryfikacja FIX</h2>
        <div class="alert alert-info" role="alert">
          <span class="alert-icon"></span>
          <p>Wpisz adres w poprzednim module - weryfikacja fix będzie bazować na tych danych</p>
        </div>

        <div class="alert alert-warning" role="alert">
          <span class="alert-icon"></span>
          <p>Ten moduł jeszcze nie działa w 100% - nie ma 2P ani info o superofercie</p>
        </div>

        <div class="input-group mb-3">
          <input type="text" id="lokalInput" class="form-control" placeholder="Numer lokalu" aria-label="Numer lokalu" aria-describedby="button-addon2">
        </div>
        <button id="getOffersButton" type="button" class="btn btn-primary btn-block">Sprawdź adres</button>
        <br>
        <div>
          <h3>Info o adresie:</h3>
          <div id=addressInfo>

          </div>
          <br>
          <h3>Możliwości:</h3>
          <table class=table id="offerTable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <!--offerType-->
                <th scope="col">Nazwa oferty</th>
                <!--mainServices/0/features/config/0/value/Name-->
              </tr>
            </thead>
            <tbody id=offerTableContent>
            </tbody>
          </table>
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
    <script src="scriptKody.js?ver=2"></script>


    <?php require("mnpmodal.php"); ?>
</body>

</html>