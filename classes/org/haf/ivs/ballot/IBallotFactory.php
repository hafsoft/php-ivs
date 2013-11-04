<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 11:02 AM
 */

namespace org\haf\ivs\ballot;

use org\haf\ivs\candidate\ICandidate;
use org\haf\ivs\voteBooth\IVoteBooth;

interface IBallotFactory
{
    /**
     * @param ICandidate $candidate
     * @param  IVoteBooth $signer
     * @return IBallot
     */
    public function createBallot($candidate, $signer);

    public function packBallot($ballot);

    /**
     * @param IPackedBallot $packedBallot
     * @return IBallot
     */
    public function unpackBallot($packedBallot);
}