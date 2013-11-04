<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 2:07 PM
 */

namespace org\haf\ivs\election;


use org\haf\ivs\candidate\CandidateException;
use org\haf\ivs\candidate\ICandidate;
use org\haf\ivs\Ivs;
use org\haf\ivs\key\IPrivateKey;
use org\haf\ivs\key\IPublicKey;
use org\haf\ivs\Object;

class Election extends Object implements IElection
{

    /** @var string $id */
    protected $id;

    /** @var string */
    protected $name;

    /** @var  mixed */
    protected $info;

    /** @var  ICandidate[] */
    protected $candidates = null;

    /** @var  IPrivateKey */
    protected $privateKey = null;

    /** @var  IPublicKey */
    protected $publicKey = null;

    /**
     * @param ICandidate[] $candidates
     */
    public function setCandidates($candidates)
    {
        $this->candidates = $candidates;
    }

    /**
     * @return ICandidate[]
     */
    public function &getCandidates()
    {
        return $this->candidates;
    }

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
     * @param mixed $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param IPrivateKey $privateKey
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @return IPrivateKey
     */
    public function &getPrivateKey()
    {
        if ($this->privateKey == null) {
            $this->privateKey = Ivs::app()->getKeyManager()->getElectionPrivateKey($this->id);
        }
        return $this->privateKey;
    }

    /**
     * @param IPublicKey $publicKey
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
    }

    /**
     * @return IPublicKey
     */
    public function &getPublicKey()
    {
        if ($this->publicKey == null) {
            $this->publicKey = Ivs::app()->getKeyManager()->getElectionPublicKey($this->id);
        }
        return $this->publicKey;
    }


    /**
     * @param string $id
     * @return ICandidate
     * @throws CandidateException
     */
    public function &getCandidateById($id)
    {
        foreach ($this->getCandidates() as $candidate) {
            if ($candidate->getId() == $id) {
                return $candidate;
            }
        }
        throw new CandidateException(
            CandidateException::NOT_FOUND,
            "Candidate $id not found in election " . $this->getId()
        );
    }

    public function getProperties(){
        $props = parent::getProperties();
        if (Ivs::app()->isRemoteCall()) {
            unset($props['privateKey']);
        }
        return $props;
    }
}