<?php

include_once __DIR__ . '/../../classes/loader.php';

$client = new \org\haf\ivs\IvsClient('http://localhost/ivs/sample/service/service.php');

/*
echo "get VoteBooth: \n";
$voteBooth = $client->getVoteBothManager()->getById('1');
var_dump($voteBooth);
echo "\n\n";

echo "Unlock Key: \n";
$result = $voteBooth->getPrivateKey()->unlock('password');
var_dump($result);
echo "\n\n";
*/


echo "Authenticating with token: \n";
$voter = $client->getVoterManager()->authenticate(
    'token',
    array('username' => 'abi.hafshin', 'password' => 'pass', 'token' => '12345')
);
var_dump($voter);
echo "\n\n";


echo "Get Elections from Voter: \n";
$elections = $voter->getElections();
var_dump($elections);
echo "\n\n";

/*
echo "Get one Election: \n";
$election = $client->getElectionManager()->getFromId('1');
var_dump($election);
echo "\n\n";
*/

echo "Select Candidate, and then create ballot: \n";
$ballots = array();
foreach($elections as $election) {
    $candidates = $election->getCandidates();
    $candidate_count = count($candidates);
    $cIdx = rand(-2, $candidate_count);
    if ($cIdx >= 0) {
        $ballot = $voteBooth->createBallotForCandidate($candidates[$cIdx]);
        $ballots[] = $ballot->pack();
    }
}
var_dump($ballots);
echo "\n\n";

echo "Send ballot: \n";
$result = $client->getBallotManager()->savePackedBallots($ballots);