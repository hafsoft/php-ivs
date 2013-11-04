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
     * @param null $electionId
     * @param null $signerId
     * @param null $encryptedData
     * @param null $signature
     * @param null $signature
     */
    function __construct($electionId = null, $signerId = null, $encryptedData = null, $signature = null)
    {
        $this->electionId    = $electionId;
        $this->encryptedData = $encryptedData;
        $this->signature     = $signature;
        $this->signerId      = $signerId;
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

    public function getPropertiesName() {
        return FALSE;
    }

    public function getConstructParams() {
        return array(
            $this->electionId, $this->signerId,
            $this->encryptedData, $this->signature
        );
    }
}