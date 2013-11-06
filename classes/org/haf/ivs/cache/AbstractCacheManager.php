<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/3/13 3:50 PM
 */

namespace org\haf\ivs\cache;


use org\haf\ivs\AbstractManager;
use org\haf\ivs\IObject;

abstract class AbstractCacheManager implements ICacheManager {


    /**
     * @param Ivs $parent
     * @param null|mixed $config
     */
    public function __construct($parent, $config = null)
    {
        // TODO: Implement __construct() method.
    }

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


    public function isMethodAllowed($methodName) {
        return false;
    }
}