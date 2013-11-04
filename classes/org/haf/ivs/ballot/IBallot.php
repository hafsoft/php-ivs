<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 11:00 AM
 */

namespace org\haf\ivs\ballot;

use org\haf\ivs\candidate\ICandidate;
use org\haf\ivs\voteBooth\IVoteBooth;

interface IBallot
{

    /**
     * @return ICandidate
     */
    public function getCandidate();

    /**
     * @return IBallotSigner
     */
    public function getSigner();

    /**
     * @return boolean
     */
    public function isVerified();
}