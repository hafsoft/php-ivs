<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 11:11 AM
 * @package org.hav.ivs.ballot
 */

namespace org\haf\ivs\ballot;

use org\haf\ivs\candidate\ICandidate;
use org\haf\ivs\election\IElection;
use org\haf\ivs\Ivs;
use org\haf\ivs\tool\Security;

class Ballot implements IBallot
{
    const STR_HEADER = 'ivt-ballot';

    /** @var IElection  */
    private $election;

    /** @var  ICandidate */
    private $candidate;

    /** @var IBallotSigner */
    private $signer;

    /** @var  bool */
    private $verified;

    /**
     * @param IElection $election
     * @param ICandidate $candidate
     * @param IBallotSigner $signer
     */
    public function __construct($election = null, $candidate = null, $signer = null) {
        $this->election = $election;
        $this->candidate = $candidate;
        $this->signer = $signer;
    }

    /**
     * @param boolean $verified
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;
    }

    /**
     * @return boolean
     */
    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * @param IBallotSigner $signer
     */
    public function setSigner($signer)
    {
        $this->signer =& $signer;
    }

    /**
     * @return ICandidate
     */
    public function &getCandidate()
    {
        return $this->candidate;
    }

    /**
     * @return IBallotSigner
     */
    public function &getSigner()
    {
        return $this->signer;
    }

    /**
     * @param ICandidate $candidate
     */
    public function setCandidate($candidate)
    {
        $this->candidate =& $candidate;
    }

}