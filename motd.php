<?php
require("config.php");
$requestType = $_GET['requestType'];

if ($requestType == "SET") {
    $motd = urldecode($_GET['motd']);
    file_put_contents(
        "motd.json",
        $motd
    );
}

if ($requestType == "GET") {
    echo file_get_contents("motd.json");
}
