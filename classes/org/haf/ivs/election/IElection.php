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
use org\haf\ivs\IObject;
use org\haf\ivs\key\IPrivateKey;
use org\haf\ivs\key\IPublicKey;

/**
 * Class IElection
 *
 * @package org\haf\ivs\election
 */
interface IElection extends IObject
{

    /**
     * @return string
     */
    public function getId();

    /**
     * return the name of the service
     *
     * @return string Description
     */
    public function getName();

    /**
     * @return int
     */
    public function getStartTime();

    /**
     * @return int
     */
    public function getStopTIme();

    /**
     * @return ICandidate[]
     * @throws CandidateException
     */
    public function getCandidates();

    /**
     * @param string $id
     * @return ICandidate
     * @throws CandidateException
     */
    public function getCandidateById($id);


    /**
     * the private key for counting bullet
     *
     * @return IPrivateKey
     */
    public function getPrivateKey();

    /**
     * @return IPublicKey key for encrypting bullet
     */
    public function getPublicKey();

}
