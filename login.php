<?php
require("config.php");
$nazwa = "";
define('BOT_USERNAME', $botUsername); // place username of your bot here
function getTelegramUserData()
{
  if (isset($_COOKIE['tg_user'])) {
    $auth_data_json = urldecode($_COOKIE['tg_user']);
    $auth_data = json_decode($auth_data_json, true);
    return $auth_data;
  }
  return false;
}
$tg_user = getTelegramUserData();

?>



<!doctype html>
<html lang="pl">

<head>
  <title>OMNIO</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/ico" href="favicon.ico">
  <!-- Bootstrap CSS -->
  <!-- Copyright © 2016 Orange SA. All rights reserved -->
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
        <a class="navbar-brand" style="font-size: xx-large;" href="#">Omni<c style="background-color: black;" class="text-primary">o</c></a><?php
                                                                                                                                            if ($_SERVER['REMOTE_ADDR'] == '192.168.1.10') {
                                                                                                                                            ?> <mark>ŚRODOWISKO TESTOWE</mark> <?php
                                                                                                                                            } else if ($tg_user !== false) { //User logged in
                                                                                                                                              $first_name = htmlspecialchars($tg_user['first_name']);
                                                                                          ?> <mark>Witaj
          <?php
                                                                                                                                              echo " " . $first_name . "!</mark>";
                                                                                                                                            } else { //User needs to log in
          ?><script async src="https://telegram.org/js/telegram-widget.js?14" data-telegram-login="<?php echo $botUsername;?>" data-size="large" data-userpic="false" data-radius="0" data-auth-url="<?php echo $endpoint; ?>check_authorization.php" data-request-access="write"></script> <?php
                                                                                                                                                                                                                                                                                              } ?></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsing-navbar" aria-controls="collapsing-navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="navbar-collapse justify-content-between collapse" id="collapsing-navbar">
            <ul class="navbar-nav">
              <li class="nav-item"><a class="nav-link" href="index.php">Kupony rabatowe</a></li>
              <li class="nav-item"><a class="nav-link" href="#" id="showMNPbutton">Kalkulator MNP</a></li>
              <li class="nav-item"><a class="nav-link" href="terminale.php">Terminale</a></li>
              <li class="nav-item"><a class="nav-link" href="kodypocztowe.php">Kody pocztowe</a></li>
              <li class="nav-item"><a class="nav-link active" href="login.php">Admin panel</a></li>
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
  <div class="container-fluid">
    <div class=row>
      <div class="col-xs-6 col-md-3">
        <?php
        if (in_array($tg_user['id'], $adminArray) || $_SERVER['REMOTE_ADDR'] == '192.168.1.10') { ?>
          <h2>MOTD</h2>
          <label for="MOTD_type">Typ wiadomości:</label>
          <select class="form-control" id="MOTD_type">
            <option value="alert-success">SUKCES</option>
            <option value="alert-danger">BŁĄD</option>
            <option value="alert-warning">OSTRZEŻENIE</option>
            <option value="alert-info">INFORMACJA</option>
          </select>

          <label for="MOTD_content">Treść:</label>
          <input class="form-control" type="text" id=MOTD_content></input>
          <br><br>
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="MOTD_additionalContentCheck">
            <label class="custom-control-label" for="MOTD_additionalContentCheck">Dodatkowa treść</label>
          </div>
          <input class="form-control" type="text" id=MOTD_additionalContent disabled></input>
          <button id="addMOTDbutton" type="button" class="btn btn-primary btn-block">Generuj wiadomość</button>
          <br>
          <h3>Podgląd:</h3>
          <div id=MOTD_contentPreview></div>
          <br>
          <div id=MOTD_contentPreview_json></div>
        <?php
        } else {
          echo "Nie jesteś adminem!\n";
          echo $_SERVER['REMOTE_ADDR'];
        }

        ?>
      </div>
      <div class="col-xs-6 col-md-3">

        <h2>Admin panel</h2>



        <h3>Dostępne kody:</h3>

        <div id="couponList">

        </div>
        <button id="getCouponsButton" type="button" class="btn btn-primary btn-block">Odśwież<span id="refreshCountdown" class="badge badge-light">9</span></button>
      </div>
      <div class="col-xs-6 col-md-3">
        <?php
        if (in_array($tg_user['id'], $adminArray) || $_SERVER['REMOTE_ADDR'] == '192.168.1.10') { ?>
          <h2>Dodawanie kuponów</h2>
          <label for="couponTypes">Typ kuponu:</label>
          <select class="form-control" id="couponTypes">
          </select>
          <label for="couponsArea">Kupony:</label>
          <input class="form-control" type="textarea" id=couponsArea></input>

          <button id="addCouponsButton" type="button" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-search"></span>Dodaj kupony</button>
        <?php
        } else echo "Nie jesteś adminem!";
        ?>
      </div>
      <div class="col-xs-6 col-md-3">
        <?php
        if (in_array($tg_user['id'], $adminArray) || $_SERVER['REMOTE_ADDR'] == '192.168.1.10') { ?>
          <h2>Pozostałe funkcje</h2>
          <label for="couponTypesList">Typ kuponu:</label>
          <select class="form-control" id="couponTypesList">
          </select>
          <div class="custom-control custom-switch">
            <input style="border: 1px solid gray" type="checkbox" class="custom-control-input" id="showAlsoUsed" />
            <label class="custom-control-label" for="showAlsoUsed">Pokaż także zużyte</label>
          </div>
          <div class=row>
            <button id="showCouponsButton" type="button" class="btn btn-primary btn-block col-xs-6 col-md-6"><span class="glyphicon glyphicon-search"></span>Wyświetl kupony</button>
            <button id="deleteCouponsButton" type="button" style="margin-top:0px;" class="btn btn-primary btn-block col-xs-6 col-md-6"><span class="glyphicon glyphicon-search"></span>Usuń kupony</button>
          </div>

          <label for="">Kupony:</label>
          <div id=couponsTablePlace></div>
        <?php
        } else echo "Nie jesteś adminem!";
        ?>
      </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 id="myModalLabel2" class="modal-title">Twój kupon został zarezerwowany i oznaczony jako zużyty!</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"><span class="visually-hidden">Close</span></button>
          </div>
          <div class="modal-body">
            <div class="d-flex">
              <div class="flex-grow-1">
                <div id="couponText">Twój kupon to:
                  <pre class="user-select-all" id=couponPlace></pre> <br>
                  Tapnij, aby zaznaczyć cały. Zapisz go sobie(np. wyślij do siebie na mattera). <br>
                  Jak zamkniesz okno to użyj przycisku "Pobierz ostatni kupon" aby go odzyskać. <br>
                  APLIKACJA PAMIĘTA TYLKO JEDEN KUPON
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij okno</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="noCoupon" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ups...</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"><span class="visually-hidden">Close</span></button>
          </div>
          <div class="modal-body">
            Niestety ktoś był szybszy.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
          </div>
        </div>
      </div>
    </div>


    <div style="display: none;" id="typy"></div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/tablesorter@2.31.3/dist/js/jquery.tablesorter.min.js" integrity="sha384-+PEWXCk8F17zxsQsEjkuHjUN4yFMHv03eKxKLrqwDql8FJQM0NeSvHRZFVLfXyn7" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@4.5.1/dist/js/swiper.min.js" integrity="sha384-llVNZVxgabZyf5ZeGs3m2QcNbEE0UK1PBKM6ZoJmWK5BuBpqZUXpN1nWXd0SrAC5" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/boosted@5.1.3/dist/js/boosted.bundle.min.js" integrity="sha384-5thbp4uNEqKgkl5m+rMBhqR+ZCs+3iAaLIghPWAgOv0VKvzGlYKR408MMbmCjmZF" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/focus-visible@5.2.0/dist/focus-visible.min.js" integrity="sha384-xRa5B8rCDfdg0npZcxAh+RXswrbFk3g6dlHVeABeluN8EIwdyljz/LqJgc2R3KNA" crossorigin="anonymous"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src=script.js?ver=3></script>

    <script>
      $(document).ready(function() {
        function getMOTD() {
          let response = $.ajax({
            url: "api/motd.php?requestType=GET",
            dataType: 'json',
            async: false
          });
          if (response.responseText == "") return 0;
          let MOTD = JSON.parse(response.responseText);
          setMOTDonDOM(MOTD);
        }
        getMOTD();

        function addCoupons(coupons, couponType) {
          document.getElementById("couponsArea").value = "";
          // coupons.forEach(kupon => {
          //   var typy = $.ajax({ 
          //     url: "api/addCoupon.php?codeType="+couponType+"&codeValue="+kupon,
          //     dataType: 'json',
          //     async: false
          //   })
          // });
          var couponTypes = $.ajax({
            url: "api/addCoupon.php?codeType=" + couponType + "&codeValue=" + encodeURIComponent(JSON.stringify(coupons)),
            dataType: 'json',
            async: false
          })

        }

        var couponTypes = $.ajax({
          url: "api/getCouponTypes.php",
          dataType: 'json',
          async: false
        });
        document.getElementById("typy").innerHTML = '';
        json1 = JSON.parse(couponTypes.responseText);
        var html1 = "";
        json1["success"].forEach(row => {
          html1 += "<option value=" + row["CouponType"] + ">" + row["CouponType"] + "</option>";
        });
        document.getElementById("couponTypes").innerHTML = html1;
        html1 = "<option value=ALL>Wszystkie</option>" + html1;
        document.getElementById("couponTypesList").innerHTML = html1;


        function setMOTD(motd) {
          var response = $.ajax({
            url: "api/motd.php?requestType=SET&motd=" + encodeURI(JSON.stringify(motd)),
            dataType: 'json',
            async: false
          });
        }

        function setMOTDonDOM(MOTD) {
          if (MOTD.additionalContentCheck) {
            document.getElementById("MOTD_contentPreview").innerHTML = '<div class="alert ' + MOTD.type + '" role="alert"><span class="alert-icon"></span>  <div>      <h4 class="alert-heading">' + MOTD.content + '</h4>      <p>' + MOTD.additionalContent + '</p>  </div></div>';
          } else {
            document.getElementById("MOTD_contentPreview").innerHTML = '<div class="alert ' + MOTD.type + '" role="alert"><span class="alert-icon"></span>  <p>' + MOTD.content + '</p></div>';
          }
        }

        $("#addMOTDbutton").click(function() {
          createMOTD();
        })

        function createMOTD() {
          let MOTD = {
            type: document.getElementById("MOTD_type").value,
            content: document.getElementById("MOTD_content").value,
            additionalContentCheck: document.getElementById("MOTD_additionalContentCheck").checked,
            additionalContent: document.getElementById("MOTD_additionalContent").value
          }
          setMOTD(MOTD);
          document.getElementById("MOTD_contentPreview_json").innerHTML = JSON.stringify(MOTD);
          setMOTDonDOM(MOTD);


        }

        $("#addCouponsButton").click(function() {
          let couponType = document.getElementById("couponTypes").value;
          let coupons = document.getElementById("couponsArea").value.split(" ");
          if (confirm("Zamierzasz dodać " + coupons.length + " kuponów jako " + couponType + " \n\n" + coupons.join("\n"))) {
            addCoupons(coupons, couponType);
          } else {
            alert("Anulowano dodawanie kuponów")
          }
        });

        $("#MOTD_additionalContentCheck").click(function() {
          if (document.getElementById("MOTD_additionalContentCheck").checked) {
            document.getElementById("MOTD_additionalContent").disabled = false;
          } else {
            document.getElementById("MOTD_additionalContent").disabled = true;
          }
        });

        $("#showCouponsButton").click(function() {
          document.getElementById("couponsTablePlace").innerHTML = "";
          let couponType = document.getElementById("couponTypesList").value;
          let showAlsoUsed = document.getElementById("showAlsoUsed").checked;
          var kupony = $.ajax({
            url: "api/showCoupons.php?codeType=" + couponType + "&showAlsoUsed=" + showAlsoUsed,
            dataType: 'json',
            async: false
          })
          json = JSON.parse(kupony.responseText);
          var html = "<table class='shadow-lg table'><thead><tr><th scope=col>Kupon</th></tr></thead>"; //TODO: Dodać opcję ręcznego anulowania kuponu
          if (json["success"] == null) {
            html = '<div class="alert alert-warning" role="alert"><span class="alert-icon"></span><p>Kupony się skończyły :c</p></div>';
            document.getElementById("couponsTablePlace").innerHTML = html;
          } else {
            json["success"].forEach(row => {
              html += "<tr><td>" + row["coupon"] + "</td></tr>";
            });
            html += "</table>";
            document.getElementById("couponsTablePlace").innerHTML = html;

          }

        });
      });
    </script>

    <?php require("mnpmodal.php"); ?>
</body>

</html>