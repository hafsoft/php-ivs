<?php
define('DEBUG', TRUE);

include_once __DIR__ . '/../../classes/loader.php';

$client = new \org\haf\ivs\IvsClient('http://localhost/ivs/sample/server/service.php');

try {
    echo "get VoteBooth: \n";
    $voteBooth = $client->getVoteBothManager()->getById('1');
    var_dump($voteBooth);
    echo "\n\n";

    echo "Unlock Key: \n";
    $result = $voteBooth->getPrivateKey()->unlock('1743');
    var_dump($result);
    echo "\n\n";


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
    $packedBallots = array();
    foreach($elections as &$election) {
        $candidates = $election->getCandidates();
        $candidate_count = count($candidates);
        $cIdx = rand(-1, $candidate_count - 1);
        if ($cIdx >= 0) {
            $factory = new \org\haf\ivs\ballot\BallotFactory($election);
            $ballot = $factory->createBallot($candidates[$cIdx], $voteBooth);
            $packedBallots[] = $factory->packBallot($ballot);
        }

    }
    var_dump($packedBallots);
    echo "\n\n";

    echo "Send ballot: \n";
    $client->setCurrentVoter($voter);
    $result = $client->getBallotManager()->savePackedBallots($packedBallots);
    var_dump($result);
}
catch (Exception $e) {
    throw $e;
}