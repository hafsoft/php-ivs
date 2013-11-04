<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/5/13 12:19 AM
 */

namespace org\haf\ivs\cache;


class DummyCacheManager extends AbstractCache implements ICache {

    public function get($key)
    {
        return NULL;
    }

    public function set($key, $value)
    {

    }

    public function remove($key)
    {

    }
}