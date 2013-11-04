<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/4/13 5:15 PM
 */

namespace org\haf\ivs\cache;


use org\haf\ivs\Ivs;

class ApcCacheManager extends AbstractCacheManager implements ICacheManager {

    public function get($key)
    {
        return apc_fetch($key);
    }

    public function set($key, $value, $ttl = 0)
    {
        apc_store($key, $value, $ttl);
    }

    public function remove($key)
    {
        apc_delete($key);
    }
}