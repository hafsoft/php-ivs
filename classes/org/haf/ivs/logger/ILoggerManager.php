<?php
/**
 * php-ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/5/13 10:25 AM
 */

namespace org\haf\ivs\logger;


use org\haf\ivs\IManager;

interface ILoggerManager extends IManager {

    /**
     * @param string $str
     */
    public function log($str);

    /**
     * @param string $str
     * @param mixed[] $args
     */
    public function logArgs($str, $args);
}