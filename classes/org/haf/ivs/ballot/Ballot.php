<?php
/**
 * HafSoft Integrated Voting System
 * Copyright (c) 2013 Abi Hafshin Alfarouq
 * < abi [dot] hafshin [at] ui [dot] ac [dot] id >
 *
 * php-ivs is php wrapper for HafSoft Integrated Voting System.
 * more info: http://github.com/hafsoft/php-ivs
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

namespace org\haf\ivs\ballot;

use org\haf\ivs\candidate\ICandidate;
use org\haf\ivs\election\IElection;
use org\haf\ivs\Ivs;
use org\haf\ivs\tool\Security;

/**
 * Class Ballot
 *
 * @package org\haf\ivs\ballot
 */
class Ballot implements IBallot
{
    /** @var IElection  */
    private $election;

    /** @var  ICandidate */
    private $candidate;

    /** @var IBallotSigner */
    private $signer;

    /** @var  bool */
    private $verified;

    /** @var  mixed */
    private $extendedInfo;

    /**
     * @param IElection $election
     * @param ICandidate $candidate
     * @param IBallotSigner $signer
     * @param mixed $extendedInfo
     */
    public function __construct($election = null, $candidate = null, $signer = null, $extendedInfo = null) {
        $this->election = $election;
        $this->candidate = $candidate;
        $this->signer = $signer;
        $this->extendedInfo = $extendedInfo;
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

    /**
     * @return mixed
     */
    public function getExtendedInfo()
    {
        return $this->extendedInfo;
    }

    /**
     * @param mixed $extendedInfo
     */
    public function setExtendedInfo($extendedInfo)
    {
        $this->extendedInfo = $extendedInfo;
    }

}