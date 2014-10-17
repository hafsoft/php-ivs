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


/**
 * Class FileCacheManager
 *
 * @package org\haf\ivs\cache
 */
class FileCacheManager extends AbstractCacheManager implements ICacheManager
{
    /** @var  string */
    private $cacheDir;

    public function __construct($parent, $config = null) {
        parent::__construct($parent, $config);
        $this->setCacheDir($config['dir']);
    }

    public function setCacheDir($dir)
    {
        $this->cacheDir = $dir;
        if (!is_dir($dir)) {
            @mkdir($dir);
            @chmod($dir, 0700);
        }
    }

    private function getCacheFileName($key)
    {
        return $this->cacheDir . '/' . $key;
    }

    public function get($key)
    {
        $file = $this->getCacheFileName($key);
        if (file_exists($file)) {
            $obj = unserialize(file_get_contents($file));
            if (time() < $obj['t']) {
                return $obj['o'];
            } else {
                unlink($file);
            }
        }

        return null;
    }

    public function set($key, $value, $ttl = 0)
    {
        $file = $this->getCacheFileName($key);
        $obj = array(
            'o' => $value,
            't' => $ttl <= 0 ? 0xffffffff : time() + $ttl,
        );
        file_put_contents($file, serialize($obj));
    }

    public function remove($key)
    {
        $file = $this->getCacheFileName($key);
        if (file_exists($file))
            unlink($file);
    }
}