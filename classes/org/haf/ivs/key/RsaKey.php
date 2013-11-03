<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 9:12 PM
 */

namespace org\haf\ivs\key;


use org\haf\ivs\Object;

abstract class RsaKey extends Object implements Ikey
{
    protected $keyString;

    public function __construct($filename = null)
    {
        if ($filename) {
            $this->keyString = file_get_contents($filename);
        }
    }


    protected function getPropertiesName()
    {
        return array('keyString');
    }
}