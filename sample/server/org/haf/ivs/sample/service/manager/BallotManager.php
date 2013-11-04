<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/3/13 10:21 AM
 */

namespace org\haf\ivs\sample\service\manager;

use org\haf\ivs\AbstractManager;
use org\haf\ivs\ballot\BallotException;
use org\haf\ivs\ballot\IBallotIterator;
use org\haf\ivs\ballot\IBallotManager;
use org\haf\ivs\ballot\IPackedBallot;
use org\haf\ivs\election\IElection;
use org\haf\ivs\sample\service\tally\BallotFileIterator;

class BallotManager extends AbstractManager implements IBallotManager {

    /**
     * // must be atomic: all or nothing
     *
     * @param IPackedBallot[] $packedBallot
     * @throws \org\haf\ivs\ballot\BallotException
     * @return bool
     */
    public function savePackedBallots($packedBallot)
    {
        $currentVoter = $this->ivs->getCurrentVoter();
        if ($currentVoter === NULL) {
           throw new BallotException(BallotException::ACCESS_DENIED, 'You do not have access to save the bullet');
        }

        $allowedElections = $currentVoter->getElections();

        foreach($packedBallot as &$ballot) {
            $ok = false;
            foreach ($allowedElections as $election) {
                if ($election->getId() === $ballot->getElectionId()) {
                    $ok = true;
                    break;
                }
            }
            if (! $ok) {
                throw new BallotException(BallotException::ACCESS_DENIED, 'You do not have access to vote "%s"', $ballot->getElectionId());
            }
            $str = json_encode(array(
                '_' => 'ballot',
                'e' => $ballot->getElectionId(),
                's' => $ballot->getSignerId(),
                'd' => $ballot->getEncryptedData(),
                'v' => $ballot->getSignature(),
            ));
            $fileName = time();
            do {
                $fileName = sprintf('ballots/%s/%s', $ballot->getElectionId(), md5($fileName . mt_rand(0, 999999)));
            } while(file_exists($fileName));

            file_put_contents($fileName, $str);
        }

        $this->ivs->getVoterManager()->logout($currentVoter->getSessionId());
        return TRUE;
    }

    /**
     * @param IElection $election
     * @return IBallotIterator
     */
    public function getIteratorByElection($election)
    {
        $directory = 'ballots/' . $election->getId();
        return new BallotFileIterator($directory);
    }

    public function getAllowedMethods() {
        return array('savePackedBallots');
    }
}