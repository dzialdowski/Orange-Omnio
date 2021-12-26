<?php
$pickup = $_GET['productBaseCode'];
$ch = curl_init("https://www.orange.pl/hapi/delivery?productBaseCode=".$pickup);

$tost = curl_exec($ch);
