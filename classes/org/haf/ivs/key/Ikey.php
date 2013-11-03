<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 10:28 AM
 */

namespace org\haf\ivs\key;

use org\haf\ivs\IObject;

interface Ikey extends IObject
{
    const KEY_LOCKED = 'keyLocked';

    /**
     * @param string $data  decrypted data
     * @return string encrypted data
     */
    public function encryptData($data);

    /**
     * @param string $data encrypted data
     * @return string decrypted data
     */
    public function decryptData($data);
}