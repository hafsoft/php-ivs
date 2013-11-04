<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 3:09 PM
 */

namespace org\haf\ivs;


interface IManager
{

    /**
     * @param Ivs $parent
     * @param null|mixed $config
     */
    public function __construct($parent, $config = null);

    /**
     * @param string $methodName
     * @return bool
     */
    public function isMethodAllowed($methodName);
}