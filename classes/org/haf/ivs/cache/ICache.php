<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 2:40 PM
 */

namespace org\haf\ivs\cache;


interface ICache
{
    public function get($key);

    public function set($key, $value);

    public function remove($key);
}