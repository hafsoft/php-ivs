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

namespace org\haf\ivs\election;

use org\haf\ivs\candidate\CandidateException;
use org\haf\ivs\candidate\ICandidate;
use org\haf\ivs\Ivs;
use org\haf\ivs\key\IPrivateKey;
use org\haf\ivs\key\IPublicKey;
use org\haf\ivs\Object;

/**
 * Class Election
 *
 * @package org\haf\ivs\election
 */
class Election extends Object implements IElection
{

    /** @var string $id */
    protected $id = null;

    /** @var string */
    protected $name = null;

    /** @var  mixed */
    protected $info = array();

    /** @var  ICandidate[] */
    protected $candidates = array();

    /** @var int */
    protected $startTime = 0;

    /** @var int */
    protected $stopTime = 0;

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
     * @param int $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param int $stopTime
     */
    public function setStopTime($stopTime)
    {
        $this->stopTime = $stopTime;
    }

    /**
     * @return int
     */
    public function getStopTime()
    {
        return $this->stopTime;
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