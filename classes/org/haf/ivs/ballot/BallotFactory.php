<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 11:01 AM
 */

namespace org\haf\ivs\ballot;

use org\haf\ivs\candidate\ICandidate;
use org\haf\ivs\voteBooth\IVoteBooth;

class BallotFactory implements IBallotFactory
{

    /**
     * @param ICandidate $candidate
     * @param IVoteBooth $signer
     * @return IBallot|void
     */
    public function createBallot($candidate, $signer)
    {

    }
}