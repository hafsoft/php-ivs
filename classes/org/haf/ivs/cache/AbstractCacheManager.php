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


use org\haf\ivs\AbstractManager;
use org\haf\ivs\IObject;

/**
 * Class AbstractCacheManager
 *
 * @package org\haf\ivs\cache
 */
abstract class AbstractCacheManager implements ICacheManager {

    /**
     * @param \org\haf\ivs\Ivs $parent
     * @param null $config
     */
    public function __construct($parent, $config = null) {

    }

    /**
     * get cache name for object typed $type
     *
     * @param $type
     * @param $id
     * @return string
     */
    protected function getObjectCacheName($type, $id) {
        return "ivs:$type:$id";
    }

    /**
     * @param string $type
     * @param string $id
     * @return IObject
     */
    public function fetchObject($type, $id)
    {
        return $this->get($this->getObjectCacheName($type, $id));
    }

    /**
     * @param string $type
     * @param string $id
     * @param \org\haf\ivs\IObject $object
     * @param int $ttl
     */
    public function putObject($type, $id, $object, $ttl = 0)
    {
        $this->set($this->getObjectCacheName($type, $id), $object, $ttl);
    }


    /**
     * Always disallow remote call
     *
     * @param string $methodName
     * @return bool
     */
    public function isRemoteAllowed($methodName) {
        return false;
    }
}