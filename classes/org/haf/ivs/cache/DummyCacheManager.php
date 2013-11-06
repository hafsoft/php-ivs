<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/5/13 12:19 AM
 */

namespace org\haf\ivs\cache;


use org\haf\ivs\Ivs;

class DummyCacheManager extends AbstractCacheManager implements ICacheManager {

    private $cache = array();

    public function &get($key)
    {
        static $null = NULL;

        if (isset($this->cache[$key])) {
            return $this->cache[$key];
        } else {

        }
        return $null;
    }

    public function set($key, $value, $ttl = 0)
    {
        $this->cache[$key] =& $value;
    }

    public function remove($key)
    {
        unset($this->cache[$key]);
    }

}