<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require '../vendor/autoload.php';

$env = file('../.env');
foreach ($env as $env_value) {
    putenv($env_value);
}

$routes = new routes\Routes();

$routes->api();
