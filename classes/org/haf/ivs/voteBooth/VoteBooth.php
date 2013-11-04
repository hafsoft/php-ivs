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
use org\haf\ivs\ballot\IBallotSigner;
use org\haf\ivs\Ivs;
use org\haf\ivs\Object;

class VoteBooth extends Object implements IVoteBooth
{

    /** @var  string */
    protected $id;

    /** @var  \org\haf\ivs\key\IPrivateKey */
    protected $privateKey = null;

    /** @var  \org\haf\ivs\key\IPublicKey */
    protected $publicKey = null;

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
    public function &getPrivateKey()
    {
        if ($this->privateKey == null) {
            $this->privateKey = Ivs::$instance->getKeyManager()->getSignerPrivateKey($this->getId());
        }
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
    public function &getPublicKey()
    {
        if ($this->publicKey == null) {
            $this->publicKey = Ivs::$instance->getKeyManager()->getSignerPublicKey($this->getId());
        }
        return $this->publicKey;
    }
}