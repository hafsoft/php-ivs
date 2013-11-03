<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 9:17 PM
 */

namespace org\haf\ivs\voteBooth;

use org\haf\ivs\ballot\Ballot;
use org\haf\ivs\Object;

class VoteBooth extends Object implements IVoteBooth
{

    /** @var  string */
    private $id;

    /** @var  \org\haf\ivs\key\IPrivateKey */
    private $privateKey;

    /** @var  \org\haf\ivs\key\IPublicKey */
    private $publicKey;

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \org\haf\ivs\key\IPrivateKey $privateKey
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @return \org\haf\ivs\key\IPrivateKey
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @param \org\haf\ivs\key\IPublicKey $publicKey
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
    }

    /**
     * @return \org\haf\ivs\key\IPublicKey
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }


    /**
     * @param \org\haf\ivs\candidate\ICandidate $candidate
     * @return Ballot
     */
    function createBallotForCandidate($candidate)
    {
        $ballot = new Ballot();
        $ballot->setCandidate($candidate);
        $ballot->setSigner($this);
        return $ballot;
    }
}