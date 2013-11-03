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
use org\haf\ivs\Ivs;
use org\haf\ivs\tool\Security;
use org\haf\ivs\voteBooth\IVoteBooth;

class Ballot implements IBallot
{
    const STR_HEADER = 'ivt-ballot';

    /** @var  ICandidate */
    private $candidate;

    /** @var IVoteBooth */
    private $signer;

    /** @var  bool */
    private $verified;

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
     * @return IPackedBallot
     */
    public function pack()
    {
        $election      = $this->candidate->getElection();
        $json_data     = json_encode(array(
            'cid'  => $this->candidate->getId(),
            'eid'  => $election->getId(),
            'salt' => Security::generateSalt(32),
        ));
        $encryptedData = $election->getPublicKey()->encryptData($json_data);
        $signature     = $this->signer->getPrivateKey()->sign($encryptedData);

        $packedBallot = new PackedBallot();
        $packedBallot->setElectionId($election->getId());
        $packedBallot->setSignerId($this->signer->getId());
        $packedBallot->setEncryptedData($encryptedData);
        $packedBallot->setSignature($signature);
        return $packedBallot;
    }

    /**
     * @param IVoteBooth $signer
     */
    public function setSigner($signer)
    {
        $this->signer = $signer;
    }

    /**
     * @return ICandidate
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * @return IVoteBooth
     */
    public function getSigner()
    {
        return $this->signer;
    }

    /**
     * @param ICandidate $candidate
     */
    public function setCandidate($candidate)
    {
        $this->candidate = $candidate;
    }

}