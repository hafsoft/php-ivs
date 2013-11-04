<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 11:16 AM
 */

namespace org\haf\ivs\ballot;

use org\haf\ivs\election\IElection;
use org\haf\ivs\IManager;

interface IBallotManager extends IManager
{

    /**
     * @param IPackedBallot[] $packedBallot
     * @return bool
     */
    public function savePackedBallots($packedBallot);

    /**
     * @param IElection $election
     * @return IBallotIterator
     */
    public function getIteratorByElection($election);
}