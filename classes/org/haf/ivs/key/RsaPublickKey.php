<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 10:49 AM
 */

namespace org\haf\ivs\key;

use org\haf\ivs\Object;

class RsaPublicKey extends RsaKey implements IPublicKey
{

    private $key;

    public function __construct($filename = null)
    {
        parent::__construct($filename);

        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $this->key = openssl_get_publickey($this->keyString);
    }

    /**
     * @param string $data
     * @param string $signature
     * @return boolean
     */
    public function verify($data, $signature)
    {
        return openssl_verify($data, $signature, $this->key);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->keyString;
    }

    /**
     * @param string $data  decrypted data
     * @throws KeyException
     * @return string encrypted data
     */
    public function encryptData($data)
    {
        if (openssl_public_encrypt($data, $encrypted, $this->key)) {
            return $encrypted;
        }
        throw new KeyException();
    }

    /**
     * @param string $data encrypted data
     * @throws KeyException
     * @return string decrypted data
     */
    public function decryptData($data)
    {
        if (openssl_public_decrypt($data, $decrypted, $this->key)) {
            return $decrypted;
        }
        throw new KeyException();
    }
}