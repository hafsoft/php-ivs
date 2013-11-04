<?php
/**
 * ivs
 * copyright (c) 2013 abie
 *
 * @author abie
 * @date 11/1/13 10:35 AM
 */

namespace org\haf\ivs\key;


use org\haf\ivs\Object;

class RsaPrivateKey extends RsaKey implements IPrivateKey
{
    const SIGN_ERROR = 'signError';

    private $key;

    /**
     * @return resource
     */
    protected function getKey() {
        if ($this->key === null) {
            /** @noinspection PhpVoidFunctionResultUsedInspection */
            $this->key = openssl_get_privatekey($this->keyString);
        }
        return $this->key;
    }

    /**
     * @return bool
     */
    public function locked()
    {
        return $this->getKey() == false;
    }

    /**
     * @param $password
     * @return boolean
     * @throws KeyException
     */
    public function lock($password)
    {
        // todo: benerin
        return true;
    }

    /**
     * @param $password
     * @return boolean
     * @throws KeyException
     */
    public function unlock($password)
    {
        if ($this->locked()) {
            /** @noinspection PhpVoidFunctionResultUsedInspection */
            $key = openssl_get_privatekey($this->keyString, $password);
            if ($key) {
                $this->key = $key;
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * @param string $data data to sing
     * @return string signature
     * @throws KeyException
     */
    public function sign($data)
    {
        if ($this->locked())
            throw new KeyException('Key Locked', self::KEY_LOCKED);

        $signature = null;
        $success   = openssl_sign($data, $signature, $this->key);
        if ($success) {
            return base64_encode($signature);
        } else {
            throw new KeyException("Sign Error", self::SIGN_ERROR);
        }
    }

    /**
     * @param string $data  decrypted data
     * @throws KeyException
     * @return string encrypted data
     */
    public function encryptData($data)
    {
        if ($this->locked())
            throw new KeyException('Key Locked', self::KEY_LOCKED);

        $encryptedData = null;
        if (openssl_private_encrypt($data, $encryptedData, $this->key)) {
            return base64_encode($encryptedData);
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
        if ($this->locked())
            throw new KeyException('Key Locked', self::KEY_LOCKED);

        $decryptedData = null;
        if (openssl_private_decrypt(base64_decode($data), $decryptedData, $this->key)) {
            return $decryptedData;
        }

        throw new KeyException();
    }

}