<?php
/**
 * HafSoft Integrated Voting System
 * Copyright (c) 2013 Abi Hafshin Alfarouq
 * < abi [dot] hafshin [at] ui [dot] ac [dot] id >
 *
 * php-ivs is php wrapper for HafSoft Integrated Voting System.
 * more info: http://github.com/hafsoft/php-ivs
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

namespace org\haf\ivs\key;

use org\haf\ivs\Object;

/**
 * this class ...
 *
 * @package org\haf\ivs\key
 */
class RsaPublicKey extends RsaKey implements IPublicKey
{

    private $key;

    /**
     * @return resource
     */
    protected function getKey() {
        if ($this->key === null) {
            /** @noinspection PhpVoidFunctionResultUsedInspection */
            $this->key = openssl_pkey_get_public($this->keyString);
        }
        return $this->key;
    }

    /**
     * @param string $data
     * @param string $signature
     * @return boolean
     */
    public function verify($data, $signature)
    {
        return openssl_verify($data, base64_decode($signature), $this->getKey());
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
        if (openssl_public_encrypt($data, $encrypted, $this->getKey())) {
            return base64_encode($encrypted);
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
        if (openssl_public_decrypt(base64_decode($data), $decrypted, $this->getKey())) {
            return $decrypted;
        }
        throw new KeyException();
    }
}