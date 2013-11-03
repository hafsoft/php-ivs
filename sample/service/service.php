<?php

//ini_set('s')
ini_set('display_error', TRUE);
error_reporting(E_ALL);

define('DEBUG', 1);

include_once __DIR__ . '/../../classes/loader.php';
include_once __DIR__ . '/loader.php';

$service = new \org\haf\ivs\sample\service\SampleService(array(
    'manager' => array(
        'IElectionManager' => 'org\haf\ivs\sample\service\manager\ElectionManager',
        'IVoterManager' => 'org\haf\ivs\sample\service\manager\VoterManager',
        'IBallotManager' => 'org\haf\ivs\sample\service\manager\BallotManager',
        'IVoteBoothManager' => 'org\haf\ivs\sample\service\manager\VoteBoothManager',
    )
));
$service->run();
