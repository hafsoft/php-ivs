<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/5/13 12:19 AM
 */

namespace org\haf\ivs\cache;


class DummyCacheManager extends AbstractCacheManager implements ICacheManager {

    public function get($key)
    {
        return NULL;
    }

    public function set($key, $value, $ttl = 0)
    {

    }

    public function remove($key)
    {

    }
}