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


use org\haf\ivs\Ivs;
use org\haf\ivs\Object;

/**
 * Class PackedBallot
 *
 * @package org\haf\ivs\ballot
 */
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

    /** @var  mixed */
    private $extendedInfo;

    /**
     * @param string $electionId
     * @param string $signerId
     * @param string $encryptedData
     * @param string $signature
     * @param mixed $info
     */
    function __construct($electionId = null, $signerId = null, $encryptedData = null, $signature = null, $info = null)
    {
        $this->electionId    = $electionId;
        $this->encryptedData = $encryptedData;
        $this->signature     = $signature;
        $this->signerId      = $signerId;
        $this->extendedInfo  = $info;
    }

    /**
     * @return mixed
     */
    public function getExtendedInfo()
    {
        return $this->extendedInfo;
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

    /**
     * @return bool|\string[]
     */
    public function getPropertiesName() {
        return FALSE;
    }

    /**
     * @return array|null
     */
    public function getConstructParams() {
        return array(
            $this->electionId, $this->signerId,
            $this->encryptedData, $this->signature,
            $this->extendedInfo
        );
    }

    /**
     * @param mixed $info
     */
    public function setExtendedInfo($info)
    {
        $this->extendedInfo = $info;
    }
}