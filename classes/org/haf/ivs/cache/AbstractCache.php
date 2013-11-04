<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/3/13 3:50 PM
 */

namespace org\haf\ivs\cache;


use org\haf\ivs\IObject;

abstract class AbstractCache implements ICache {

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
     * @param IObject $object
     */
    public function putObject($type, $id, $object)
    {
        $this->set($this->getObjectCacheName($type, $id), $object);
    }
}