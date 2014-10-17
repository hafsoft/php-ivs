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

namespace org\haf\ivs\cache;


use org\haf\ivs\IManager;
use org\haf\ivs\IObject;

/**
 * Class ICacheManager
 *
 * @package org\haf\ivs\cache
 */
interface ICacheManager extends IManager
{
    /**
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     */
    public function set($key, $value, $ttl = 0);

    /**
     * @param $key
     * @return mixed
     */
    public function remove($key);

    /**
     * @param string $type
     * @param string $id
     * @return IObject
     */
    public function fetchObject($type, $id);

    /**
     * @param string $type
     * @param string $id
     * @param IObject $object
     * @param int $ttl
     */
    public function putObject($type, $id, $object, $ttl = 0);
}