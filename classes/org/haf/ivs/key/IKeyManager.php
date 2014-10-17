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


namespace org\haf\ivs\key;

use org\haf\ivs\IManager;

/**
 * Class IKeyManager
 *
 * @package org\haf\ivs\key
 */
interface IKeyManager extends IManager
{
    /**
     * @param string $signerId
     * @return IPrivateKey|null
     */
    public function getSignerPrivateKey($signerId);

    /**
     * @param string $signerId
     * @return IPublicKey|null
     */
    public function getSignerPublicKey($signerId);

    /**
     * @param $electionId
     * @return IPrivateKey|null
     */
    public function getElectionPrivateKey($electionId);

    /**
     * @param $electionId
     * @return IPublicKey|null
     */
    public function getElectionPublicKey($electionId);

}