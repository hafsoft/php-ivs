<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/4/13 10:22 AM
 */

define('DEBUG', 1);

include_once __DIR__ . '/../../classes/loader.php';
include_once __DIR__ . '/loader.php';

$config = include "config.php";
$tally = new \org\haf\ivs\sample\service\SampleTally($config);
$election = $tally->getElectionManager()->getById(1);
$election->getPrivateKey()->unlock('4213');
$tally->startCounting($election);
