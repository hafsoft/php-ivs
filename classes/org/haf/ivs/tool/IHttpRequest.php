<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/2/13 1:01 PM
 */

namespace org\haf\ivs\tool;


interface IHttpRequest
{
    /**
     * @param string $method
     * @param string $url
     * @return bool
     */
    public function open($method, $url);

    /**
     * @param $name
     * @param $value
     */
    public function addHeader($name, $value);

    /**
     * @param $name
     * @param $value
     */
    public function replaceHeader($name, $value);

    /**
     * @param string $data
     * @return string
     */
    public function send($data);

    /**
     * close connection
     */
    public function close();
}