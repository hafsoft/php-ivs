<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 10:30 AM
 */

namespace org\haf\ivs\key;

interface IPrivateKey extends Ikey
{
    /**
     * @param $password
     * @return boolean
     * @throws KeyException
     */
    public function lock($password);

    /**
     * @param $password
     * @return boolean
     * @throws KeyException
     */
    public function unlock($password);


    /**
     * @param string $data data to sing
     * @return string signature
     * @throws KeyException
     */
    public function sign($data);

}