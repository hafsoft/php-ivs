<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/3/13 9:41 AM
 */

namespace org\haf\ivs\ballot;


use org\haf\ivs\Ivs;
use org\haf\ivs\Object;

class PackedBallot extends Object implements IPackedBallot
{

    /** @var  string */
    private $signature;

    /** @var  string */
    private $signerId;

    /** @var  string */
    private $electionId;

    /** @var  string */
    private $encryptedData;

    /**
     * @return IBallot
     */
    public function unpack()
    {

        $election = Ivs::$instance->getElectionManager()->getFromId($this->electionId);
        $jsonData = $election->getPrivateKey()->decryptData($this->encryptedData);
        $data     = json_decode($jsonData, true);
        if ($data['eid'] !== $this->electionId) {
            // TODO: apa??
        }
        $candidate = $election->getCandidateById($data['cid']);
        $signer    = Ivs::$instance->getVoteBothManager()->getById($this->signerId);
        $verified  = $signer->getPublicKey()->verify($this->encryptedData, $this->signature);

        $ballot = new Ballot();
        $ballot->setCandidate($candidate);
        $ballot->setSigner($signer);
        $ballot->setVerified($verified);

        return $ballot;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return string
     */
    public function getSignerId()
    {
        return $this->signerId;
    }

    /**
     * @return string
     */
    public function getElectionId()
    {
        return $this->electionId;
    }

    /**
     * @param string $electionId
     */
    public function setElectionId($electionId)
    {
        $this->electionId = $electionId;
    }

    /**
     * @param string $signature
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    /**
     * @param string $signerId
     */
    public function setSignerId($signerId)
    {
        $this->signerId = $signerId;
    }

    /**
     * @param string $encryptedData
     */
    public function setEncryptedData($encryptedData)
    {
        $this->encryptedData = $encryptedData;
    }

    /**
     * @return string
     */
    public function getEncryptedData()
    {
        return $this->encryptedData;
    }


}