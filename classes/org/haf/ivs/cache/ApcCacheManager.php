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


use org\haf\ivs\Ivs;

/**
 * Class ApcCacheManager
 *
 * @package org\haf\ivs\cache
 */
class ApcCacheManager extends AbstractCacheManager implements ICacheManager {

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return apc_fetch($key);
    }

    /**
     * @param $key
     * @param $value
     * @param int $ttl
     */
    public function set($key, $value, $ttl = 0)
    {
        apc_store($key, $value, $ttl);
    }

    /**
     * @param $key
     */
    public function remove($key)
    {
        apc_delete($key);
    }
}