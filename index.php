<?php
error_log(0);
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
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/ico" href="<?php echo $endpoint; ?>/favicon.ico">
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
                        <li class="nav-item"><a class="nav-link active" href="index.php">Kupony rabatowe</a></li>
                        <li class="nav-item"><a class="nav-link" href="#" id="showMNPbutton">Kalkulator MNP</a></li>
                        <li class="nav-item"><a class="nav-link" href="terminale.php">Terminale</a></li>
                        <li class="nav-item"><a class="nav-link" href="kodypocztowe.php">Kody pocztowe</a></li>
                        <?php if (($tg_user && in_array($tg_user['id'], $adminArray)) || $_SERVER['REMOTE_ADDR'] == '192.168.1.10') { ?>
                            <li class="nav-item"><a class="nav-link" href="login.php">Admin panel</a></li>
                        <?php } ?>
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

                <h2>Kupony rabatowe</h2>

                <div id=MOTD_content></div>

                <h3>Dostępne kody:</h3>

                <div id="couponList">

                </div>
                <button id="getCouponsButton" type="button" class="btn btn-primary btn-block">Odśwież<span id="refreshCountdown" class="badge badge-light">9</span></button>
                <button id="getLastCoupon" type="button" class="btn btn-primary btn-block">Pobierz ostatni kupon</button>
                <br>
                <div>
                    <h3>Zwrot kuponów</h3>
                    <div class="input-group mb-3">
                        <input id="couponCodeToReturn" type="text" class="form-control" placeholder="X99-XXXX-XXXX-XXXX" aria-label="Kupon do zwrotu" aria-describedby="zwrot-button">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="button" id="zwrot-button">Zwróć</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-md-8" id=typy></div>
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
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/tablesorter@2.31.3/dist/js/jquery.tablesorter.min.js" integrity="sha384-+PEWXCk8F17zxsQsEjkuHjUN4yFMHv03eKxKLrqwDql8FJQM0NeSvHRZFVLfXyn7" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@4.5.1/dist/js/swiper.min.js" integrity="sha384-llVNZVxgabZyf5ZeGs3m2QcNbEE0UK1PBKM6ZoJmWK5BuBpqZUXpN1nWXd0SrAC5" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/boosted@5.1.3/dist/js/boosted.bundle.min.js" integrity="sha384-5thbp4uNEqKgkl5m+rMBhqR+ZCs+3iAaLIghPWAgOv0VKvzGlYKR408MMbmCjmZF" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/focus-visible@5.2.0/dist/focus-visible.min.js" integrity="sha384-xRa5B8rCDfdg0npZcxAh+RXswrbFk3g6dlHVeABeluN8EIwdyljz/LqJgc2R3KNA" crossorigin="anonymous"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <script src="script.js?ver=4"></script>
        <?php require("mnpmodal.php"); ?>
</body>

</html>