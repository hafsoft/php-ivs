<?php

//ini_set('s')
use org\haf\ivs\sample\service\SampleService;

ini_set('display_error', TRUE);
error_reporting(E_ALL);

define('DEBUG', 1);

include_once __DIR__ . '/../../classes/loader.php';
include_once __DIR__ . '/loader.php';
$config = include "config.php";
$service = new SampleService($config);
$service->run();
