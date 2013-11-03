<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 10:31 AM
 */
namespace org\haf\ivs\key;
interface IPublicKey extends Ikey
{
    /**
     * @param string $data
     * @param string $signature
     * @return boolean
     */
    public function verify($data, $signature);
}