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
use org\haf\ivs\ballot\IBallotIterator;
use org\haf\ivs\ballot\IBallotManager;
use org\haf\ivs\ballot\IPackedBallot;
use org\haf\ivs\election\IElection;

class BallotManager extends AbstractManager implements IBallotManager {

    /**
     * @param IPackedBallot $ballot
     * @return boolean
     */
    public function savePackedBallot($ballot)
    {
        // TODO: Implement savePackedBallot() method.
    }

    /**
     * @param IPackedBallot[] $ballots
     * @return bool
     */
    public function savePackedBallots($ballots)
    {
        // TODO: Implement savePackedBallots() method.
    }

    /**
     * @param IElection $election
     * @return IBallotIterator
     */
    public function getIteratorForElection($election)
    {
        // TODO: Implement getIteratorForElection() method.
    }
}