<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 2:40 PM
 */

namespace org\haf\ivs\cache;


use org\haf\ivs\IObject;

interface ICache
{
    public function get($key);

    public function set($key, $value);

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
     */
    public function putObject($type, $id, $object);
}